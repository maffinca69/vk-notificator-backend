<?php

namespace App\Services\Logger\Formatter;

use App\Services\Logger\DTO\HttpLoggerDTO;

class HttpLoggerFormatter
{
    public function format(HttpLoggerDTO $loggerDTO): array
    {
        return [
            'app_name' => $loggerDTO->getAppName(),
            'request' => $loggerDTO->getRequest(),
            'response' => $loggerDTO->getResponse(),
            'user_agent' => $loggerDTO->getUserAgent(),
            'ip' => $loggerDTO->getIp(),
            'route' => $loggerDTO->getRoute(),
            'pid' => $loggerDTO->getPid()
        ];
    }
}
