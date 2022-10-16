<?php

namespace App\Console\Commands;

use App\Models\VKUser;
use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\LastNotificationDateCacheService;
use App\Services\VK\Notification\NotificationGettingService;
use App\Services\VK\Notification\NotificationSendingService;
use Illuminate\Console\Command;
use Psr\SimpleCache\InvalidArgumentException;

class NotificationsGettingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vk:notification {vk_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send unread notification to user';

    public function handle(
        NotificationGettingService $notificationGettingService,
        LastNotificationDateCacheService $lastNotificationDateCacheService,
        NotificationSendingService $notificationSendingService
    ): void {
        /** @var VKUser $vkUser */
        $vkUser = VKUser::query()->find(1);
        $startTime = $this->getStartTime($lastNotificationDateCacheService, $vkUser);

        $notificationResponse = $notificationGettingService->get(
            $vkUser,
            $startTime,
        );

        foreach ($notificationResponse->getNotifications() as $notification) {
            $user = $vkUser->user;
            $profiles = $notificationResponse->getProfiles();
            $groups = $notificationResponse->getGroups();

            $notificationSendingService->send(
                $user,
                $notification,
                $profiles,
                $groups
            );
        }

        if (empty($notificationResponse->getNotifications())) {
            $this->output->info('No new notifications');
            return;
        }

        /** @var NotificationDTO $lastNotification */
        $lastNotification = current($notificationResponse->getNotifications());

        $timestamp = $lastNotification->getDate()->getTimestamp() + 1;
        $lastNotificationDateCacheService->save($vkUser, $timestamp);

        $notificationGettingService->markAsViewed($vkUser);

        $this->output->info('success');
    }

    /**
     * @param LastNotificationDateCacheService $lastNotificationDateCacheService
     * @param VKUser $VKUser
     * @return int
     * @throws InvalidArgumentException
     */
    private function getStartTime(LastNotificationDateCacheService $lastNotificationDateCacheService, VKUser $VKUser): int
    {
        $lastNotificationDate = $lastNotificationDateCacheService->get($VKUser);

        if ($lastNotificationDate === null) {
            $lastNotificationDate = time();
            $lastNotificationDateCacheService->save($VKUser, $lastNotificationDate);
        }

        return $lastNotificationDate;
    }
}
