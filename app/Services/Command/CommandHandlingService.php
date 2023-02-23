<?php

namespace App\Services\Command;

use App\Core\Command\CommandInterface;
use App\Core\DTO\UpdateDTO;
use App\Services\Command\Exception\CommandNotFound;

class CommandHandlingService
{
    public function __construct(private CommandsGettingService $commandsGettingService)
    {
    }

    /**
     * @param UpdateDTO $update
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
     * @throws CommandNotFound
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

        throw new CommandNotFound('Not found available command', [
            'method' => __METHOD__,
            'requestedCommand' => $requestedCommand,
            'commands' => array_keys($commands)
        ]);
    }
}
