<?php

namespace App\Services\VK\Comment;

use App\Infrastructure\VK\Client\Exception\VKAPIHttpClientException;
use App\Infrastructure\VK\Client\HttpClient;
use App\Infrastructure\VK\Client\Request\DTO\CommentsRequestDTO;
use App\Infrastructure\VK\Client\Request\GetCommentsRequest;
use App\Models\VKUser;
use App\Services\VK\Comment\Assembler\CommentDTOAssembler;
use App\Services\VK\DTO\Comment\CommentDTO;

class CommentGettingService
{
    /**
     * @param HttpClient $client
     * @param CommentDTOAssembler $commentDTOAssembler
     */
    public function __construct(
        private HttpClient $client,
        private CommentDTOAssembler $commentDTOAssembler
    ) {
    }

    /**
     * VK API НЕ позволяет получить комментарий напрямую через wall.getComment
     * Поэтому получаем список комментариев у поста с start_comment_id + count=1
     *
     * Так же технически невозможно получить комментарий сразу, если он находится в ветке, т.к в API нет такой функции
     * Для этого нужно запрашивать все комментарии и проходится по ним в рантайме
     * Из-за этого поиск получается рандомным, т.к есть ограничение на кол-во комментариев в ветке
     *
     * @param VKUser $VKUser
     * @param int $ownerId
     * @param int $postId
     * @param int $startCommentId
     * @return CommentDTO|null
     * @throws VKAPIHttpClientException
     */
    public function get(
        VKUser $VKUser,
        int $ownerId,
        int $postId,
        int $startCommentId
    ): ?CommentDTO {
        $accessToken = $VKUser->getAccessToken();

        $commentsRequestDTO = new CommentsRequestDTO(
            $ownerId,
            $postId,
            $accessToken,
            $startCommentId,
            1
        );
        $request = new GetCommentsRequest($commentsRequestDTO);
        $response = $this->client->sendRequest($request);

        $items = $response['items'];
        if (empty($items)) {
            return null;
        }

        $comment = reset($items);

        if (empty($comment['id'])) {
            throw new \InvalidArgumentException('ID is missing, invalid params');
        }

        // Если комментарий находится в ветке, то может прийти другой комментарий
        if ($comment['id'] !== $startCommentId) {
            return null;
        }

        return $this->commentDTOAssembler->create($comment);
    }
}
