<?php

namespace App\Http\Request\Assembler\Telegram\Message;

use App\Services\Telegram\DTO\InlineKeyboardButtonDTO;
use App\Services\Telegram\DTO\InlineKeyboardMarkupDTO;
use App\Services\Telegram\DTO\ReplyMarkupDTO;

class MessageReplyMarkupAssembler
{
    /**
     * @param array $params
     * @return ReplyMarkupDTO|null
     */
    public function create(array $params): ?ReplyMarkupDTO
    {
        if (!isset($params['inline_keyboard'])) {
            return null;
        }

        $replyMarkup = new ReplyMarkupDTO();

        $buttons = [];
        foreach ($params['inline_keyboard'] as $rows) {
            foreach ($rows as $button) {
                $inlineKeyboardButton = new InlineKeyboardButtonDTO($button['text']);
                $inlineKeyboardButton->setCallbackData($button['callback_data'] ?? null);

                $buttons[][] = $inlineKeyboardButton;
            }
        }

        $inlineKeyboardMarkupDTO = new InlineKeyboardMarkupDTO();
        $inlineKeyboardMarkupDTO->setInlineKeyboard($buttons);

        $replyMarkup->setInlineKeyboard($inlineKeyboardMarkupDTO);

        return $replyMarkup;
    }
}
