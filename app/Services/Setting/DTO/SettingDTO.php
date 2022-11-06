<?php

namespace App\Services\Setting\DTO;

use App\Services\Setting\SettingsDictionary;

class SettingDTO
{
    private bool $isMarkAsRead = SettingsDictionary::IS_MARK_AS_READ;
    private bool $isSendViewedNotifications = SettingsDictionary::IS_SEND_VIEWED_NOTIFICATIONS;

    /**
     * @return bool
     */
    public function isMarkAsRead(): bool
    {
        return $this->isMarkAsRead;
    }

    /**
     * @param bool $isMarkAsRead
     */
    public function setIsMarkAsRead(bool $isMarkAsRead): void
    {
        $this->isMarkAsRead = $isMarkAsRead;
    }

    /**
     * @return bool
     */
    public function isSendViewedNotifications(): bool
    {
        return $this->isSendViewedNotifications;
    }

    /**
     * @param bool $isSendViewedNotifications
     */
    public function setIsSendViewedNotifications(bool $isSendViewedNotifications): void
    {
        $this->isSendViewedNotifications = $isSendViewedNotifications;
    }
}
