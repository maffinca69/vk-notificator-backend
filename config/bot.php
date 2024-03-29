<?php

use App\Services\Telegram\Command\{
    LogoutCommand,
    StartCommand,
};

return [
    'token' => env('BOT_TOKEN', ''),
    'username' => env('BOT_USERNAME', ''),
    'commands' => [
        StartCommand::class,
        LogoutCommand::class,
    ],
    'base_api_url' => 'https://api.telegram.org/bot%s/',
];
