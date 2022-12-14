<?php

namespace App\Services\Command;

use App\Core\Command\AbstractCommand;
use App\Core\DTO\UpdateDTO;
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
