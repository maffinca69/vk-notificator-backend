<?php

namespace App\Services\RateLimiter;

class RateLimiterExecutionService
{
    private int $attemptCount = 0;

    /**
     * @param \Closure $callback
     * @param int $limitPerSeconds
     * @param int $timeoutSeconds
     * @return void
     */
    public function execute(\Closure $callback, int $limitPerSeconds, int $timeoutSeconds): void
    {
        $this->attemptCount++;

        $callback();

        if (is_int($this->attemptCount / $limitPerSeconds)) {
            sleep($timeoutSeconds);
        }
    }
}
