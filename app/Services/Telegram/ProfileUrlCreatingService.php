<?php

namespace App\Services\Telegram;

class ProfileUrlCreatingService
{
    private const BASE_URL = 'https://t.me/';

    /**
     * @param string $username
     * @return string
     */
    public function create(string $username): string
    {
        return self::BASE_URL . $username;
    }
}
