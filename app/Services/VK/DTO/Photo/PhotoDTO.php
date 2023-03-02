<?php

namespace App\Services\VK\DTO\Photo;

/**
 * @reference https://dev.vk.com/reference/objects/photo
 */
class PhotoDTO
{
    /**
     * @param int $id
     * @param int $albumId
     * @param int $userId
     * @param string $text
     * @param \DateTimeInterface $date
     * @param array<PhotoSizeDTO> $sizes
     */
    public function __construct(
        private int $id,
        private int $albumId,
        private int $userId,
        private string $text,
        private \DateTimeInterface $date,
        private array $sizes,
    ) {
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
    public function getAlbumId(): int
    {
        return $this->albumId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return array<PhotoSizeDTO>
     */
    public function getSizes(): array
    {
        return $this->sizes;
    }
}
