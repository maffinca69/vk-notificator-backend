<?php

namespace App\Services\Telegram\Client\DTO;

class MessageRequestDTO
{
    private int $chatId;

    private ?string $text = null;
    private ?string $parseMode = null;
    private ?int $replyToMessageId = null;
    private ?array $replyMarkup = null;

    /**
     * @param int $chatId
     */
    public function __construct(int $chatId)
    {
        $this->chatId = $chatId;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
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

    /**
     * @return int|null
     */
    public function getReplyToMessageId(): ?int
    {
        return $this->replyToMessageId;
    }

    /**
     * @param int|null $replyToMessageId
     */
    public function setReplyToMessageId(?int $replyToMessageId): void
    {
        $this->replyToMessageId = $replyToMessageId;
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
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }
}
