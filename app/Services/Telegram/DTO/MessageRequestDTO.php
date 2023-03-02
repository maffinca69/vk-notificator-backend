<?php

namespace App\Services\Telegram\DTO;

class MessageRequestDTO
{
    public const PARSE_MODE_MARKDOWN = 'Markdown';
    public const PARSE_MODE_MARKDOWN_V2 = 'MarkdownV2';

    private int $chatId;

    private ?string $text = null;
    private ?string $parseMode = null;
    private ?int $replyToMessageId = null;
    private ?array $replyMarkup = null;
    private bool $disableWebPagePreview = false;

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

    /**
     * @return bool
     */
    public function isDisableWebPagePreview(): bool
    {
        return $this->disableWebPagePreview;
    }

    /**
     * @param bool $disableWebPagePreview
     */
    public function setDisableWebPagePreview(bool $disableWebPagePreview): void
    {
        $this->disableWebPagePreview = $disableWebPagePreview;
    }
}
