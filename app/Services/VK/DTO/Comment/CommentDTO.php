<?php

namespace App\Services\VK\DTO\Comment;

use App\Services\VK\DTO\Attachment\AttachmentDTO;

/**
 * @reference https://dev.vk.com/reference/objects/comment
 */
class CommentDTO
{
    /**
     * @param int $id
     * @param int $fromId
     * @param \DateTimeInterface $date
     * @param string $text
     * @param array<AttachmentDTO> $attachments
     */
    public function __construct(
        private int $id,
        private int $fromId,
        private \DateTimeInterface $date,
        private string $text,
        private array $attachments,
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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     * @return array
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @param array $attachments
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
