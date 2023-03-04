<?php

namespace App\Services\Telegram\DTO;

class ReplyKeyboardMarkupDTO
{
    private array $keyboard;

    private bool $isResizeKeyboard = false;

    private bool $isOneTimeKeyboard = false;

    private bool $isSelective = false;

    private ?string $inputFieldPlaceholder = null;

    /**
     * @return string|null
     */
    public function getInputFieldPlaceholder(): ?string
    {
        return $this->inputFieldPlaceholder;
    }

    /**
     * @param string $inputFieldPlaceholder
     */
    public function setInputFieldPlaceholder(string $inputFieldPlaceholder): void
    {
        $this->inputFieldPlaceholder = $inputFieldPlaceholder;
    }

    /**
     * @return array
     */
    public function getKeyboard(): array
    {
        return $this->keyboard;
    }

    /**
     * @param array $keyboard
     */
    public function setKeyboard(array $keyboard): void
    {
        $this->keyboard = $keyboard;
    }

    /**
     * @return bool
     */
    public function isResizeKeyboard(): bool
    {
        return $this->isResizeKeyboard;
    }

    /**
     * @param bool $isResizeKeyboard
     */
    public function setIsResizeKeyboard(bool $isResizeKeyboard): void
    {
        $this->isResizeKeyboard = $isResizeKeyboard;
    }

    /**
     * @return bool
     */
    public function isOneTimeKeyboard(): bool
    {
        return $this->isOneTimeKeyboard;
    }

    /**
     * @param bool $isOneTimeKeyboard
     */
    public function setIsOneTimeKeyboard(bool $isOneTimeKeyboard): void
    {
        $this->isOneTimeKeyboard = $isOneTimeKeyboard;
    }

    /**
     * @return bool
     */
    public function isSelective(): bool
    {
        return $this->isSelective;
    }

    /**
     * @param bool $isSelective
     */
    public function setIsSelective(bool $isSelective): void
    {
        $this->isSelective = $isSelective;
    }
}
