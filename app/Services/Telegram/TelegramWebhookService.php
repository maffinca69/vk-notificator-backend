<?php

namespace App\Services\Telegram;

use App\Core\DTO\UpdateDTO;
use App\Infrastructure\Logger\TelegramWebhookLogger;
use App\Services\Command\CommandHandlingService;

class TelegramWebhookService
{
    /**
     * @param CommandHandlingService $commandHandlingService
     * @param TelegramWebhookLogger $logger
     */
    public function __construct(
        private CommandHandlingService $commandHandlingService,
        private TelegramWebhookLogger $logger
    ) {
    }

    /**
     * @param UpdateDTO $update
     */
    public function process(UpdateDTO $update)
    {
        $message = $update->getMessage() ?? $update->getCallbackQuery();

        if ($message->isCommand()) {
            $this->commandHandlingService->handle($update);
            return;
        }

        // Text messages/audio/sticker etc...
        $this->logger->warning('Not implemented yet action', $update->getJson());
    }
}
