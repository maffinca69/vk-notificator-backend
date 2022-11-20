<?php

namespace App\Infrastructure\Logger;

use App\Services\Logger\ServiceLogger;

class NotificationMailingLogger extends ServiceLogger
{
    public const LOG_COLLECTION = 'notification_mailing';
}
