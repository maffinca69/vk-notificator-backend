<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\DTO\ProfileDTO;
use App\Services\VK\Notification\ProfileForNotificationGettingService;
use App\Services\VK\Notification\Translator\ProfileUrlTranslator;

class NotificationReplyCommentType implements NotificationFormatterInterface
{
    public function __construct(
        private ProfileForNotificationGettingService $profileForNotificationGettingService,
        private ProfileLinkFormatter $profileLinkFormatter,
        private ProfileUrlTranslator $profileUrlTranslator
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
        $commentText = $feedback->getText();

        $profile = $this->profileForNotificationGettingService->getProfile($fromId, $profiles);

        $fullName = $this->profileLinkFormatter->format($profile);
        $action = $this->formatAction($profile->getSex());
        $comment = $this->profileUrlTranslator->translate($commentText);

        return sprintf(
            '💬 %s %s на Ваш комментарий:' . PHP_EOL . '%s',
            $fullName,
            $action,
            $comment,
        );
    }

    /**
     * @param int $sex
     * @return string
     */
    private function formatAction(int $sex): string
    {
        return match ($sex) {
            ProfileDTO::FEMALE_SEX_TYPE => 'ответила',
            ProfileDTO::MALE_SEX_TYPE => 'ответил',
            default => ''
        };
    }
}
