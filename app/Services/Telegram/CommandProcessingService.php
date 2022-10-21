<?php

namespace App\Services\Telegram;

use App\Core\Command\AbstractCommand;
use App\Core\DTO\UpdateDTO;
use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class CommandProcessingService
{
    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * @param UpdateDTO $update
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(UpdateDTO $update): void
    {
        $message = $update->getMessage();
        if (!$message->isCommand()) {
            return;
        }

        $commands = $this->container->get('bot-commands');
        Log::info($commands);

        /**
         * @var string $signature
         * @var AbstractCommand $command
         */
        foreach ($commands as $signature => $command) {
            if ($message->getCommand()->getCommand() === $signature) {
                $command->handle($update);
            }
        }
    }
}
