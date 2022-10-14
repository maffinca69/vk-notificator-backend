<?php

namespace App\Http\Request\Assembler\Telegram;

use App\Core\DTO\UpdateDTO;
use App\Http\Request\Assembler\Telegram\Message\MessageAssembler;

class UpdateDTOAssembler
{
    private MessageAssembler $messageAssembler;

    private CallbackQueryAssembler $callbackQueryAssembler;

    public function __construct(
        MessageAssembler $messageAssembler,
        CallbackQueryAssembler $callbackQueryAssembler
    ) {
        $this->messageAssembler = $messageAssembler;
        $this->callbackQueryAssembler = $callbackQueryAssembler;
    }

    /**
     * @param array $params
     * @return UpdateDTO|null
     */
    public function create(array $params): ?UpdateDTO
    {
        if (!isset($params['update_id'])) {
            return null;
        }

        $update = new UpdateDTO($params['update_id']);

        if (isset($params['callback_query'])) {
            $callbackQuery = $this->callbackQueryAssembler->create($params['callback_query']);
            $update->setCallbackQuery($callbackQuery);
        }

        if (isset($params['message'])) {
            $message = $this->messageAssembler->create($params['message']);
            $update->setMessage($message);
        }

        $update->setJson($params);

        return $update;
    }
}
