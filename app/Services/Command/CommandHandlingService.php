<?php

namespace App\Services\Command;

use App\Services\Command\Exception\CommandNotFoundException;
use App\Services\Telegram\Command\CommandInterface;
use App\Services\Telegram\DTO\UpdateDTO;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CommandHandlingService
{
    public function __construct(private CommandsGettingService $commandsGettingService)
    {
    }

    /**
     * @param UpdateDTO $update
     * @return void
     * @throws CommandNotFoundException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(UpdateDTO $update): void
    {
        $message = $update->getMessage();
        if (!$message->isCommand()) {
            return;
        }

        $commands = $this->commandsGettingService->get();
        $signature = $message->getCommand()->getCommand();

        $command = $this->findCommandBySignature($commands, $signature);
        $command->handle($update);
    }

    /**
     * @param array<CommandInterface> $commands
     * @param string $requestedCommand
     * @return CommandInterface
     * @throws CommandNotFoundException
     */
    private function findCommandBySignature(array $commands, string $requestedCommand): CommandInterface
    {
        /**
         * @var string $signature
         * @var CommandInterface $command
         */
        foreach ($commands as $signature => $command) {
            if ($requestedCommand === $signature) {
                return $command;
            }
        }

        throw new CommandNotFoundException('Not found available command', [
            'method' => __METHOD__,
            'requestedCommand' => $requestedCommand,
            'commands' => array_keys($commands)
        ]);
    }
}
