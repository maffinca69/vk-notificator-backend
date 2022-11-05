<?php

namespace App\Services\VK\Notification;

use App\Models\User;
use App\Models\VKUser;
use App\Services\Setting\Assembler\SettingDTOAssembler;
use App\Services\Setting\Exception\InvalidSettingTypeException;
use App\Services\Setting\UserSettingsGettingService;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\DTO\NotificationResponseDTO;
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

    /**
     * @param LastNotificationDateCacheService $lastNotificationDateCacheService
     * @param NotificationGettingService $notificationGettingService
     * @param NotificationSendingService $notificationSendingService
     * @param UserSettingsGettingService $settingsGettingService
     * @param SettingDTOAssembler $settingDTOAssembler
     */
    public function __construct(
        private LastNotificationDateCacheService $lastNotificationDateCacheService,
        private NotificationGettingService $notificationGettingService,
        private NotificationSendingService $notificationSendingService,
        private UserSettingsGettingService $settingsGettingService,
        private SettingDTOAssembler $settingDTOAssembler
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
        $startTime = $this->getStartTime($VKUser);
        $response = $this->notificationGettingService->get($VKUser, $startTime);

        $notifications = $response->getNotifications();
        if (empty($notifications)) {
            Log::info('No new notifications');
            return;
        }

        $user = $VKUser->user;
        $this->sendNotifications($response, $user);
        $this->saveLastCheckTime($response, $VKUser);

        $this->markAsViewedIfNeeded($VKUser);
    }

    /**
     * @param VKUser $VKUser
     * @throws InvalidArgumentException
     * @throws InvalidSettingTypeException
     * @throws VKApiException
     * @throws VKClientException
     */
    private function markAsViewedIfNeeded(VKUser $VKUser): void
    {
        $user = $VKUser->user;

        $settings = $this->settingsGettingService->get($user);
        $settings = $this->settingDTOAssembler->create($settings);

        if ($settings->isMarkAsRead()) {
            $this->notificationGettingService->markAsViewed($VKUser);
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
     * @param User $user
     * @throws InvalidTelegramResponseException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function sendNotifications(NotificationResponseDTO $response, User $user): void
    {
        $sendingCount = 0;
        foreach ($response->getNotifications() as $notification) {
            $profiles = $response->getProfiles();
            $groups = $response->getGroups();

            $this->notificationSendingService->send(
                $user,
                $notification,
                $profiles,
                $groups
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
