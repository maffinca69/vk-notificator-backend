<?php

namespace App\Infrastructure\Telegram\Client\Request;

use App\Infrastructure\Telegram\Client\ApiMethodDictionary;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class SetWebhookRequest extends AbstractRequest
{
    private const ENDPOINT = ApiMethodDictionary::SET_WEBHOOK_METHOD;

    private const METHOD = HttpRequest::METHOD_GET;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $params = [
            'url' => $url,
        ];

        parent::__construct(self::ENDPOINT, self::METHOD, $params);
    }
}
