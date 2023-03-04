<?php

namespace App\Services\Telegram;

class ProfileUrlGettingService
{
    private const BASE_URL = 'https://t.me/';

    /**
     * @param string $username
     * @return string
     */
    public function get(string $username): string
    {
        return self::BASE_URL . $username;
    }
}
