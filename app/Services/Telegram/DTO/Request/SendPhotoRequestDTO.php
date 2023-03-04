<?php

namespace App\Services\Telegram\DTO\Request;

class SendPhotoRequestDTO
{
    /**
     * @param int $chatId
     * @param string $url
     * @param string|null $caption
     * @param array|null $replyMarkup
     * @param string|null $parseMode
     */
    public function __construct(
        private int $chatId,
        private string $url,
        private ?string $caption = null,
        private ?array $replyMarkup = [],
        private ?string $parseMode = null
    ) {
    }

    /**
     * @return string|null
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }

    /**
     * @param string|null $caption
     */
    public function setCaption(?string $caption): void
    {
        $this->caption = $caption;
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
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
