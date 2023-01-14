<?php

namespace App\Services\VK\Notification\Formatter\Link;

use App\Services\Telegram\Formatter\HyperLinkFormatter;
use App\Services\VK\Notification\DTO\GroupDTO;

final class GroupLinkFormatter
{
    public const BASE_GROUP_URL = 'https://vk.com/public';

    public function __construct(private HyperLinkFormatter $hyperLinkFormatter)
    {
    }

    /**
     * @param GroupDTO $group
     * @return string
     */
    public function format(GroupDTO $group): string
    {
        $name = $group->getName();
        $url = $this->formatUrl($group);

        return $this->hyperLinkFormatter->format($url, $name);
    }

    /**
     * @param GroupDTO $group
     * @return string
     */
    public function formatUrl(GroupDTO $group): string
    {
        return self::BASE_GROUP_URL . $group->getId();
    }
}
