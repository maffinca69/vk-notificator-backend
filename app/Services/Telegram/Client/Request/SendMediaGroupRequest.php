<?php

namespace App\Services\Telegram\Client\Request;

use App\Services\Telegram\Client\ApiMethodDictionary;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class SendMediaGroupRequest extends AbstractRequest
{
    private const ENDPOINT = ApiMethodDictionary::SEND_MEDIA_GROUP_METHOD;

    private const METHOD = HttpRequest::METHOD_POST;

    public function __construct(array $params)
    {
        parent::__construct(self::ENDPOINT, self::METHOD, $params);
    }
}
