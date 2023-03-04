<?php

namespace App\Services\Telegram\DTO;

class KeyboardButtonDTO
{
    private string $text;
    private bool $isRequestContact;
    private bool $isRequestLocationKeyboardButtonPollType;
    private KeyboardButtonPollTypeDTO $requestPool;
    private ?string $webAppUrl = null;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return string|null
     */
    public function getWebAppUrl(): ?string
    {
        return $this->webAppUrl;
    }

    /**
     * @param string|null $webAppUrl
     *
     * @return self
     */
    public function setWebAppUrl(?string $webAppUrl): self
    {
        $this->webAppUrl = $webAppUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return bool
     */
    public function isRequestContact(): bool
    {
        return $this->isRequestContact;
    }

    /**
     * @param bool $isRequestContact
     */
    public function setIsRequestContact(bool $isRequestContact): void
    {
        $this->isRequestContact = $isRequestContact;
    }

    /**
     * @return bool
     */
    public function isRequestLocationKeyboardButtonPollType(): bool
    {
        return $this->isRequestLocationKeyboardButtonPollType;
    }

    /**
     * @param bool $isRequestLocationKeyboardButtonPollType
     */
    public function setIsRequestLocationKeyboardButtonPollType(bool $isRequestLocationKeyboardButtonPollType): void
    {
        $this->isRequestLocationKeyboardButtonPollType = $isRequestLocationKeyboardButtonPollType;
    }

    /**
     * @return KeyboardButtonPollTypeDTO
     */
    public function getRequestPool(): KeyboardButtonPollTypeDTO
    {
        return $this->requestPool;
    }

    /**
     * @param KeyboardButtonPollTypeDTO $requestPool
     */
    public function setRequestPool(KeyboardButtonPollTypeDTO $requestPool): void
    {
        $this->requestPool = $requestPool;
    }
}
