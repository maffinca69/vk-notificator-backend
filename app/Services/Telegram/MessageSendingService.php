<?php

namespace App\Services\Telegram;

use App\Infrastructure\Telegram\Client\Exception\TelegramHttpClientException;
use App\Infrastructure\Telegram\Client\HttpClient;
use App\Services\Telegram\Assembler\SendMessageRequestAssembler;
use App\Services\Telegram\DTO\MessageRequestDTO;

class MessageSendingService
{
    public function __construct(
      private SendMessageRequestAssembler $sendMessageRequestAssembler,
      private HttpClient $client
    ) {
    }

    /**
     * @param MessageRequestDTO $messageRequestDTO
     * @throws TelegramHttpClientException
     */
    public function send(MessageRequestDTO $messageRequestDTO): void
    {
        $request = $this->sendMessageRequestAssembler->create($messageRequestDTO);

        $this->client->sendRequest($request);
    }
}
