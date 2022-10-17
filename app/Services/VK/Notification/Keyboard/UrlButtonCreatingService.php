<?php

namespace App\Services\VK\Notification\Keyboard;

final class UrlButtonCreatingService
{
    /**
     * @param string $name
     * @param string $url
     * @return array
     */
    public function create(string $name, string $url): array
    {
        return [
            [
                'text' => $name,
                'url' => $url,
            ]
        ];
    }
}
