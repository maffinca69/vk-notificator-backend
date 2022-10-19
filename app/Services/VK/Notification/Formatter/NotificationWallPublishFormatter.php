<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\NotificationGroupGettingService;

class NotificationWallPublishFormatter implements NotificationFormatterInterface
{
    public function __construct(
        private NotificationGroupGettingService $notificationGroupGettingService,
        private GroupLinkFormatter $groupLinkFormatter,
        private PostLinkFormatter $postLinkFormatter
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
        $fromId = $notification->getFeedback()->getFromId();
        $id = $notification->getFeedback()->getId();
        $group = $this->notificationGroupGettingService->getGroup($fromId, $groups);

        $fullName = $this->groupLinkFormatter->format($group);
        $postName = $this->postLinkFormatter->format(
            $fromId,
            $id,
            'запись'
        );

        return sprintf('Сообщество %s опубликовало предложенную Вами %s', $fullName, $postName);
    }
}
