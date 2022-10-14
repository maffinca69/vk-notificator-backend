<?php

namespace App\Services\Telegram\Client\DTO;

use App\Core\DTO\MessageDTO;

class TelegramResponseDTO
{
    private bool $isOk;

    /** @var array<MessageDTO>|bool  */
    private array|bool $result;

    /**
     * @param bool $isOk
     * @param array|bool $result
     */
    public function __construct(bool $isOk, array|bool $result)
    {
        $this->isOk = $isOk;
        $this->result = $result;
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
