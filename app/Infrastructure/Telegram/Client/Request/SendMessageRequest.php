<?php

namespace App\Infrastructure\Telegram\Client\Request;

use App\Infrastructure\Telegram\Client\ApiMethodDictionary;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class SendMessageRequest extends AbstractRequest
{
    private const ENDPOINT = ApiMethodDictionary::SEND_MESSAGE_METHOD;

    private const METHOD = HttpRequest::METHOD_POST;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        parent::__construct(self::ENDPOINT, self::METHOD, $params);
    }
}
