<?php

namespace App\Services\VK\Notification\Formatter\Reply;

use App\Services\VK\DTO\Notification\GroupDTO;
use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\DTO\Notification\ProfileDTO;
use App\Services\VK\Notification\Formatter\NotificationFormatterInterface;
use App\Services\VK\Notification\NotificationGroupGettingService;
use App\Services\VK\Notification\ProfileForNotificationGettingService;

class NotificationReplyCommentFormatter implements NotificationFormatterInterface
{
    public function __construct(
        private ProfileForNotificationGettingService $profileForNotificationGettingService,
        private NotificationGroupGettingService $notificationGroupGettingService,
        private NotificationGroupReplyCommentFormatter $groupReplyCommentFormatter,
        private NotificationProfileReplyCommentFormatter $profileReplyCommentFormatter,
    ) {
    }

    /**
     * @param NotificationDTO $notification
     * @param array $profiles
     * @param array $groups
     * @return string
     */
    public function format(NotificationDTO $notification, array $profiles, array $groups): string
    {
        $feedback = $notification->getFeedback();
        $fromId = $feedback->getFromId();

        $profile = $this->profileForNotificationGettingService->getProfile($fromId, $profiles);
        if ($profile instanceof ProfileDTO) {
            return $this->profileReplyCommentFormatter->format($notification, $profiles, $groups);
        }

        $group = $this->notificationGroupGettingService->getGroup($fromId, $groups);
        if ($group instanceof GroupDTO) {
            return $this->groupReplyCommentFormatter->format($notification, $profiles, $groups);
        }

        throw new \RuntimeException('Unknown reply comment action');
    }
}
