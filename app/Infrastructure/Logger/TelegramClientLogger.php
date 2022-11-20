<?php

namespace App\Infrastructure\Logger;

use App\Services\Logger\ServiceLogger;

class TelegramClientLogger extends ServiceLogger
{
    public const LOG_COLLECTION = 'telegram_client';
}
