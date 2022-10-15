<?php

namespace App\Services\VK\Notification;

use App\Models\VKUser;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class LastNotificationDateCacheService
{
    public const LAST_NOTIFICATION_DATE_CACHE_KEY = 'LAST:NOTIFICATION:DATE:';

    public function __construct(private CacheInterface $cache)
    {
    }

    /**
     * @param VKUser $VKUser
     * @param int $timestamp
     * @return bool
     * @throws InvalidArgumentException
     */
    public function save(VKUser $VKUser, int $timestamp): bool
    {
        $key = self::LAST_NOTIFICATION_DATE_CACHE_KEY . $VKUser->vk_id;

        return $this->cache->set($key, $timestamp);
    }

    /**
     * @param VKUser $VKUser
     * @return int|null
     * @throws InvalidArgumentException
     */
    public function get(VKUser $VKUser): ?int
    {
        $key = self::LAST_NOTIFICATION_DATE_CACHE_KEY . $VKUser->vk_id;
        return $this->cache->get($key);
    }
}
