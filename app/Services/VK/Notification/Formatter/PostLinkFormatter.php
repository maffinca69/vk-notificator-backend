<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\Telegram\Formatter\HyperLinkFormatter;

class PostLinkFormatter
{
    public const BASE_POST_URL = 'https://vk.com/wall';

    public function __construct(private HyperLinkFormatter $hyperLinkFormatter)
    {
    }

    /**
     * @param int $groupId
     * @param int $postId
     * @param string $name
     * @return string
     */
    public function format(int $groupId, int $postId, string $name): string
    {
        $url = sprintf('%s%s_%s', self::BASE_POST_URL, $groupId, $postId);

        return $this->hyperLinkFormatter->format($url, $name);
    }
}
