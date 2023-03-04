<?php

namespace App\Services\VK\DTO\Notification;

use App\Services\VK\DTO\Photo\PhotoSizeDTO;

class NotificationParentDTO
{
    private int $id;
    private int $ownerId;
    private \DateTimeInterface $date;
    private ?string $text = null;
    private ?NotificationParentPostDTO $post = null;

    /** @var PhotoSizeDTO ...$sizes */
    private array $sizes = [];

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
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return NotificationParentPostDTO|null
     */
    public function getPost(): ?NotificationParentPostDTO
    {
        return $this->post;
    }

    /**
     * @param NotificationParentPostDTO|null $post
     */
    public function setPost(?NotificationParentPostDTO $post): void
    {
        $this->post = $post;
    }

    /**
     * @return array<PhotoSizeDTO>
     */
    public function getSizes(): array
    {
        return $this->sizes;
    }

    /**
     * @param array<PhotoSizeDTO> $sizes
     */
    public function setSizes(array $sizes): void
    {
        $this->sizes = $sizes;
    }

    /**
     * @param PhotoSizeDTO $size
     */
    public function addSize(PhotoSizeDTO $size): void
    {
        $this->sizes[] = $size;
    }
}
