<?php

namespace App\Services\VK\DTO\Request;

class CommentsRequestDTO
{
    /**
     * @param int $ownerId
     * @param int $postId
     * @param string $accessToken
     * @param int|null $startCommentId
     * @param int|null $count
     */
    public function __construct(
        private int $ownerId,
        private int $postId,
        private string $accessToken,
        private ?int $startCommentId,
        private ?int $count,
    ) {
    }

    /**
     * @param int|null $startCommentId
     */
    public function setStartCommentId(?int $startCommentId): void
    {
        $this->startCommentId = $startCommentId;
    }

    /**
     * @param int|null $count
     */
    public function setCount(?int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return int|null
     */
    public function getStartCommentId(): ?int
    {
        return $this->startCommentId;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }
}
