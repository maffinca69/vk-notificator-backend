<?php

namespace App\Http\Middleware;

use App\Http\Request\Assembler\Logger\HttpLoggerDTOAssembler;
use App\Services\Logger\HttpLoggerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoggerMiddleware
{
    public function __construct(
        private readonly HttpLoggerDTOAssembler $loggerDTOAssembler,
        private readonly HttpLoggerService $httpLoggerService
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        $httpLoggerDTO = $this->loggerDTOAssembler->create($request, $response);
        $this->httpLoggerService->log($httpLoggerDTO);

        return $response;
    }
}
