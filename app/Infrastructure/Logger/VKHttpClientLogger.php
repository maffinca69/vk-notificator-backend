<?php

namespace App\Infrastructure\Logger;

use App\Services\Logger\ServiceLogger;

class VKHttpClientLogger extends ServiceLogger
{
    public const LOG_COLLECTION = 'vk_client';
}
