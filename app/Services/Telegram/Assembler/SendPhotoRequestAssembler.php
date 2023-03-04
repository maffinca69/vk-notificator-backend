<?php

namespace App\Services\Telegram\Assembler;

use App\Infrastructure\Telegram\Client\Request\SendPhotoRequest;
use App\Services\Telegram\DTO\SendPhotoRequestDTO;

class SendPhotoRequestAssembler
{
    /**
     * @param SendPhotoRequestDTO $sendPhotoRequestDTO
     * @return SendPhotoRequest
     */
    public function create(SendPhotoRequestDTO $sendPhotoRequestDTO): SendPhotoRequest
    {
        $params = [
            'chat_id' => $sendPhotoRequestDTO->getChatId(),
            'photo' => $sendPhotoRequestDTO->getUrl(),
        ];

        $replyMarkup = $sendPhotoRequestDTO->getReplyMarkup();
        if (!empty($replyMarkup)) {
            $params['reply_markup'] = $replyMarkup;
        }

        $parseMode = $sendPhotoRequestDTO->getParseMode();
        if (!empty($parseMode)) {
            $params['parse_mode'] = $parseMode;
        }

        $caption = $sendPhotoRequestDTO->getCaption();
        if (!empty($caption)) {
            $params['caption'] = $caption;
        }

        return new SendPhotoRequest($params);
    }
}
