<?php

namespace App\Services\VK\Notification\Keyboard;

use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\DTO\Notification\NotificationParentDTO;
use App\Services\VK\Notification\Formatter\Link\WallReplyLinkFormatter;

class ReplyMarkupCreatingService
{
    private const NOTIFICATION_PAGE_URL = 'https://vk.com/feed?section=notifications';

    public function __construct(
        private UrlButtonBuildingService $urlButtonBuildingService,
        private WallReplyLinkFormatter $wallReplyLinkFormatter
    ) {
    }

    /**
     * @param NotificationDTO $notification
     * @return array
     */
    public function create(NotificationDTO $notification): array
    {
        $buttons[] = $this->appendNotificationUrlButton();

        $parent = $notification->getParent();
        if ($parent !== null) {
            $buttons[] = $this->appendReplyUrlButton($parent);
        }

        return [
            'inline_keyboard' => array_filter($buttons)
        ];
    }

    /**
     * @return array
     */
    private function appendNotificationUrlButton(): array
    {
        return $this->urlButtonBuildingService->build('Открыть уведомления', self::NOTIFICATION_PAGE_URL);
    }

    /**
     * @param NotificationParentDTO $parent
     * @return array
     */
    private function appendReplyUrlButton(NotificationParentDTO $parent): array
    {
        if ($parent->getPost() === null) {
            return [];
        }

        $url = $this->wallReplyLinkFormatter->format($parent);
        return $this->urlButtonBuildingService->build('Открыть пост', $url);
    }
}
