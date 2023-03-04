<?php

namespace App\Services\VK\DTO\Photo;

/**
 * @reference https://dev.vk.com/reference/objects/photo
 */
class PhotoDTO
{
    /**
     * @param int|null $id
     * @param int|null $albumId
     * @param int|null $userId
     * @param string|null $text
     * @param \DateTimeInterface|null $date
     * @param array<PhotoSizeDTO> $sizes
     */
    public function __construct(
        private ?int $id = null,
        private ?int $albumId = null,
        private ?int $userId = null,
        private ?string $text = null,
        private ?\DateTimeInterface $date = null,
        private array $sizes = [],
    ) {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getAlbumId(): ?int
    {
        return $this->albumId;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return array
     */
    public function getSizes(): array
    {
        return $this->sizes;
    }
}
