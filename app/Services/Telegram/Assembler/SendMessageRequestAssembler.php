<?php

namespace App\Services\Telegram\Assembler;

use App\Infrastructure\Telegram\Client\Request\SendMessageRequest;
use App\Services\Telegram\DTO\MessageRequestDTO;

class SendMessageRequestAssembler
{
    public function create(MessageRequestDTO $requestDTO): SendMessageRequest
    {
        $fields = [
            'chat_id' => $requestDTO->getChatId(),
            'disable_web_page_preview' => $requestDTO->isDisableWebPagePreview(),
        ];

        $replyMarkup = $requestDTO->getReplyMarkup();
        if (!empty($replyMarkup)) {
            $fields['reply_markup'] = $replyMarkup;
        }

        $parseMode = $requestDTO->getParseMode();
        if (isset($parseMode)) {
            $fields['parse_mode'] = $parseMode;
        }

        $replyToMessageId = $requestDTO->getReplyToMessageId();
        if (isset($replyToMessageId)) {
            $fields['reply_to_message_id'] = $replyToMessageId;
        }

        $text = $requestDTO->getText();
        if (isset($text)) {
            $fields['text'] = $text;
        }

        return new SendMessageRequest($fields);
    }
}
