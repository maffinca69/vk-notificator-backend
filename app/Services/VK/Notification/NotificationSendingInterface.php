<?php

namespace App\Services\VK\Notification;

use App\Models\User;
use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\DTO\Notification\NotificationResponseDTO;

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
