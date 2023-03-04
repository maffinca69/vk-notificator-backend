<?php

namespace App\Infrastructure\Telegram\Client\Request;

abstract class AbstractRequest
{
    /**
     * @param string $endpoint
     * @param string $method
     * @param array $params
     */
    public function __construct(
        private string $endpoint,
        private string $method,
        private array $params
    ) {
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
