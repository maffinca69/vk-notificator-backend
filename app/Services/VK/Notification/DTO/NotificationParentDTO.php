<?php

namespace App\Services\VK\Notification\DTO;

class NotificationParentDTO
{
    private int $id;
    private int $ownerId;
    private \DateTimeInterface $date;
    private string $text;
    private NotificationParentPostDTO $post;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    /**
     * @param int $ownerId
     */
    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     */
    public function setDate(\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return NotificationParentPostDTO
     */
    public function getPost(): NotificationParentPostDTO
    {
        return $this->post;
    }

    /**
     * @param NotificationParentPostDTO $post
     */
    public function setPost(NotificationParentPostDTO $post): void
    {
        $this->post = $post;
    }
}
