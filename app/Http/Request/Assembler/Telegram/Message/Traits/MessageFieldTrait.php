<?php

namespace App\Http\Request\Assembler\Telegram\Message\Traits;

use App\Core\DTO\MessageDTO;
use App\Core\DTO\ReplyMessageDTO;
use App\Http\Request\Assembler\Telegram\Message\MessageChatAssembler;
use App\Http\Request\Assembler\Telegram\Message\MessageCommandAssembler;
use App\Http\Request\Assembler\Telegram\Message\MessageFromAssembler;
use App\Http\Request\Assembler\Telegram\Message\MessagePhotoAssembler;
use App\Http\Request\Assembler\Telegram\Message\MessageStickerAssembler;

trait MessageFieldTrait
{
    /**
     * @param array $params
     * @param MessageDTO|ReplyMessageDTO $message
     * @return MessageDTO|ReplyMessageDTO
     */
    private function setMessageField(array $params, MessageDTO|ReplyMessageDTO $message): MessageDTO|ReplyMessageDTO
    {
        $message->setDate($params['date']);
        $message->setText($params['text'] ?? '');
        $message->setEntities($params['entities'] ?? []);

        $message->setCommand($this->makeAssembler(MessageCommandAssembler::class)->create($params));
        $message->setSticker($this->makeAssembler(MessageStickerAssembler::class)->create($params));

        $message->setChat($this->makeAssembler(MessageChatAssembler::class)->create($params['chat']));
        $message->setFrom($this->makeAssembler(MessageFromAssembler::class)->create($params['from']));

        $message->setPhoto($this->makeAssembler(MessagePhotoAssembler::class)->create($params['photo'] ?? null));

        return $message;
    }

    /**
     * @param $class
     * @return mixed
     */
    private function makeAssembler($class): mixed
    {
        return app()->make($class);
    }
}
