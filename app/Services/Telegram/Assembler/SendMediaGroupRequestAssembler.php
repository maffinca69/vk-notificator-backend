<?php

namespace App\Services\Telegram\Assembler;

use App\Infrastructure\Telegram\Client\Request\SendMediaGroupRequest;
use App\Services\Telegram\DTO\InputMedia\InputMediaPhotoDTO;
use App\Services\Telegram\DTO\Request\MediaGroupRequestDTO;
use App\Services\Telegram\Hydrator\InputMediaPhotoDTOHydrator;

class SendMediaGroupRequestAssembler
{
    public function __construct(private InputMediaPhotoDTOHydrator $inputMediaPhotoHydrator)
    {
    }

    /**
     * @param MediaGroupRequestDTO $mediaGroupRequestDTO
     * @return SendMediaGroupRequest
     */
    public function create(MediaGroupRequestDTO $mediaGroupRequestDTO): SendMediaGroupRequest
    {
        $params = [
            'chat_id' => $mediaGroupRequestDTO->getChatId(),
        ];

        $replyMarkup = $mediaGroupRequestDTO->getReplyMarkup();
        if (!empty($replyMarkup)) {
            $params['reply_markup'] = $replyMarkup;
        }

        $parseMode = $mediaGroupRequestDTO->getParseMode();
        if (!empty($parseMode)) {
            $params['parse_mode'] = $parseMode;
        }

        foreach ($mediaGroupRequestDTO->getMedia() as $media) {
            $params['media'][] = match ($media->getType()) {
                InputMediaPhotoDTO::TYPE => $this->inputMediaPhotoHydrator->extract($media)
            };
        }

        return new SendMediaGroupRequest($params);
    }
}
