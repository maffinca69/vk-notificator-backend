<?php

namespace App\Services\Internal\Exception;

use Illuminate\Http\Response;

interface ExceptionHandlerInterface
{
    public function handle(\Throwable $throwable): Response;
}
