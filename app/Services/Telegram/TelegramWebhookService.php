<?php

namespace App\Services\Telegram;

use App\Core\DTO\UpdateDTO;
use App\Infrastructure\Logger\TelegramWebhookLogger;
use App\Services\Command\CommandProcessingService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TelegramWebhookService
{
    /**
     * @param CommandProcessingService $commandProcessingService
     * @param TelegramWebhookLogger $logger
     */
    public function __construct(
        private CommandProcessingService $commandProcessingService,
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
            $this->commandProcessingService->process($update);
            return;
        }

        // Text messages/audio/sticker etc...
        $this->logger->warning('Not implemented yet action', $update->getJson());
    }
}
