<?php

namespace App\Http\Request\Assembler\Telegram\Message;

use App\Http\Request\Assembler\Telegram\Message\Traits\MessageFieldTrait;
use App\Services\Telegram\DTO\ReplyMessageDTO;

class ReplyMessageAssembler
{
    use MessageFieldTrait;

    /**
     * @param array $params
     * @return ReplyMessageDTO|null
     */
    public function create(array $params): ?ReplyMessageDTO
    {
        if (!isset($params['reply_to_message'])) {
            return null;
        }

        $params = $params['reply_to_message'];

        $replyMessage = new ReplyMessageDTO($params['message_id']);
        return $this->setMessageField($params, $replyMessage);
    }
}
