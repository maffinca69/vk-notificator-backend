<?php

namespace App\Http\Request\Assembler\Telegram\Message;

use App\Core\DTO\MessageDTO;
use App\Http\Request\Assembler\Telegram\Message\Traits\MessageFieldTrait;

class MessageAssembler
{
    use MessageFieldTrait;

    private ReplyMessageAssembler $replyMessageAssembler;
    private MessageReplyMarkupAssembler $messageReplyMarkupAssembler;

    public function __construct(
        MessageReplyMarkupAssembler $messageReplyMarkupAssembler,
        ReplyMessageAssembler $replyMessageAssembler,
    ) {
        $this->messageReplyMarkupAssembler = $messageReplyMarkupAssembler;
        $this->replyMessageAssembler = $replyMessageAssembler;
    }

    /**
     * @param array $params
     * @param MessageDTO|null $message
     * @return MessageDTO
     */
    public function create(array $params, MessageDTO $message = null): MessageDTO
    {
        if ($message === null) {
            $message = new MessageDTO($params['message_id']);
        }

        $replyMessage = $this->replyMessageAssembler->create($params);

        $message = $this->setMessageField($params, $message);
        $message->setReplyMessage($replyMessage);

        if (isset($params['reply_markup'])) {
            $replyMarkup = $this->messageReplyMarkupAssembler->create($params['reply_markup']);
            $message->setReplyMarkup($replyMarkup);
        }

        $pinnedMessage = null;
        if (isset($params['pinned_message'])) {
            unset($params['pinned_message']);
            $pinnedMessage = $this->create($params, $message);
        }

        $message->setPinnedMessage($pinnedMessage);

        return $message;
    }
}
