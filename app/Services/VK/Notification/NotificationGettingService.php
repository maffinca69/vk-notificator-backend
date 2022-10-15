<?php

namespace App\Services\VK\Notification;

use App\Models\VKUser;
use App\Services\VK\Notification\Assembler\NotificationResponseDTOAssembler;
use App\Services\VK\Notification\DTO\NotificationResponseDTO;
use VK\Client\VKApiClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class NotificationGettingService
{
    public const DEFAULT_NOTIFICATION_COUNT = 25;

    public function __construct(private NotificationResponseDTOAssembler $notificationResponseDTOAssembler)
    {
    }

    /**
     * @param VKUser $VKUser
     * @param int|null $startTime
     * @param int|null $endTime
     * @param int $count
     * @return NotificationResponseDTO
     * @throws VKApiException
     * @throws VKClientException
     */
    public function get(
        VKUser $VKUser,
        ?int $startTime = null,
        ?int $endTime = null,
        int $count = self::DEFAULT_NOTIFICATION_COUNT,
    ): NotificationResponseDTO {
        $accessToken = $VKUser->access_token;
        $vk = new VKApiClient();

        $params = [
            'count' => $count
        ];

        if (isset($startTime)) {
            $params['start_time'] = $startTime;
        }

        if (isset($endTime)) {
            $params['end_time'] = $endTime;
        }

        $notifications = $vk->notifications()->get($accessToken, $params);

        return $this->notificationResponseDTOAssembler->create($notifications);
    }

    /**
     * @param VKUser $VKUser
     * @throws VKApiException
     * @throws VKClientException
     */
    public function markAsViewed(VKUser $VKUser): void
    {
        $accessToken = $VKUser->access_token;
        $vk = new VKApiClient();
        $vk->notifications()->markAsViewed($accessToken);
    }
}
