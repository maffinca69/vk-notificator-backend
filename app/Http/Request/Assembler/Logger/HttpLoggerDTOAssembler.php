<?php

namespace App\Http\Request\Assembler\Logger;

use App\Infrastructure\Config\ConfigService;
use App\Services\Logger\DTO\HttpLoggerDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HttpLoggerDTOAssembler
{
    private const DEFAULT_APP_NAME = 'unknown app';

    public function __construct(
        private readonly ConfigService $configService
    ) {
    }

    public function create(Request $request, Response $response): HttpLoggerDTO
    {
        return new HttpLoggerDTO(
            appName: $this->getApplicationName(),
            request: json_encode($request->all()),
            response: $response->getContent(),
            ip: $request->ip(),
            userAgent: $request->userAgent(),
            pid: sha1(time()),
            route: $request->decodedPath()
        );
    }

    /**
     * @return string
     */
    private function getApplicationName(): string
    {
        $config = $this->configService->get('app');

        return $config['name'] ?? self::DEFAULT_APP_NAME;
    }
}
