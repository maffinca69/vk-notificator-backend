<?php

namespace App\Services\VK\DTO\Notification;

class NotificationFeedbackDTO
{
    private int $count;

    /** @var array <string, int> */
    private array $ids;

    private ?int $fromId = null;
    private ?int $Id = null;
    private ?string $text = null;

    /**
     * @param int $count
     * @param array $ids
     */
    public function __construct(int $count, array $ids)
    {
        $this->count = $count;
        $this->ids = $ids;
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
     * @param int|null $fromId
     */
    public function setFromId(?int $fromId): void
    {
        $this->fromId = $fromId;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->Id;
    }

    /**
     * @param int|null $Id
     */
    public function setId(?int $Id): void
    {
        $this->Id = $Id;
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
}
