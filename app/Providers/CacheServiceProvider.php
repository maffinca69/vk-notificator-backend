<?php

namespace App\Providers;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Support\ServiceProvider;
use Psr\SimpleCache\CacheInterface;
use \Illuminate\Cache\CacheServiceProvider as IlluminateCacheServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->register(IlluminateCacheServiceProvider::class);
        $this->app->register(RedisServiceProvider::class);

        $this->app->bind(CacheInterface::class, Repository::class);
    }
}
