<?php

namespace App\Services\Telegram\DTO\Request;

use App\Services\Telegram\DTO\InputMedia\AbstractInputMedia;

class MediaGroupRequestDTO
{
    /**
     * @param int $chatId
     * @param array<AbstractInputMedia> $media
     * @param array|null $replyMarkup
     * @param string|null $parseMode
     */
    public function __construct(
        private int $chatId,
        private array $media,
        private ?array $replyMarkup = [],
        private ?string $parseMode = null
    ) {
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }

    /**
     * @return array
     */
    public function getMedia(): array
    {
        return $this->media;
    }

    /**
     * @return array|null
     */
    public function getReplyMarkup(): ?array
    {
        return $this->replyMarkup;
    }

    /**
     * @param array|null $replyMarkup
     */
    public function setReplyMarkup(?array $replyMarkup): void
    {
        $this->replyMarkup = $replyMarkup;
    }

    /**
     * @return string|null
     */
    public function getParseMode(): ?string
    {
        return $this->parseMode;
    }

    /**
     * @param string|null $parseMode
     */
    public function setParseMode(?string $parseMode): void
    {
        $this->parseMode = $parseMode;
    }
}
