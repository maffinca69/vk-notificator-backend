<?php

namespace App\Http\Controllers;

use App\Services\Telegram\Client\Assembler\SendMessageRequestAssembler;
use App\Http\Request\Assembler\Telegram\UpdateDTOAssembler;
use App\Http\Request\FormRequest\TelegramWebhookRequest;
use App\Services\Telegram\Client\HttpClient;
use App\Services\User\UserCreatingService;
use App\Services\VK\VKAuthMessageCreatingService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller;

class TelegramWebhookController extends Controller
{
    /**
     * @param TelegramWebhookRequest $request
     * @param UpdateDTOAssembler $updateDTOAssembler
     * @return Response|ResponseFactory
     */
    public function process(
        TelegramWebhookRequest $request,
        UpdateDTOAssembler $updateDTOAssembler,
        VKAuthMessageCreatingService $authMessageCreatingService,
        HttpClient $client,
        SendMessageRequestAssembler $sendMessageRequestAssembler,
        UserCreatingService $userCreatingService
    ): Response|ResponseFactory {
        try {
            $params = $request->all();
            $update = $updateDTOAssembler->create($params);
            if ($update === null) {
                return response('ok');
            }

            $userCreatingService->create($update);

            $oauthRequestMessage = $authMessageCreatingService->create($update);
            $request = $sendMessageRequestAssembler->create($oauthRequestMessage);
            $client->sendRequest($request);

        } catch (\Throwable $exception) {
            Log::info($exception->getMessage());
        } finally {
            return response('ok');
        }

    }
}
