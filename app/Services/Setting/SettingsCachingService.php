<?php

namespace App\Services\Setting;

use App\Models\User;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class SettingsCachingService
{
    private const SETTINGS_CACHE_KEY = 'USER:SETTINGS:';

    public function __construct(private CacheInterface $cache)
    {
    }

    /**
     * @param User $user
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get(User $user): array
    {
        $key = $this->getCacheKey($user);
        return $this->cache->get($key) ?? [];
    }

    /**
     * @param User $user
     * @param array $settings
     * @return bool
     * @throws InvalidArgumentException
     */
    public function set(User $user, array $settings): bool
    {
        $key = $this->getCacheKey($user);

        return $this->cache->set($key, $settings);
    }

    /**
     * @param User $user
     * @return string
     */
    private function getCacheKey(User $user): string
    {
        return self::SETTINGS_CACHE_KEY . $user->getUuid();
    }
}
