<?php

namespace App\Services\VK\Notification\Keyboard;

final class UrlButtonBuildingService
{
    /**
     * @param string $name
     * @param string $url
     * @return array
     */
    public function build(string $name, string $url): array
    {
        return [
            [
                'text' => $name,
                'url' => $url,
            ]
        ];
    }
}
