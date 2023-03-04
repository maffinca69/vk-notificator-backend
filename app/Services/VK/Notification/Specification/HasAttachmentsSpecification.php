<?php

namespace App\Services\VK\Notification\Specification;

use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\Notification\Attachment\NotificationAttachmentsGettingService;

class HasAttachmentsSpecification
{
    public function __construct(private NotificationAttachmentsGettingService $notificationAttachmentsGettingService)
    {
    }

    /**
     * @param NotificationDTO $notification
     * @return bool
     */
    public function isSatisfiedBy(NotificationDTO $notification): bool
    {
        $attachments = $this->notificationAttachmentsGettingService->get($notification);

        return !empty($attachments);
    }
}
