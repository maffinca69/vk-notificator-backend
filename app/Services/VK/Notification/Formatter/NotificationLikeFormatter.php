<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\DTO\ProfileDTO;
use App\Services\VK\Notification\ProfileForNotificationGettingService;

class NotificationLikeFormatter implements NotificationFormatterInterface
{
    public function __construct(private ProfileForNotificationGettingService $profileForNotificationGettingService)
    {
    }

    /**
     * @param NotificationDTO $notificationDTO
     * @param array $profiles
     * @param array $groups
     * @return string
     */
    public function format(NotificationDTO $notificationDTO, array $profiles, array $groups): string
    {
        $ids = $notificationDTO->getFeedback()->getIds();
        $id = current($ids)['from_id'];
        $profile = $this->profileForNotificationGettingService->getProfile($id, $profiles);
        $parent = $notificationDTO->getParent();

        $fullName = $this->formatFullname($profile);
        $action = $this->formatAction($profile->getSex());
        $type = $this->formatType($notificationDTO->getType());

        $text = $parent?->getText();
        if (!empty($text)) {
            $text = sprintf('"%s"', $text);
        }

        return sprintf(
            '❤️ %s %s %s' . PHP_EOL . '%s',
            $fullName,
            $action,
            $type,
            $text
        );
    }

    /**
     * @param string $type
     * @return string
     */
    private function formatType(string $type): string
    {
        return match ($type) {
            NotificationDTO::LIKE_COMMENT_TYPE => 'ваш комментарий',
            NotificationDTO::LIKE_PHOTO_TYPE => 'вашу фотографию',
            default => '...',
        };
    }

    /**
     * @param int $sex
     * @return string
     */
    private function formatAction(int $sex): string
    {
        return match ($sex) {
            ProfileDTO::FEMALE_SEX_TYPE => 'оценила',
            ProfileDTO::MALE_SEX_TYPE => 'оценил',
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
