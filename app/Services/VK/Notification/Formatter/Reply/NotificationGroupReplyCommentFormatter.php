<?php

namespace App\Services\VK\Notification\Formatter\Reply;

use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\Notification\Formatter\Link\GroupLinkFormatter;
use App\Services\VK\Notification\Formatter\NotificationFormatterInterface;
use App\Services\VK\Notification\NotificationGroupGettingService;
use App\Services\VK\Notification\Translator\ProfileUrlTranslator;

class NotificationGroupReplyCommentFormatter implements NotificationFormatterInterface
{
    /**
     * @param NotificationGroupGettingService $notificationGroupGettingService
     * @param GroupLinkFormatter $groupLinkFormatter
     * @param ProfileUrlTranslator $profileUrlTranslator
     */
    public function __construct(
        private NotificationGroupGettingService $notificationGroupGettingService,
        private GroupLinkFormatter $groupLinkFormatter,
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

        $group = $this->notificationGroupGettingService->getGroup($fromId, $groups);

        $fullName = $this->groupLinkFormatter->format($group);
        $comment = $this->profileUrlTranslator->translate($commentText);

        return sprintf(
            '💬 Сообщество %s ответило на Ваш комментарий:' . PHP_EOL . '%s',
            $fullName,
            $comment,
        );
    }
}
