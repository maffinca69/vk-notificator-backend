<?php

namespace App\Services\Setting;

use ReflectionClassConstant;

final class SettingsDictionary
{
    public const IS_MARK_AS_READ = false;
    public const FORMAT_NAME_TYPE = 1;
    public const SHOW_PHOTO = false;

    /**
     * @return array
     */
    public static function getFields(): array
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $constants = $reflection->getConstants(ReflectionClassConstant::IS_PUBLIC);

        $result = [];
        foreach ($constants as $key => $value) {
            $result[mb_strtolower($key)] = $value;
        }

        return $result;
    }
}
