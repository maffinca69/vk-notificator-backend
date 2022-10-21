<?php

namespace App\Providers;

use App\Core\Command\AbstractCommand;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('bot-commands', static function (Application $app) {
            $botCommands = [];

            $config = config('bot');

            $commands = $config['commands'] ?? [];
            if (empty($commands)) {
                return [];
            }

            /** @var \stdClass $command */
            foreach ($commands as $command) {
                $commandClass = $app->get($command);
                if (!$commandClass instanceof AbstractCommand) {
                    continue;
                }

                $botCommands[$commandClass->getSignature()] = $commandClass;
            }

            return array_unique($botCommands);
        });
    }
}
