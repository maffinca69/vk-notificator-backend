<?php

namespace App\Providers;

use App\Infrastructure\Logger\NotificationMailingLogger;
use App\Infrastructure\Logger\TelegramClientLogger;
use App\Infrastructure\Logger\TelegramWebhookLogger;
use App\Services\Logger\PsrServiceLoggerFactory;
use Illuminate\Support\ServiceProvider;
use Psr\Container\ContainerInterface;

class LoggerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(TelegramClientLogger::class, static function (ContainerInterface $container) {
            /** @var PsrServiceLoggerFactory $psrServiceLoggerFactory */
            $psrServiceLoggerFactory = $container->get(PsrServiceLoggerFactory::class);
            return $psrServiceLoggerFactory->create(TelegramClientLogger::class);
        });

        $this->app->bind(NotificationMailingLogger::class, static function (ContainerInterface $container) {
            /** @var PsrServiceLoggerFactory $psrServiceLoggerFactory */
            $psrServiceLoggerFactory = $container->get(PsrServiceLoggerFactory::class);
            return $psrServiceLoggerFactory->create(NotificationMailingLogger::class);
        });

        $this->app->bind(TelegramWebhookLogger::class, static function (ContainerInterface $container) {
            /** @var PsrServiceLoggerFactory $psrServiceLoggerFactory */
            $psrServiceLoggerFactory = $container->get(PsrServiceLoggerFactory::class);
            return $psrServiceLoggerFactory->create(TelegramWebhookLogger::class);
        });
    }
}
