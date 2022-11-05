<?php

namespace App\Services\Internal;

final class DiffArray
{
    /**
     * @param array $source
     * @param array $target
     * @return array
     */
    public static function diffWithoutNewKeys(array $source, array $target): array
    {
        $diff = array_diff_assoc($target, $source);

        foreach ($diff as $key => $value) {
            if (array_key_exists($key, $source)) {
                $source[$key] = $value;
            }
        }

        return $source;
    }
}
