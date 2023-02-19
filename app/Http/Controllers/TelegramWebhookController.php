<?php

namespace App\Http\Controllers;

use App\Http\Request\Assembler\Telegram\UpdateDTOAssembler;
use App\Http\Request\FormRequest\TelegramWebhookRequest;
use App\Infrastructure\Logger\TelegramWebhookLogger;
use App\Services\Telegram\TelegramWebhookService;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller;

class TelegramWebhookController extends Controller
{
    /**
     * @param TelegramWebhookRequest $request
     * @param UpdateDTOAssembler $updateDTOAssembler
     * @param TelegramWebhookService $webhookService
     * @param TelegramWebhookLogger $logger
     * @return Response|ResponseFactory
     */
    public function process(
        TelegramWebhookRequest $request,
        UpdateDTOAssembler $updateDTOAssembler,
        TelegramWebhookService $webhookService,
        TelegramWebhookLogger $logger
    ): Response|ResponseFactory {
        try {
            $params = $request->all();
            $update = $updateDTOAssembler->create($params);
            if ($update === null) {
                $logger->error('Error request', $params);
                return response('ok');
            }

            $webhookService->process($update);
        } catch (\Throwable $exception) {
            $logger->critical($exception->getMessage(), $exception->getTrace());
        } finally {
            return response('ok');
        }

    }
}
