<?php

namespace App\Core\Command;

use App\Core\DTO\UpdateDTO;

interface CommandInterface
{
    /**
     * @param UpdateDTO $update
     *
     * @return void
     */
    public function handle(UpdateDTO $update): void;
}
