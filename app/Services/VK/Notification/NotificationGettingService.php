<?php

namespace App\Services\VK\Notification;

use App\Infrastructure\VK\Client\Exception\VKAPIHttpClientException;
use App\Infrastructure\VK\Client\HttpClient;
use App\Infrastructure\VK\Client\Request\GetNotificationRequest;
use App\Models\VKUser;
use App\Services\VK\DTO\Notification\NotificationResponseDTO;
use App\Services\VK\Notification\Assembler\NotificationResponseDTOAssembler;
use VK\Client\VKApiClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class NotificationGettingService
{
    public const DEFAULT_NOTIFICATION_COUNT = 100;

    public const LIKES_FILTER_TYPES = 'likes';
    public const FRIENDS_FILTER_TYPES = 'friends';
    public const FOLLOWERS_FILTER_TYPES = 'followers';
    public const WALL_FILTER_TYPES = 'wall';

    public const AVAILABLE_FILTER_TYPES = [
        self::LIKES_FILTER_TYPES,
        self::FRIENDS_FILTER_TYPES,
        self::FOLLOWERS_FILTER_TYPES,
        self::WALL_FILTER_TYPES,
    ];

    public function __construct(
        private NotificationResponseDTOAssembler $notificationResponseDTOAssembler,
        private VKApiClient $apiClient,
        private HttpClient $client
    ) {
    }

    /**
     * @param VKUser $VKUser
     * @param int|null $startTime
     * @param int|null $endTime
     * @param int $count
     * @return NotificationResponseDTO
     * @throws VKAPIHttpClientException
     */
    public function get(
        VKUser $VKUser,
        ?int $startTime = null,
        ?int $endTime = null,
        int $count = self::DEFAULT_NOTIFICATION_COUNT,
    ): NotificationResponseDTO {
        $accessToken = $VKUser->getAccessToken();

        $params = [
            'count' => $count,
            'filters' => implode(',', self::AVAILABLE_FILTER_TYPES)
        ];

        if (isset($startTime)) {
            $params['start_time'] = $startTime;
        }

        if (isset($endTime)) {
            $params['end_time'] = $endTime;
        }

        $request = new GetNotificationRequest($params, $accessToken);

        $notifications = $this->client->sendRequest($request);

        return $this->notificationResponseDTOAssembler->create($notifications);
    }

    /**
     * @param VKUser $VKUser
     * @throws VKApiException
     * @throws VKClientException
     */
    public function markAsViewed(VKUser $VKUser): void
    {
        $accessToken = $VKUser->getAccessToken();
        $this->apiClient->notifications()->markAsViewed($accessToken);
    }
}
