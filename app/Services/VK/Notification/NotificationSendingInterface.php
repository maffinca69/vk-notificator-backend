<?php

namespace App\Services\VK\Notification;

use App\Models\User;
use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\DTO\NotificationResponseDTO;

interface NotificationSendingInterface
{
    /**
     * @param NotificationResponseDTO $response
     * @param NotificationDTO $notification
     * @param User $recipient
     * @return void
     */
    public function send(NotificationResponseDTO $response, NotificationDTO $notification, User $recipient): void;
}
