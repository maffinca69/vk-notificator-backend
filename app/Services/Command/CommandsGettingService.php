<?php

namespace App\Services\Command;

use App\Core\Command\AbstractCommand;
use App\Infrastructure\Config\ConfigService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class CommandsGettingService
{
    /**
     * @param ConfigService $configService
     * @param ContainerInterface $container
     */
    public function __construct(
        private ConfigService $configService,
        private ContainerInterface $container
    ) {
    }

    /**
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get(): array
    {
        $config = $this->configService->get('bot');
        $commands = $config['commands'] ?? [];

        if (empty($commands)) {
            return [];
        }

        $botCommands = [];

        /** @var \stdClass $command */
        foreach ($commands as $command) {
            $commandClass = $this->container->get($command);
            if (!$commandClass instanceof AbstractCommand) {
                continue;
            }

            $botCommands[$commandClass->getSignature()] = $commandClass;
        }

        return $botCommands;
    }
}
