<?php

namespace App\Core\Command;

abstract class AbstractCommand implements CommandInterface
{
    protected string $signature;

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }
}
