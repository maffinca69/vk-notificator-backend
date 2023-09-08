<?php

namespace App\Services\Logger\DTO;

class HttpLoggerDTO
{
    public function __construct(
        private readonly string $appName,
        private readonly string $request,
        private readonly string $response,
        private readonly string $ip,
        private readonly string $userAgent,
        private readonly string $pid,
        private readonly string $route,
    ) {
    }

    public function getAppName(): string
    {
        return $this->appName;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function getPid(): string
    {
        return $this->pid;
    }

    public function getRoute(): string
    {
        return $this->route;
    }
}
