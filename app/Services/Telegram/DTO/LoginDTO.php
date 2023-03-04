<?php

namespace App\Services\Telegram\DTO;

class LoginDTO
{
    private string $url;

    private string $forwardText;

    private string $botUsername;

    private bool $requestWriteAccess;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getForwardText(): string
    {
        return $this->forwardText;
    }

    /**
     * @param string $forwardText
     */
    public function setForwardText(string $forwardText): void
    {
        $this->forwardText = $forwardText;
    }

    /**
     * @return string
     */
    public function getBotUsername(): string
    {
        return $this->botUsername;
    }

    /**
     * @param string $botUsername
     */
    public function setBotUsername(string $botUsername): void
    {
        $this->botUsername = $botUsername;
    }

    /**
     * @return bool
     */
    public function isRequestWriteAccess(): bool
    {
        return $this->requestWriteAccess;
    }

    /**
     * @param bool $requestWriteAccess
     */
    public function setRequestWriteAccess(bool $requestWriteAccess): void
    {
        $this->requestWriteAccess = $requestWriteAccess;
    }
}
