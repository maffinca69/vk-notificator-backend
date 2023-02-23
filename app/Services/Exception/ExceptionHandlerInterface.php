<?php

namespace App\Services\Exception;

use Illuminate\Http\Response;

interface ExceptionHandlerInterface
{
    public function handle(\Throwable $throwable): Response;
}
