<?php

namespace App\Services\VK\DTO\Notification;

class NotificationResponseDTO
{
    private \DateTimeInterface $lastViewed;
    private string $nextFrom;
    private int $ttl;
    private array $notifications;
    private array $profiles;
    private array $groups;

    /**
     * @param array<NotificationDTO> $notifications
     * @param array<ProfileDTO> $profiles
     * @param array<GroupDTO> $groups
     */
    public function __construct(
        array $notifications,
        array $profiles,
        array $groups
    ) {
        $this->notifications = $notifications;
        $this->profiles = $profiles;
        $this->groups = $groups;
    }

    /**
     * @return array<NotificationDTO>
     */
    public function getNotifications(): array
    {
        return $this->notifications;
    }

    /**
     * @return array<ProfileDTO>
     */
    public function getProfiles(): array
    {
        return $this->profiles;
    }

    /**
     * @return array<GroupDTO>
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getLastViewed(): \DateTimeInterface
    {
        return $this->lastViewed;
    }

    /**
     * @param \DateTimeInterface $lastViewed
     */
    public function setLastViewed(\DateTimeInterface $lastViewed): void
    {
        $this->lastViewed = $lastViewed;
    }

    /**
     * @return string
     */
    public function getNextFrom(): string
    {
        return $this->nextFrom;
    }

    /**
     * @param string $nextFrom
     */
    public function setNextFrom(string $nextFrom): void
    {
        $this->nextFrom = $nextFrom;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * @param int $ttl
     */
    public function setTtl(int $ttl): void
    {
        $this->ttl = $ttl;
    }
}
