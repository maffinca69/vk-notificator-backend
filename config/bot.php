<?php

use App\Core\Command\LogoutCommand;
use App\Core\Command\SettingsCommand;
use App\Core\Command\StartCommand;

return [
    'token' => env('BOT_TOKEN', ''),
    'username' => env('BOT_USERNAME', ''),
    'commands' => [
        StartCommand::class,
        LogoutCommand::class,
        SettingsCommand::class,
    ],
    'settings_url' => env('BOT_SETTINGS_URL', ''),
    'base_api_url' => 'https://api.telegram.org/bot%s/',
];
