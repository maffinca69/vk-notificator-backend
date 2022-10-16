<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\DTO\ProfileDTO;
use App\Services\VK\Notification\ProfileForNotificationGettingService;
use App\Services\VK\Notification\Translator\ProfileUrlTranslator;

class NotificationLikeFormatter implements NotificationFormatterInterface
{
    public function __construct(
        private ProfileForNotificationGettingService $profileForNotificationGettingService,
        private ProfileLinkFormatter $profileLinkFormatter,
        private ProfileUrlTranslator $profileUrlTranslator
    ) {
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

        $fullName = $this->profileLinkFormatter->format($profile);
        $action = $this->formatAction($profile->getSex());
        $type = $this->formatType($notificationDTO->getType());

        $text = $parent?->getText();
        if (!empty($text)) {
            $text = $this->prepareText($text);
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
     * @param string $text
     * @return string
     */
    private function prepareText(string $text): string
    {
        $translatedText = $this->profileUrlTranslator->translate($text);

        return sprintf('"%s"', $translatedText);
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
}
