<?php

namespace App\Infrastructure\VK\Client\Request;

use App\Infrastructure\VK\Client\ApiMethodDictionary;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class GetNotificationRequest extends AbstractRequest
{
    private const ENDPOINT = ApiMethodDictionary::GET_NOTIFICATIONS_METHOD;

    private const METHOD = HttpRequest::METHOD_GET;

    /**
     * @param array $params
     * @param string $accessToken
     */
    public function __construct(array $params, string $accessToken)
    {
        $params['access_token'] = $accessToken;

        parent::__construct(self::ENDPOINT, self::METHOD, $params);
    }
}
