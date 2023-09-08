<?php

namespace App\Services\Logger;

use App\Services\EventBus\PortAdapter\RabbitMQ\RabbitMQService;
use App\Services\Logger\DTO\HttpLoggerDTO;
use App\Services\Logger\Formatter\HttpLoggerFormatter;

class HttpLoggerService
{
    public function __construct(
        private readonly RabbitMQService $rabbitMQService,
        private readonly HttpLoggerFormatter $httpLoggerFormatter,
    ) {
    }

    /**
     * @param HttpLoggerDTO $loggerDTO
     * @return void
     * @throws \Exception
     */
    public function log(HttpLoggerDTO $loggerDTO): void
    {
        $message = $this->httpLoggerFormatter->format($loggerDTO);

        $this->rabbitMQService->publish(json_encode($message));
    }
}
