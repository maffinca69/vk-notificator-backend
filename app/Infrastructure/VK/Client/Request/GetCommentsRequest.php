<?php

namespace App\Infrastructure\VK\Client\Request;

use App\Infrastructure\VK\Client\ApiMethodDictionary;
use App\Infrastructure\VK\Client\Request\DTO\CommentsRequestDTO;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class GetCommentsRequest extends AbstractRequest
{
    private const ENDPOINT = ApiMethodDictionary::GET_COMMENTS_METHOD;

    private const METHOD = HttpRequest::METHOD_GET;

    /**
     * @param CommentsRequestDTO $commentsRequestDTO
     */
    public function __construct(CommentsRequestDTO $commentsRequestDTO) {
        $params = [
            'owner_id' => $commentsRequestDTO->getOwnerId(),
            'post_id' => $commentsRequestDTO->getPostId(),
            'access_token' => $commentsRequestDTO->getAccessToken(),
        ];

        $count = $commentsRequestDTO->getCount();
        if (!empty($count)) {
            $params['count'] = $count;
        }

        $startCommentId = $commentsRequestDTO->getStartCommentId();
        if (!empty($startCommentId)) {
            $params['start_comment_id'] = $startCommentId;
        }

        parent::__construct(self::ENDPOINT, self::METHOD, $params);
    }
}
