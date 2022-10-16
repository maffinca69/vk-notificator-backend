<?php

namespace App\Core\DTO;

class ReplyMarkupDTO
{
    private InlineKeyboardMarkupDTO $inlineKeyboard;

    /**
     * @return InlineKeyboardMarkupDTO
     */
    public function getInlineKeyboard(): InlineKeyboardMarkupDTO
    {
        return $this->inlineKeyboard;
    }

    /**
     * @param InlineKeyboardMarkupDTO $inlineKeyboard
     */
    public function setInlineKeyboard(InlineKeyboardMarkupDTO $inlineKeyboard): void
    {
        $this->inlineKeyboard = $inlineKeyboard;
    }
}
