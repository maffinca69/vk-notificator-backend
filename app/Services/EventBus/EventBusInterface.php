<?php

namespace App\Services\EventBus;

interface EventBusInterface
{
    /**
     * @param string $message
     * @return void
     */
    public function publish(string $message): void;

    /**
     * @param HandlerInterface $handler
     * @return void
     */
    public function subscribe(HandlerInterface $handler): void;
}
