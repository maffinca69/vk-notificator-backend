<?php

namespace App\Services\Telegram;

class UrlGenerator
{
    private const BASE_URL = 'https://t.me/';

    /**
     * @param string $username
     * @return string
     */
    public function generate(string $username): string
    {
        return self::BASE_URL . $username;
    }
}
