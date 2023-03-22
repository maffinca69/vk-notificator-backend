<?php

namespace App\Services\VK\Notification;

use App\Infrastructure\VK\Client\Exception\VKAPIHttpClientException;
use App\Models\User;
use App\Models\VKUser;
use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\DTO\Notification\NotificationResponseDTO;
use App\Services\VK\Notification\Attachment\NotificationAttachmentsAssigningService;
use App\Services\VK\Notification\Specification\HasAttachmentsSpecification;
use Illuminate\Cache\RateLimiter;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;

class NotificationMailingService
{
    // Telegram API limit 30 requests as per second
    private const TELEGRAM_MAX_ATTEMPT = 30;

    // VK API limit 3 requests as per second
    private const VK_MAX_ATTEMPT = 3;
    private const TIMEOUT = 1;

    /**
     * @param LastNotificationDateCacheService $lastNotificationDateCacheService
     * @param NotificationGettingService $notificationGettingService
     * @param NotificationSendingServiceFactory $notificationSendingServiceFactory
     * @param NotificationAttachmentsAssigningService $notificationAttachmentsAssigningService
     * @param RateLimiter $rateLimiter
     * @param HasAttachmentsSpecification $hasAttachmentsSpecification
     */
    public function __construct(
        private LastNotificationDateCacheService $lastNotificationDateCacheService,
        private NotificationGettingService $notificationGettingService,
        private NotificationSendingServiceFactory $notificationSendingServiceFactory,
        private NotificationAttachmentsAssigningService $notificationAttachmentsAssigningService,
        private RateLimiter $rateLimiter,
        private HasAttachmentsSpecification $hasAttachmentsSpecification
    ) {
    }

    /**
     * @param VKUser $VKUser
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     * @throws NotFoundExceptionInterface
     * @throws VKAPIHttpClientException
     */
    public function send(VKUser $VKUser): void
    {
        $startTime = $this->getStartTime($VKUser);
        $response = $this->notificationGettingService->get($VKUser, $startTime);

        $notifications = $response->getNotifications();
        if (empty($notifications)) {
            return;
        }

        $notifications = array_reverse($notifications);

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
            if ($this->hasAttachmentsSpecification->isSatisfiedBy($notification)) {
                continue;
            }

            /** @see https://vk.com/support?act=faqs_api&c=5 */
            $attempt = $this->rateLimiter->attempt('vk-api', self::VK_MAX_ATTEMPT, function() use ($VKUser, $notification) {
                $this->notificationAttachmentsAssigningService->assign($VKUser, $notification);
            }, 1);

            if (!$attempt) {
                sleep(self::TIMEOUT);
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
        foreach ($notifications as $notification) {
            $sendingService = $this->notificationSendingServiceFactory->create($notification);

            /** @see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once */
            $attempt = $this->rateLimiter->attempt('telegram-client', self::TELEGRAM_MAX_ATTEMPT, static function() use ($sendingService, $response, $notification, $recipient) {
                $sendingService->send(
                    $response,
                    $notification,
                    $recipient
                );
            }, 1);

            if (!$attempt) {
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
