<?php

namespace App\Http\Request\Assembler\Telegram\Message;

use App\Services\Telegram\DTO\ChatDTO;

class MessageChatAssembler
{
    /**
     * @param array $params
     * @return ChatDTO
     */
    public function create(array $params): ChatDTO
    {
        return (new ChatDTO($params['id']))
            ->setFirstName($params['first_name'] ?? '')
            ->setLastName($params['last_name'] ?? '')
            ->setUsername($params['username'] ?? '')
            ->setType($params['type']);
    }
}
