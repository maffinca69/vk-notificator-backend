<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\DTO\ProfileDTO;
use App\Services\VK\Notification\ProfileForNotificationGettingService;

class NotificationFollowFormatter implements NotificationFormatterInterface
{
    public function __construct(private ProfileForNotificationGettingService $profileForNotificationGettingService)
    {
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

        $fullName = $this->formatFullName($profile);
        $action = $this->formatAction($profile->getSex());

        return sprintf(
            '%s %s на Ваши объявления',
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
            ProfileDTO::FEMALE_SEX_TYPE => 'подписалась',
            ProfileDTO::MALE_SEX_TYPE => 'подписался',
            default => '',
        };
    }

    /**
     * @param ProfileDTO $profile
     * @return string
     */
    private function formatFullName(ProfileDTO $profile): string
    {
        return sprintf('%s %s', $profile->getFirstName(), $profile->getLastName());
    }
}
