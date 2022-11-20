<?php

namespace App\Infrastructure\Logger;

use App\Services\Logger\ServiceLogger;

class TelegramWebhookLogger extends ServiceLogger
{
    public const LOG_COLLECTION = 'telegram_webhook';
}
