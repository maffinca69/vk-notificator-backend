<?php

namespace App\Services\VK\Notification;

use App\Infrastructure\VK\Client\Exception\VKAPIHttpClientException;
use App\Infrastructure\VK\Client\HttpClient;
use App\Infrastructure\VK\Client\Request\GetNotificationRequest;
use App\Models\VKUser;
use App\Services\VK\DTO\Notification\NotificationResponseDTO;
use App\Services\VK\Notification\Assembler\NotificationResponseDTOAssembler;

class NotificationGettingService
{
    public const DEFAULT_NOTIFICATION_COUNT = 100;

    public const LIKES_FILTER_TYPE = 'likes';
    public const FRIENDS_FILTER_TYPE = 'friends';
    public const FOLLOWERS_FILTER_TYPE = 'followers';
    public const WALL_FILTER_TYPE = 'wall';
    public const WALL_PUBLISH_FILTER_TYPE = 'wall_publish';
    public const MENTIONS_TYPE = 'mentions';

    public const AVAILABLE_FILTER_TYPES = [
        self::LIKES_FILTER_TYPE,
        self::FRIENDS_FILTER_TYPE,
        self::FOLLOWERS_FILTER_TYPE,
        self::WALL_FILTER_TYPE,
        self::WALL_PUBLISH_FILTER_TYPE,
        self::MENTIONS_TYPE,
    ];

    public function __construct(
        private NotificationResponseDTOAssembler $notificationResponseDTOAssembler,
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
}
