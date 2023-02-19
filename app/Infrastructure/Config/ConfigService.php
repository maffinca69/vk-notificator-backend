<?php

namespace App\Infrastructure\Config;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Laravel\Lumen\Application;

class ConfigService
{
    private static array $cache = [];

    /**
     * @param Application $app
     * @param ConfigRepository $configRepository
     */
    public function __construct(
        private Application $app,
        private ConfigRepository $configRepository
    ) {
    }

    /**
     * @param string $configName
     * @return array
     */
    public function get(string $configName): array
    {
        if (isset(self::$cache[$configName])) {
            return self::$cache[$configName];
        }

        $this->app->configure($configName);
        $config = $this->configRepository->get($configName, []);

        self::$cache[$configName] = $config;

        return $config;
    }
}
