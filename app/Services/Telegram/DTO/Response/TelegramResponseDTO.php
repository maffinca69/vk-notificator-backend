<?php

namespace App\Services\Telegram\DTO\Response;

use App\Services\Telegram\DTO\MessageDTO;

class TelegramResponseDTO
{
    /**
     * @param bool $isOk
     * @param array<MessageDTO>|bool $result
     * @param string $rawResponse
     */
    public function __construct(
        private bool $isOk,
        private array|bool $result,
        private string $rawResponse,
    ) {
    }

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->isOk;
    }

    /**
     * @return MessageDTO[]|bool
     */
    public function getResult(): array|bool
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getRawResponse(): string
    {
        return $this->rawResponse;
    }
}
