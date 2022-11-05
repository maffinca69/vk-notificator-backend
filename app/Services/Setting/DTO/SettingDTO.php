<?php

namespace App\Services\Setting\DTO;

use App\Services\Setting\SettingsDictionary;

class SettingDTO
{
    private bool $isMarkAsRead = SettingsDictionary::IS_MARK_AS_READ;
    private int $formatNameType = SettingsDictionary::FORMAT_NAME_TYPE;

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
     * @return int
     */
    public function getFormatNameType(): int
    {
        return $this->formatNameType;
    }

    /**
     * @param int $formatNameType
     */
    public function setFormatNameType(int $formatNameType): void
    {
        $this->formatNameType = $formatNameType;
    }
}
