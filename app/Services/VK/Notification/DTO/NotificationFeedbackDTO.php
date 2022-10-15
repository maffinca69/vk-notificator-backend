<?php

namespace App\Services\VK\Notification\DTO;

class NotificationFeedbackDTO
{
    private int $count;

    /** @var array <string, int> */
    private array $ids;

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
}
