<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\DTO\Notification\ProfileDTO;
use App\Services\VK\Notification\Formatter\Link\ProfileLinkFormatter;
use App\Services\VK\Notification\ProfileForNotificationGettingService;

class NotificationFriendAcceptedFormatter implements NotificationFormatterInterface
{
    public function __construct(
        private ProfileForNotificationGettingService $profileForNotificationGettingService,
        private ProfileLinkFormatter $profileLinkFormatter,
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
        $ids = $notification->getFeedback()->getIds();
        $id = current($ids)['from_id'];

        $profile = $this->profileForNotificationGettingService->getProfile($id, $profiles);

        $fullName = $this->profileLinkFormatter->format($profile);
        $action = $this->formatAction($profile->getSex());

        return sprintf(
            '👋 %s %s Вашу заявку в друзья',
            $fullName,
            $action
        );
    }

    /**
     * @param int $sex
     * @return string
     */
    private function formatAction(int $sex): string
    {
        return match ($sex) {
            ProfileDTO::MALE_SEX_TYPE => 'одобрил',
            ProfileDTO::FEMALE_SEX_TYPE => 'одобрила',
            default => '',
        };
    }
}
