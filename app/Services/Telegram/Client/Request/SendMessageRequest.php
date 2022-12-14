<?php

namespace App\Services\Telegram\Client\Request;

use App\Services\Telegram\Client\ApiMethodDictionary;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class SendMessageRequest extends Request
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
