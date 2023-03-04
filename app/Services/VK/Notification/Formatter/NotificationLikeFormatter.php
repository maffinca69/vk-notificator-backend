<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\Pluralization\PluralizingService;
use App\Services\VK\Notification\Dictionary\NotificationTypesDictionary;
use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\DTO\ProfileDTO;
use App\Services\VK\Notification\Formatter\Link\ProfileLinkFormatter;
use App\Services\VK\Notification\Formatter\Link\VideoLinkFormatter;
use App\Services\VK\Notification\ProfileForNotificationGettingService;
use App\Services\VK\Notification\Translator\ProfileUrlTranslator;

class NotificationLikeFormatter implements NotificationFormatterInterface
{
    public function __construct(
        private ProfileForNotificationGettingService $profileForNotificationGettingService,
        private ProfileLinkFormatter $profileLinkFormatter,
        private ProfileUrlTranslator $profileUrlTranslator,
        private VideoLinkFormatter $videoUrlFormatter,
        private PluralizingService $pluralizingService
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
        $id = reset($ids)['from_id'];
        $profile = $this->profileForNotificationGettingService->getProfile($id, $profiles);
        $parent = $notificationDTO->getParent();
        $countFeedback = $notificationDTO->getFeedback()->getCount();

        $fullName = $this->profileLinkFormatter->format($profile);
        $action = $this->formatAction($profile->getSex(), $countFeedback);
        $type = $this->formatType($notificationDTO);

        $text = $parent?->getText();
        if (!empty($text)) {
            $text = $this->prepareText($text);
        }

        if ($countFeedback > 1) {
            $additionLikeCount = $countFeedback - 1;
            $pluralization = $this->pluralizingService->plural(
                $additionLikeCount,
                ['человек', 'человека'],
                true
            );
            $fullName .= sprintf(' и еще %s', $pluralization);
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
     * @param NotificationDTO $notification
     * @return string
     */
    private function formatType(NotificationDTO $notification): string
    {
        $type = $notification->getType();
        $parent = $notification->getParent();

        // todo разнести на разные форматтеры
        return match ($type) {
            NotificationTypesDictionary::LIKE_COMMENT_PHOTO_TYPE,
            NotificationTypesDictionary::LIKE_COMMENT_TYPE => 'ваш комментарий',
            NotificationTypesDictionary::LIKE_PHOTO_TYPE => 'вашу фотографию',
            NotificationTypesDictionary::LIKE_VIDEO_TYPE => 'вашу ' . $this->videoUrlFormatter->format($parent),
            default => '...',
        };
    }

    /**
     * @param int $sex
     * @param int $countFeedback
     * @return string
     */
    private function formatAction(int $sex, int $countFeedback): string
    {
        if ($countFeedback > 1) {
            return 'оценили';
        }

        return match ($sex) {
            ProfileDTO::FEMALE_SEX_TYPE => 'оценила',
            ProfileDTO::MALE_SEX_TYPE => 'оценил',
            default => '',
        };
    }
}
