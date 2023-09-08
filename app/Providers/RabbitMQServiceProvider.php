<?php

namespace App\Providers;

use App\Infrastructure\Config\ConfigService;
use App\Services\EventBus\PortAdapter\RabbitMQ\RabbitMQService;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQServiceProvider extends ServiceProvider
{
    private const CONFIG_NAME = 'rabbitmq';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RabbitMQService::class, static function(Application $app) {
            /** @var ConfigService $configService */
            $configService = $app->make(ConfigService::class);
            $config = $configService->get(self::CONFIG_NAME);

            $connection = new AMQPStreamConnection(
                $config['host'],
                $config['port'],
                $config['user'],
                $config['password'],
                $config['vhost'],
            );

            return new RabbitMQService($connection);
        });
    }
}
