<?php

namespace App\Services\VK\DTO\Notification;

class NotificationFeedbackDTO
{
    /**
     * @param int $count
     * @param array<string, int> $ids
     * @param int|null $fromId
     * @param int|null $id
     * @param string|null $text
     * @param int|null $ownerId
     * @param string|null $type
     */
    public function __construct(
        private int $count,
        private array $ids,
        private ?int $fromId = null,
        private ?int $id = null,
        private ?string $text = null,
        private ?int $ownerId = null,
        private ?string $type = null
    ) {
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return array
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    /**
     * @return int|null
     */
    public function getFromId(): ?int
    {
        return $this->fromId;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return int|null
     */
    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}
