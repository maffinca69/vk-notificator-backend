<?php

namespace App\Services\Logger;

use Psr\Log\LoggerInterface;

abstract class ServiceLogger implements LoggerInterface
{
    public const DATE_FORMAT = 'Y-m-d';

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function emergency(\Stringable|string $message, array $context = []): void
    {
        $this->logger->emergency($message, $context);
    }

    public function alert(\Stringable|string $message, array $context = []): void
    {
        $this->logger->alert($message, $context);
    }

    public function critical(\Stringable|string $message, array $context = []): void
    {
        $this->logger->critical($message, $context);
    }

    public function error(\Stringable|string $message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }

    public function warning(\Stringable|string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    public function notice(\Stringable|string $message, array $context = []): void
    {
        $this->logger->notice($message, $context);
    }

    public function info(\Stringable|string $message, array $context = []): void
    {
        $this->logger->notice($message, $context);
    }

    public function debug(\Stringable|string $message, array $context = []): void
    {
        $this->logger->debug($message, $context);
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $this->logger->log($level, $message, $context);
    }
}
