<?php

namespace App\Services\Telegram\DTO\Response;

use App\Services\Telegram\DTO\MessageDTO;

class TelegramResponseDTO
{
    /**
     * @param bool $isOk
     * @param array<MessageDTO>|bool $result
     */
    public function __construct(
        private bool $isOk,
        private array|bool $result
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
}
