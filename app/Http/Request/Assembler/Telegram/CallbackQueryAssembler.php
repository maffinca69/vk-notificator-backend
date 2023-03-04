<?php

namespace App\Http\Request\Assembler\Telegram;

use App\Http\Request\Assembler\Telegram\Message\MessageAssembler;
use App\Http\Request\Assembler\Telegram\Message\MessageFromAssembler;
use App\Services\Telegram\DTO\CallbackQueryDTO;

class CallbackQueryAssembler
{
    private MessageFromAssembler $messageFromAssembler;
    private MessageAssembler $messageAssembler;

    public function __construct(
        MessageFromAssembler $messageFromAssembler,
        MessageAssembler $messageAssembler
    ) {
        $this->messageAssembler = $messageAssembler;
        $this->messageFromAssembler = $messageFromAssembler;
    }

    /**
     * @param array $params
     * @return CallbackQueryDTO
     */
    public function create(array $params): CallbackQueryDTO
    {
        $callbackQuery = new CallbackQueryDTO($params['id']);

        $from = $this->messageFromAssembler->create($params['from']);
        $message = $this->messageAssembler->create($params['message']);

        $callbackQuery->setFrom($from)
            ->setChatInstance($params['chat_instance'])
            ->setData($params['data'])
            ->setMessage($message);

        return $callbackQuery;
    }
}
