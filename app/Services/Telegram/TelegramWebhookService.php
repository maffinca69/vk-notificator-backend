<?php

namespace App\Services\Telegram;

use App\Core\DTO\UpdateDTO;
use App\Services\Command\CommandProcessingService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TelegramWebhookService
{
    /**
     * @param CommandProcessingService $commandProcessingService
     */
    public function __construct(
        private CommandProcessingService $commandProcessingService,
    ) {
    }

    /**
     * @param UpdateDTO $update
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(UpdateDTO $update)
    {
        $message = $update->getMessage() ?? $update->getCallbackQuery();

        if ($message->isCommand()) {
            $this->commandProcessingService->process($update);
            return;
        }

        // Text messages/audio/sticker etc...
    }
}
