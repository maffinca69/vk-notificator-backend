<?php

namespace App\Services\Telegram\Assembler;

use App\Services\Telegram\Client\Request\SendMediaGroupRequest;
use App\Services\Telegram\DTO\InputMedia\InputMediaPhotoDTO;
use App\Services\Telegram\DTO\MediaGroupRequestDTO;
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

        foreach ($mediaGroupRequestDTO->getMedia() as $media) {
            $params['media'][] = match ($media->getType()) {
                InputMediaPhotoDTO::TYPE => $this->inputMediaPhotoHydrator->extract($media)
            };
        }

        return new SendMediaGroupRequest($params);
    }
}
