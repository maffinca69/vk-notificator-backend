<?php

namespace App\Infrastructure\VK\Client\Request;

use App\Infrastructure\VK\Client\ApiMethodDictionary;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class WallGetByIdRequest extends AbstractRequest
{
    private const ENDPOINT = ApiMethodDictionary::WALL_GET_BY_ID_METHOD;

    private const METHOD = HttpRequest::METHOD_GET;

    /**
     * @param array $postIds
     * @param string $accessToken
     */
    public function __construct(array $postIds, string $accessToken)
    {
        $params =[
            'access_token' => $accessToken,
            'posts' => implode(',', $postIds),
        ];

        parent::__construct(self::ENDPOINT, self::METHOD, $params);
    }
}
