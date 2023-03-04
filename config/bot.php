<?php

use App\Services\Telegram\Command\LogoutCommand;
use App\Services\Telegram\Command\StartCommand;

return [
    'token' => env('BOT_TOKEN', ''),
    'username' => env('BOT_USERNAME', ''),
    'commands' => [
        StartCommand::class,
        LogoutCommand::class,
    ],
    'base_api_url' => 'https://api.telegram.org/bot%s/',
];
