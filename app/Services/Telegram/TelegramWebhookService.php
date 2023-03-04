<?php

namespace App\Services\Telegram;

use App\Infrastructure\Logger\TelegramWebhookLogger;
use App\Services\Command\CommandHandlingService;
use App\Services\Telegram\DTO\UpdateDTO;

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
     * @return void
     */
    public function process(UpdateDTO $update): void
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
