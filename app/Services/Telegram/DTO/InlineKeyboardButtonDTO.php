<?php

namespace App\Services\Telegram\DTO;

class InlineKeyboardButtonDTO
{
    public const LIMIT_TEXT_LENGTH = 200;

    private string $text;

    private ?string $url = null;

    private ?string $callbackData = null;

    private ?string $switchInlineQuery = null;

    private ?string $switchInlineQueryCurrentChat = null;

    private bool $isPay = false;

    private ?LoginDTO $login;

    public function __construct(string $text)
    {
        $this->text = mb_strimwidth($text, 0, self::LIMIT_TEXT_LENGTH, '...');
    }

    /**
     * @return string|null
     */
    public function getCallbackData(): ?string
    {
        return $this->callbackData;
    }

    /**
     * @param string|null $callbackData
     */
    public function setCallbackData(?string $callbackData): void
    {
        $this->callbackData = $callbackData;
    }

    /**
     * @return string|null
     */
    public function getSwitchInlineQuery(): ?string
    {
        return $this->switchInlineQuery;
    }

    /**
     * @param string|null $switchInlineQuery
     */
    public function setSwitchInlineQuery(?string $switchInlineQuery): void
    {
        $this->switchInlineQuery = $switchInlineQuery;
    }

    /**
     * @return string|null
     */
    public function getSwitchInlineQueryCurrentChat(): ?string
    {
        return $this->switchInlineQueryCurrentChat;
    }

    /**
     * @param string|null $switchInlineQueryCurrentChat
     */
    public function setSwitchInlineQueryCurrentChat(?string $switchInlineQueryCurrentChat): void
    {
        $this->switchInlineQueryCurrentChat = $switchInlineQueryCurrentChat;
    }

    /**
     * @return bool
     */
    public function isPay(): bool
    {
        return $this->isPay;
    }

    /**
     * @param bool $isPay
     */
    public function setIsPay(bool $isPay): void
    {
        $this->isPay = $isPay;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return LoginDTO|null
     */
    public function getLogin(): ?LoginDTO
    {
        return $this->login;
    }

    /**
     * @param LoginDTO|null $login
     */
    public function setLogin(?LoginDTO $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

}
