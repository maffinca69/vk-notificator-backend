<?php

use App\Infrastructure\Logger\{
    NotificationMailingLogger,
    TelegramClientLogger,
    TelegramWebhookLogger,
    VKHttpClientLogger
};

return [
    TelegramWebhookLogger::class,
    NotificationMailingLogger::class,
    TelegramClientLogger::class,
    VKHttpClientLogger::class
];
