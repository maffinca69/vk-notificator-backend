<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Client\Assembler\SendMessageRequestAssembler;
use App\Services\Telegram\Client\DTO\MessageRequestDTO;
use App\Services\Telegram\Client\HttpClient;

class MessageSendingService
{
    public function __construct(
      private SendMessageRequestAssembler $sendMessageRequestAssembler,
      private HttpClient $client
    ) {
    }

    /**
     * @param MessageRequestDTO $messageRequestDTO
     * @throws Client\Exception\InvalidTelegramResponseException
     */
    public function send(MessageRequestDTO $messageRequestDTO): void
    {
        $request = $this->sendMessageRequestAssembler->create($messageRequestDTO);

        $this->client->sendRequest($request);
    }
}
