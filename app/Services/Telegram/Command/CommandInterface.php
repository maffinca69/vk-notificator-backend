<?php

namespace App\Services\Telegram\Command;

use App\Services\Telegram\DTO\UpdateDTO;

interface CommandInterface
{
    /**
     * @param UpdateDTO $update
     *
     * @return void
     */
    public function handle(UpdateDTO $update): void;
}
