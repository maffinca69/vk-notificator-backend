<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\VK\Notification\DTO\NotificationDTO;

interface NotificationFormatterInterface
{
    /**
     * @param NotificationDTO $notification
     * @param array $profiles
     * @param array $groups
     * @return string
     */
    public function format(NotificationDTO $notification, array $profiles, array $groups): string;
}
