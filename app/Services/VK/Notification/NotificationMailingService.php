<?php

namespace App\Services\VK\Notification;

use App\Models\User;
use App\Models\VKUser;
use App\Services\Setting\Assembler\SettingDTOAssembler;
use App\Services\Setting\DTO\SettingDTO;
use App\Services\Setting\Exception\InvalidSettingTypeException;
use App\Services\Setting\UserSettingsGettingService;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\DTO\NotificationResponseDTO;
use App\Services\VK\Notification\Filter\ViewedNotificationsFilteringService;
use Illuminate\Support\Facades\Log;
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
    private SettingDTO $settings;

    /**
     * @param LastNotificationDateCacheService $lastNotificationDateCacheService
     * @param NotificationGettingService $notificationGettingService
     * @param NotificationSendingService $notificationSendingService
     * @param UserSettingsGettingService $settingsGettingService
     * @param SettingDTOAssembler $settingDTOAssembler
     * @param ViewedNotificationsFilteringService $viewedNotificationsFilteringService
     */
    public function __construct(
        private LastNotificationDateCacheService $lastNotificationDateCacheService,
        private NotificationGettingService $notificationGettingService,
        private NotificationSendingService $notificationSendingService,
        private UserSettingsGettingService $settingsGettingService,
        private SettingDTOAssembler $settingDTOAssembler,
        private ViewedNotificationsFilteringService $viewedNotificationsFilteringService
    ) {
    }

    /**
     * @param VKUser $VKUser
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     * @throws InvalidTelegramResponseException
     * @throws NotFoundExceptionInterface
     * @throws InvalidSettingTypeException
     * @throws VKApiException
     * @throws VKClientException
     */
    public function send(VKUser $VKUser): void
    {
        $this->prepareSettings($VKUser->user);

        $startTime = $this->getStartTime($VKUser);
        $response = $this->notificationGettingService->get($VKUser, $startTime);

        $notifications = $response->getNotifications();
        if (empty($notifications)) {
            Log::info('No new notifications');
            return;
        }

        $user = $VKUser->user;

        if (!$this->settings->isSendViewedNotifications()) {
            $viewedTime = $response->getLastViewed()->getTimestamp();
            $notifications = $this->viewedNotificationsFilteringService->filter($viewedTime, ...$notifications);
        }

        $this->sendNotifications($response, $user, ...$notifications);
        $this->saveLastCheckTime($response, $VKUser);

        if ($this->settings->isMarkAsRead()) {
            $this->notificationGettingService->markAsViewed($VKUser);
        }
    }

    /**
     * @param User $user
     * @throws InvalidArgumentException
     * @throws InvalidSettingTypeException
     */
    private function prepareSettings(User $user): void
    {
        $settings = $this->settingsGettingService->get($user);
        $this->settings = $this->settingDTOAssembler->create($settings);
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
     * @throws InvalidTelegramResponseException
     * @throws NotFoundExceptionInterface
     */
    private function sendNotifications(NotificationResponseDTO $response, User $recipient, NotificationDTO ...$notifications): void
    {
        $sendingCount = 0;
        foreach ($notifications as $notification) {
            $this->notificationSendingService->send(
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
