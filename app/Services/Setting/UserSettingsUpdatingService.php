<?php

namespace App\Services\Setting;

use App\Models\User;
use App\Services\Internal\DiffArray;
use App\Services\Setting\Exception\InvalidSettingTypeException;
use Psr\SimpleCache\InvalidArgumentException;

class UserSettingsUpdatingService
{
    public function __construct(private SettingsCachingService $settingsCachingService)
    {
    }

    /**
     * @param User $user
     * @param array $settings
     * @return bool
     * @throws InvalidArgumentException
     * @throws InvalidSettingTypeException
     */
    public function update(User $user, array $settings): bool
    {
        $defaultSettings = SettingsDictionary::getFields();
        $settings = DiffArray::diffWithoutNewKeys($defaultSettings, $settings);

        $this->validateSettings($defaultSettings, $settings);

        $this->settingsCachingService->set($user, $settings);

        return $user->update(['settings' => $settings]);
    }

    /**
     * @param array $defaultSettings
     * @param array $settings
     * @throws InvalidSettingTypeException
     */
    private function validateSettings(array $defaultSettings, array $settings): void
    {
        foreach ($defaultSettings as $key => $defaultValue) {
            foreach ($settings as $keySetting => $settingValue) {
                if ($keySetting !== $key) {
                    continue;
                }

                if (gettype($settingValue) === gettype($defaultValue)) {
                    continue;
                }

                throw new InvalidSettingTypeException("Invalid type for [{$keySetting}] setting", [
                    'setting' => $keySetting
                ]);
            }
        }
    }
}
