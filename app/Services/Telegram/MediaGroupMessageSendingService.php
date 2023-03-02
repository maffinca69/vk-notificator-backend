<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Assembler\SendMediaGroupRequestAssembler;
use App\Services\Telegram\Client\HttpClient;
use App\Services\Telegram\DTO\MediaGroupRequestDTO;

class MediaGroupMessageSendingService
{
    /**
     * @param HttpClient $client
     * @param SendMediaGroupRequestAssembler $sendMediaGroupRequestAssembler
     */
    public function __construct(
        private HttpClient $client,
        private SendMediaGroupRequestAssembler $sendMediaGroupRequestAssembler
    ) {
    }

    /**
     * @param MediaGroupRequestDTO $mediaGroupRequestDTO
     * @return void
     * @throws Client\Exception\InvalidTelegramResponseException
     */
    public function send(MediaGroupRequestDTO $mediaGroupRequestDTO): void
    {
        $request = $this->sendMediaGroupRequestAssembler->create($mediaGroupRequestDTO);

        $this->client->sendRequest($request);
    }
}
