<?php

namespace App\Services\Telegram\DTO\Request;

class MessageRequestDTO
{
    public const PARSE_MODE_MARKDOWN = 'Markdown';
    public const PARSE_MODE_MARKDOWN_V2 = 'MarkdownV2';

    /**
     * @param int $chatId
     * @param string|null $text
     * @param string|null $parseMode
     * @param int|null $replyToMessageId
     * @param array|null $replyMarkup
     * @param bool $disableWebPagePreview
     */
    public function __construct(
        private int $chatId,
        private ?string $text = null,
        private ?string $parseMode = null,
        private ?int $replyToMessageId = null,
        private ?array $replyMarkup = null,
        private bool $disableWebPagePreview = false,
    ) {
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
     * @return int|null
     */
    public function getReplyToMessageId(): ?int
    {
        return $this->replyToMessageId;
    }

    /**
     * @return array|null
     */
    public function getReplyMarkup(): ?array
    {
        return $this->replyMarkup;
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
}
