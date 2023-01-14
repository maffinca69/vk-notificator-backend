<?php

namespace App\Services\VK\Notification\Formatter\Link;

use App\Services\Telegram\Formatter\HyperLinkFormatter;
use App\Services\VK\Notification\DTO\NotificationParentDTO;

final class VideoLinkFormatter
{
    public const VK_VIDEO_BASE_URL = 'https://vk.com/video';
    public const VIDEO_NAME = 'Видеозапись';

    public function __construct(private HyperLinkFormatter $hyperLinkFormatter)
    {
    }

    /**
     * @param NotificationParentDTO $notificationParent
     * @return string
     */
    public function format(NotificationParentDTO $notificationParent): string
    {
        $url = $this->formatUrl($notificationParent);

        return $this->hyperLinkFormatter->format($url, self::VIDEO_NAME);
    }

    /**
     * @param NotificationParentDTO $notificationParent
     * @return string
     */
    public function formatUrl(NotificationParentDTO $notificationParent)
    {
        return self::VK_VIDEO_BASE_URL . sprintf(
            '%s_%s',
            $notificationParent->getOwnerId(),
            $notificationParent->getId(),
        );
    }
}
