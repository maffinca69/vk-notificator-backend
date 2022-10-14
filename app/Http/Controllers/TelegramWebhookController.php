<?php

namespace App\Http\Controllers;

use App\Http\Request\Assembler\Telegram\UpdateDTOAssembler;
use App\Http\Request\FormRequest\TelegramWebhookRequest;
use App\Services\Telegram\TelegramWebhookService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller;

class TelegramWebhookController extends Controller
{
    /**
     * @param TelegramWebhookRequest $request
     * @param UpdateDTOAssembler $updateDTOAssembler
     * @param TelegramWebhookService $webhookService
     * @return Response|ResponseFactory
     */
    public function process(
        TelegramWebhookRequest $request,
        UpdateDTOAssembler $updateDTOAssembler,
        TelegramWebhookService $webhookService
    ): Response|ResponseFactory {
        try {
            $params = $request->all();
            $update = $updateDTOAssembler->create($params);
            if ($update === null) {
                Log::error(json_encode($params));
                return response('ok');
            }

            $webhookService->process($update);
        } catch (\Throwable $exception) {
            Log::info($exception->getMessage());
        } finally {
            return response('ok');
        }

    }
}
