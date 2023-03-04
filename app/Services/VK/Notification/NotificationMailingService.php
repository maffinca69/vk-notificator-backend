<?php

namespace App\Services\VK\Notification;

use App\Infrastructure\Logger\NotificationMailingLogger;
use App\Infrastructure\VK\Client\Exception\VKAPIHttpClientException;
use App\Models\User;
use App\Models\VKUser;
use App\Services\VK\Comment\CommentGettingService;
use App\Services\VK\Notification\Dictionary\NotificationTypesDictionary;
use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\DTO\NotificationResponseDTO;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class NotificationMailingService
{
    // Telegram API limit 30 messages as per second
    private const MAX_MAILING_LIMIT = 30;
    private const TIMEOUT = 1;

    /**
     * @param LastNotificationDateCacheService $lastNotificationDateCacheService
     * @param NotificationGettingService $notificationGettingService
     * @param NotificationSendingServiceFactory $notificationSendingServiceFactory
     * @param NotificationMailingLogger $logger
     */
    public function __construct(
        private LastNotificationDateCacheService $lastNotificationDateCacheService,
        private NotificationGettingService $notificationGettingService,
        private NotificationSendingServiceFactory $notificationSendingServiceFactory,
        private NotificationMailingLogger $logger,
        private CommentGettingService $commentGettingService
    ) {
    }

    /**
     * @param VKUser $VKUser
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     * @throws NotFoundExceptionInterface
     * @throws VKApiException
     * @throws VKClientException
     */
    public function send(VKUser $VKUser): void
    {
        $startTime = $this->getStartTime($VKUser);
        $response = $this->notificationGettingService->get($VKUser, $startTime);

        $notifications = $response->getNotifications();
        if (empty($notifications)) {
            $this->logger->info('No new notifications');
            return;
        }

        $user = $VKUser->user;

        $this->prepareNotifications($VKUser, ...$notifications);
        $this->sendNotifications($response, $user, ...$notifications);
        $this->saveLastCheckTime($response, $VKUser);
    }

    /**
     * @param VKUser $VKUser
     * @param NotificationDTO ...$notifications
     * @return void
     * @throws VKAPIHttpClientException
     */
    private function prepareNotifications(VKUser $VKUser, NotificationDTO ...$notifications): void
    {
        foreach ($notifications as $notification) {
            if ($notification->getType() === NotificationTypesDictionary::LIKE_COMMENT_TYPE) {
                $ownerId = $notification->getParent()?->getPost()?->getFromId();
                $postId = $notification->getParent()?->getPost()?->getId();
                $commentId = $notification->getParent()?->getId();
                if (!isset($ownerId, $postId, $commentId)) {
                    continue;
                }

                $comment = $this->commentGettingService->get($VKUser, $ownerId, $postId, $commentId);
                $notification->setCommentAttachments($comment?->getAttachments() ?? []);
            }
        }
    }

    /**
     * @param NotificationResponseDTO $response
     * @param VKUser $VKUser
     * @throws InvalidArgumentException
     */
    private function saveLastCheckTime(NotificationResponseDTO $response, VKUser $VKUser): void
    {
        $notifications = $response->getNotifications();

        /** @var NotificationDTO $lastNotification */
        $lastNotification = current($notifications);

        $timestamp = $lastNotification->getDate()->getTimestamp() + 1;
        $this->lastNotificationDateCacheService->save($VKUser, $timestamp);
    }

    /**
     * @param NotificationResponseDTO $response
     * @param User $recipient
     * @param NotificationDTO ...$notifications
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function sendNotifications(NotificationResponseDTO $response, User $recipient, NotificationDTO ...$notifications): void
    {
        $sendingCount = 0;
        foreach ($notifications as $notification) {
            $notificationSendingService = $this->notificationSendingServiceFactory->create($notification);
            $notificationSendingService->send(
                $response,
                $notification,
                $recipient
            );

            $sendingCount++;

            /** @see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once */
            if (is_int($sendingCount / self::MAX_MAILING_LIMIT)) {
                sleep(self::TIMEOUT);
            }
        }
    }

    /**
     * @param VKUser $VKUser
     * @return int
     * @throws InvalidArgumentException
     */
    private function getStartTime(VKUser $VKUser): int
    {
        $lastNotificationDate = $this->lastNotificationDateCacheService->get($VKUser);

        if ($lastNotificationDate === null) {
            $lastNotificationDate = time();
            $this->lastNotificationDateCacheService->save($VKUser, $lastNotificationDate);
        }

        return $lastNotificationDate;
    }
}
