<?php

namespace App\Services\Pluralization;

class PluralizingService
{
    /**
     * @param int $value
     * @param array $variants
     * @param bool $includeValue
     * @return string
     */
    public function plural(int $value, array $variants, bool $includeValue = false): string
    {
        $num = $value % 100;
        if ($num > 19) {
            $num = $num % 10;
        }

        $result = match ($num) {
            1 => $variants[0],
            2, 3, 4 => $variants[1],
            default => $variants[2],
        };

        return $includeValue ? sprintf('%s %s', $value, $result) : $result;
    }
}
