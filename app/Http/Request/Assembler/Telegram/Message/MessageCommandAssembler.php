<?php

namespace App\Http\Request\Assembler\Telegram\Message;

use App\Core\DTO\CommandDTO;

class MessageCommandAssembler
{
    private const BOT_COMMAND_TYPE_ENTITY = 'bot_command';

    /**
     * @param array $params
     * @return CommandDTO|null
     */
    public function create(array $params): ?CommandDTO
    {
        if (!isset($params['entities']) || $params['entities'][0]['type'] !== self::BOT_COMMAND_TYPE_ENTITY) {
            return null;
        }

        $text = $params['text'];
        $offset = $params['entities'][0]['offset'];
        $length = $params['entities'][0]['length'];

        $command = trim(substr($text, $offset, $length));
        $args = substr($text, $length);

        return new CommandDTO($command, explode(' ', $args));
    }
}
