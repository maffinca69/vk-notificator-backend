<?php

namespace App\Services\VK\Notification;

use App\Services\VK\Notification\DTO\NotificationDTO;

class NotificationAttachmentsGettingService
{
    /**
     * @param NotificationDTO $notification
     * @return array
     */
    public function get(NotificationDTO $notification): array
    {
        $attachments = [];
        $commentAttachments = $notification->getCommentAttachments();
        if (empty($attachments)) {
            $attachments = $commentAttachments;
        }

        $postAttachments = $notification->getParent()?->getPost()?->getAttachments() ?? [];
        if (empty($attachments)) {
            $attachments = $postAttachments;
        }

        return $attachments;
    }
}
