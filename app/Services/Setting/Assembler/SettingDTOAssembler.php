<?php

namespace App\Services\Setting\Assembler;

use App\Services\Setting\DTO\SettingDTO;

class SettingDTOAssembler
{
    /**
     * @param array $settings
     * @return SettingDTO
     */
    public function create(array $settings): SettingDTO
    {
        $setting = new SettingDTO();

        if (array_key_exists('is_mark_as_read', $settings)) {
            $setting->setIsMarkAsRead($settings['is_mark_as_read']);
        }

        if (array_key_exists('is_send_viewed_notifications', $settings)) {
            $setting->setIsSendViewedNotifications($settings['is_send_viewed_notifications']);
        }

        return $setting;
    }
}
