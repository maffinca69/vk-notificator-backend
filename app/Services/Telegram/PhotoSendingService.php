<?php

namespace App\Services\Telegram;

use App\Infrastructure\Telegram\Client\Exception\TelegramHttpClientException;
use App\Infrastructure\Telegram\Client\HttpClient;
use App\Services\Telegram\Assembler\SendPhotoRequestAssembler;
use App\Services\Telegram\DTO\SendPhotoRequestDTO;

class PhotoSendingService
{
    public function __construct(
        private SendPhotoRequestAssembler $sendPhotoRequestAssembler,
        private HttpClient $client
    ) {
    }

    /**
     * @param SendPhotoRequestDTO $sendPhotoRequestDTO
     * @throws TelegramHttpClientException
     */
    public function send(SendPhotoRequestDTO $sendPhotoRequestDTO): void
    {
        $request = $this->sendPhotoRequestAssembler->create($sendPhotoRequestDTO);

        $this->client->sendRequest($request);
    }
}
