<?php

namespace App\Services\VK\Notification\Filter;

use App\Services\VK\Notification\DTO\NotificationDTO;

class ViewedNotificationsFilteringService
{
    /**
     * @param int $viewedTime
     * @param NotificationDTO ...$notifications
     * @return array
     */
    public function filter(int $viewedTime, NotificationDTO ...$notifications): array
    {
       return array_filter(
           $notifications,
           fn($notification) => $notification->getDate()->getTimestamp() > $viewedTime
       );
    }
}
