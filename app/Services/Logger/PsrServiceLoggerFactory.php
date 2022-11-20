<?php

namespace App\Services\Logger;

use App\Infrastructure\Logger\TelegramClientLogger;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class PsrServiceLoggerFactory
{
    /**
     * @param $service
     * @return LoggerInterface
     */
    public function create($service): LoggerInterface
    {
        $logger = new Logger('name');
        $collection = $this->createFileName($service);
        $logger->pushHandler(new StreamHandler(storage_path("logs/$collection.log")));

        return new $service($logger);
    }

    /**
     * @param $service
     * @return string
     */
    private function createFileName($service): string
    {
        $date = (new \DateTime())->format(ServiceLogger::DATE_FORMAT);

        return sprintf('%s-%s', $service::LOG_COLLECTION, $date);
    }
}
