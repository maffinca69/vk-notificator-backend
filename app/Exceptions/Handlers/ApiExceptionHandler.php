<?php

namespace App\Exceptions\Handlers;

use App\Services\Exception\ExceptionHandlerInterface;
use App\Services\Exception\Formatter\ExceptionFormatter;
use Illuminate\Http\Response;

class ApiExceptionHandler implements ExceptionHandlerInterface
{
    public function __construct(private ExceptionFormatter $exceptionFormatter)
    {
    }

    public function handle(\Throwable $throwable): Response
    {
        return response([
            'success' => false,
            'error' => $this->exceptionFormatter->format($throwable)
        ]);
    }
}
