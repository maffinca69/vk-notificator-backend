<?php

namespace App\Services\Telegram\Client\Request;

class Request
{
    private string $endpoint;
    private string $method;

    /** @var array */
    private array $params;

    /**
     * @param string $endpoint
     * @param string $method
     * @param array $params
     */
    public function __construct(
        string $endpoint,
        string $method,
        array $params
    ) {
        $this->endpoint = $endpoint;
        $this->method = $method;
        $this->params = $params;
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
