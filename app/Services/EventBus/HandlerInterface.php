<?php

namespace App\Services\EventBus;

interface HandlerInterface
{
    /**
     * @param string $message
     * @return void
     */
    public function handle(string $message): void;
}
