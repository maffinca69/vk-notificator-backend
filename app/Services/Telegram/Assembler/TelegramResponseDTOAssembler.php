<?php

namespace App\Services\Telegram\Assembler;

use App\Http\Request\Assembler\Telegram\Message\MessageAssembler;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\DTO\TelegramResponseDTO;

class TelegramResponseDTOAssembler
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
     * @throws InvalidTelegramResponseException
     */
    public function create(array $response): TelegramResponseDTO
    {
        if (!isset($response['ok'], $response['result'])) {
            throw new InvalidTelegramResponseException(
                'Invalid response: ' . json_encode($response)
            );
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
