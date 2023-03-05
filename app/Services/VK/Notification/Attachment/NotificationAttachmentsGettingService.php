<?php

namespace App\Services\VK\Notification\Attachment;

use App\Services\VK\DTO\Attachment\AttachmentDTO;
use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\DTO\Photo\PhotoDTO;

class NotificationAttachmentsGettingService
{
    /**
     * @param NotificationDTO $notification
     * @return array<AttachmentDTO>
     */
    public function get(NotificationDTO $notification): array
    {
        $attachments = [];
        $commentAttachments = $notification->getCommentAttachments();
        if (empty($attachments)) {
            $attachments = $commentAttachments;
        }

        $postAttachments = $notification->getPostAttachments();
        if (empty($attachments)) {
            $attachments = $postAttachments;
        }

        $parentAttachment = $this->getParentAttachment($notification);
        if (empty($attachments) && $parentAttachment !== null) {
            $attachments = [$parentAttachment];
        }

        $parentAttachment = $this->getParentAttachment($notification);
        if (empty($attachments) && $parentAttachment !== null) {
            $attachments = [$parentAttachment];
        }

        $parentPostAttachments = $notification->getParent()?->getPost()?->getAttachments() ?? [];
        if (empty($attachments)) {
            $attachments = $parentPostAttachments;
        }

        return $attachments;
    }

    /**
     * @param NotificationDTO $notification
     * @return AttachmentDTO|null
     */
    private function getParentAttachment(NotificationDTO $notification): ?AttachmentDTO
    {
        $parentAttachments = $notification->getParent()?->getSizes() ?? [];
        if (empty($parentAttachments)) {
            return null;
        }

        return new AttachmentDTO(
            AttachmentDTO::PHOTO_TYPE,
            new PhotoDTO(sizes: $parentAttachments)
        );
    }
}
