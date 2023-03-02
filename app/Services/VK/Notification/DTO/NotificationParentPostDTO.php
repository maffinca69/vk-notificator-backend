<?php

namespace App\Services\VK\Notification\DTO;

use App\Services\VK\DTO\Attachment\AttachmentDTO;

class NotificationParentPostDTO
{
    private int $id;
    private int $fromId;
    private int $toId;
    private \DateTimeInterface $date;
    private bool $isFavorite;
    private string $postType;
    private string $text;
    private int $singerId;
    private float $shortTextRate;
    private array $attachments = [];

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
    public function getFromId(): int
    {
        return $this->fromId;
    }

    /**
     * @param int $fromId
     */
    public function setFromId(int $fromId): void
    {
        $this->fromId = $fromId;
    }

    /**
     * @return int
     */
    public function getToId(): int
    {
        return $this->toId;
    }

    /**
     * @param int $toId
     */
    public function setToId(int $toId): void
    {
        $this->toId = $toId;
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
     * @return bool
     */
    public function isFavorite(): bool
    {
        return $this->isFavorite;
    }

    /**
     * @param bool $isFavorite
     */
    public function setIsFavorite(bool $isFavorite): void
    {
        $this->isFavorite = $isFavorite;
    }

    /**
     * @return string
     */
    public function getPostType(): string
    {
        return $this->postType;
    }

    /**
     * @param string $postType
     */
    public function setPostType(string $postType): void
    {
        $this->postType = $postType;
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
     * @return int
     */
    public function getSingerId(): int
    {
        return $this->singerId;
    }

    /**
     * @param int $singerId
     */
    public function setSingerId(int $singerId): void
    {
        $this->singerId = $singerId;
    }

    /**
     * @return float
     */
    public function getShortTextRate(): float
    {
        return $this->shortTextRate;
    }

    /**
     * @param float $shortTextRate
     */
    public function setShortTextRate(float $shortTextRate): void
    {
        $this->shortTextRate = $shortTextRate;
    }

    /**
     * @return array<AttachmentDTO>
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @param array<AttachmentDTO> $attachments
     */
    public function setAttachments(array $attachments): void
    {
        $this->attachments = $attachments;
    }

    /**
     * @param AttachmentDTO $attachment
     */
    public function addAttachment(AttachmentDTO $attachment): void
    {
        $this->attachments[] = $attachment;
    }
}
