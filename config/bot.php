<?php

use App\Core\Command\LogoutCommand;
use App\Core\Command\StartCommand;

return [
    'token' => env('BOT_TOKEN', ''),
    'username' => env('BOT_USERNAME', ''),
    'commands' => [
        StartCommand::class,
        LogoutCommand::class,
    ]
];
