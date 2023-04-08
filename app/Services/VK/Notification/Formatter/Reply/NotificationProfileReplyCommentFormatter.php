<?php

namespace App\Services\VK\Notification\Formatter\Reply;

use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\DTO\Notification\ProfileDTO;
use App\Services\VK\Notification\Formatter\Link\ProfileLinkFormatter;
use App\Services\VK\Notification\Formatter\NotificationFormatterInterface;
use App\Services\VK\Notification\NotificationProfileGettingService;
use App\Services\VK\Notification\Translator\ProfileUrlTranslator;

class NotificationProfileReplyCommentFormatter implements NotificationFormatterInterface
{
    /**
     * @param NotificationProfileGettingService $notificationProfileGettingService
     * @param ProfileLinkFormatter $profileLinkFormatter
     * @param ProfileUrlTranslator $profileUrlTranslator
     */
    public function __construct(
        private NotificationProfileGettingService $notificationProfileGettingService,
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

        $profile = $this->notificationProfileGettingService->getProfile($fromId, $profiles);

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
