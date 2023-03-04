<?php

namespace App\Services\Telegram\Translator;

use App\Http\Request\Assembler\Telegram\Message\MessageAssembler;
use App\Infrastructure\Telegram\Client\Exception\TelegramHttpClientException;
use App\Services\Telegram\DTO\TelegramResponseDTO;

class TelegramResponseTranslator
{
    /**
     * @param MessageAssembler $messageAssembler
     */
    public function __construct(private MessageAssembler $messageAssembler)
    {
    }

    /**
     * @param array $response
     * @return TelegramResponseDTO
     * @throws TelegramHttpClientException
     */
    public function translate(array $response): TelegramResponseDTO
    {
        if (!isset($response['ok'], $response['result'])) {
            throw new TelegramHttpClientException('Invalid response', $response);
        }

        $result = null;
        if (is_array($response['result'])) {
            if (isset($response['result'][0]) && is_array($response['result'][0])) {
                $messages = $response['result'];
            } else {
                $messages = [$response['result']];
            }

            $result = [];
            foreach ($messages as $message) {
                $result[] = $this->messageAssembler->create($message);
            }
        }

        if (is_bool($response['result'])) {
            $result = $response['result'];
        }

        return new TelegramResponseDTO($response['ok'], $result);
    }
}
