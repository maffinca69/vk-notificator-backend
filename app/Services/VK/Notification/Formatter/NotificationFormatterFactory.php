<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\Notification\Dictionary\NotificationTypesDictionary;
use App\Services\VK\Notification\Exception\UnknownNotificationTypeException;
use App\Services\VK\Notification\Formatter\Reply\NotificationReplyCommentFormatter;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationFormatterFactory
{
    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * @param NotificationDTO $notification
     * @return NotificationFormatterInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws UnknownNotificationTypeException
     */
    public function create(NotificationDTO $notification): NotificationFormatterInterface
    {
        $type = $notification->getType();

        return match ($type) {
            NotificationTypesDictionary::LIKE_VIDEO_TYPE,
            NotificationTypesDictionary::LIKE_PHOTO_TYPE,
            NotificationTypesDictionary::LIKE_COMMENT_PHOTO_TYPE,
            NotificationTypesDictionary::LIKE_COMMENT_VIDEO_TYPE,
            NotificationTypesDictionary::LIKE_COMMENT_TOPIC_TYPE,
            NotificationTypesDictionary::LIKE_COMMENT_TYPE => $this->container->get(NotificationLikeFormatter::class),
            NotificationTypesDictionary::FOLLOW_TYPE => $this->container->get(NotificationFollowFormatter::class),
            NotificationTypesDictionary::FRIEND_ACCEPTED_TYPE => $this->container->get(NotificationFriendAcceptedFormatter::class),
            NotificationTypesDictionary::WALL_PUBLISH_TYPE => $this->container->get(NotificationWallPublishFormatter::class),
            NotificationTypesDictionary::REPLY_COMMENT_TYPE => $this->container->get(NotificationReplyCommentFormatter::class),
            default => throw new UnknownNotificationTypeException($type)
        };
    }
}
