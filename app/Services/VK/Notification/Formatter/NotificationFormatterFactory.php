<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\VK\Notification\DTO\NotificationDTO;
use Illuminate\Container\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationFormatterFactory
{
    public function __construct(private Container $container)
    {
    }

    /**
     * @param NotificationDTO $notification
     * @return NotificationFormatterInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(NotificationDTO $notification): NotificationFormatterInterface
    {
        return match ($notification->getType()) {
            NotificationDTO::LIKE_PHOTO_TYPE,
            NotificationDTO::LIKE_COMMENT_TYPE => $this->container->get(NotificationLikeFormatter::class),
            NotificationDTO::FOLLOW_TYPE => $this->container->get(NotificationFollowFormatter::class),
        };
    }
}
