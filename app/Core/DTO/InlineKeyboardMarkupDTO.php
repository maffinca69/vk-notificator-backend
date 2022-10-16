<?php

namespace App\Core\DTO;

class InlineKeyboardMarkupDTO
{
    private array $inlineKeyboard;

    /**
     * @return array
     */
    public function getInlineKeyboard(): array
    {
        return $this->inlineKeyboard;
    }

    /**
     * @param array $inlineKeyboard
     */
    public function setInlineKeyboard(array $inlineKeyboard): void
    {
        $this->inlineKeyboard = $inlineKeyboard;
    }
}
