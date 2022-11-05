<?php

namespace App\Services\Setting;

use App\Models\User;
use Psr\SimpleCache\InvalidArgumentException;

class UserSettingsGettingService
{
    public function __construct(
        private SettingsCachingService $settingsCachingService,
        private UserSettingsUpdatingService $settingsUpdatingService
    ) {
    }

    /**
     * @param User $user
     * @return array
     * @throws Exception\InvalidSettingTypeException
     * @throws InvalidArgumentException
     */
    public function get(User $user): array
    {
        $cacheSettings = $this->settingsCachingService->get($user);
        if (!empty($cacheSettings)) {
            return $cacheSettings;
        }

        $settings = $user->getSettings() ?? [];
        if (empty($settings)) {
            $settings = SettingsDictionary::getFields();
            $this->settingsUpdatingService->update($user, $settings);
        }

        $this->settingsCachingService->set($user, $settings);
        return $settings;
    }

    /**
     * @param User $user
     * @param string $name
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getSetting(User $user, string $name): mixed
    {
        $settings = $this->get($user) ?? [];
        if (isset($settings[$name])) {
            return $settings[$name];
        }

        return null;
    }
}
