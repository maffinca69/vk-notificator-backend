<?php

namespace App\Providers;

use App\Infrastructure\Config\ConfigService;
use App\Services\Logger\PsrServiceLoggerFactory;
use Illuminate\Support\ServiceProvider;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class LoggerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function register(): void
    {
        /** @var ConfigService $configService */
        $configService = $this->app->get(ConfigService::class);
        $loggers = $configService->get('logger');

        foreach ($loggers as $logger) {
            $this->app->singleton($logger, static function (ContainerInterface $container) use ($logger) {
                /** @var PsrServiceLoggerFactory $psrServiceLoggerFactory */
                $psrServiceLoggerFactory = $container->get(PsrServiceLoggerFactory::class);

                return $psrServiceLoggerFactory->create($logger);
            });
        }
    }
}
