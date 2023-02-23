<?php

use App\Infrastructure\Logger\NotificationMailingLogger;
use App\Infrastructure\Logger\TelegramClientLogger;
use App\Infrastructure\Logger\TelegramWebhookLogger;

return [
    TelegramWebhookLogger::class,
    NotificationMailingLogger::class,
    TelegramClientLogger::class,
];
