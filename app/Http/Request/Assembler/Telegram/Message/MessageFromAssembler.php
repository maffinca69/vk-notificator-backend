<?php

namespace App\Http\Request\Assembler\Telegram\Message;

use App\Core\DTO\FromDTO;

class MessageFromAssembler
{
    /**
     * @param array $params
     * @return FromDTO
     */
    public function create(array $params): FromDTO
    {
        return (new FromDTO($params['id']))
            ->setIsBot($params['is_bot'])
            ->setFirstName($params['first_name'] ?? '')
            ->setLastName($params['last_name'] ?? '')
            ->setUsername($params['username'] ?? null)
            ->setLanguageCode($params['language_code'] ?? 'ru');
    }
}
