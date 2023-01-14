<?php

namespace App\Services\VK\Notification\Formatter\Link;

use App\Services\VK\Notification\DTO\NotificationParentDTO;

final class WallReplyLinkFormatter
{
    public const WALL_URL = 'https://vk.com/wall%s_%s?reply=%s';

    /**
     * @param NotificationParentDTO $parent
     * @return string
     */
    public function format(NotificationParentDTO $parent): string
    {
        $post = $parent->getPost();

        return sprintf(self::WALL_URL, $post->getFromId(), $post->getId(), $parent->getId());
    }
}
