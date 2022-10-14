<?php

namespace App\Http\Controllers;

use App\Http\Request\Assembler\Telegram\UpdateDTOAssembler;
use App\Http\Request\FormRequest\TelegramWebhookRequest;
use Illuminate\Http\Response;
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
        UpdateDTOAssembler $updateDTOAssembler
    ): Response|ResponseFactory {
        $params = $request->all();
        $update = $updateDTOAssembler->create($params);
        if ($update === null) {
            return response('ok');
        }

        return response('ok');
    }
}
