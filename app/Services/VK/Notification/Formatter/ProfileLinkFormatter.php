<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\Telegram\Formatter\HyperLinkFormatter;
use App\Services\VK\Notification\DTO\ProfileDTO;

class ProfileLinkFormatter
{
    public const BASE_PROFILE_URL = 'https://vk.com/id';

    public function __construct(
        private HyperLinkFormatter $hyperLinkFormatter
    ) {
    }

    /**
     * @param ProfileDTO $profile
     * @return string
     */
    public function format(ProfileDTO $profile): string
    {
        $fullName = $this->formatFullName($profile);
        $url = $this->formatUrl($profile);

        return $this->hyperLinkFormatter->format($url, $fullName);
    }

    /**
     * @param ProfileDTO $profile
     * @return string
     */
    public function formatUrl(ProfileDTO $profile): string
    {
        return self::BASE_PROFILE_URL . $profile->getId();
    }

    /**
     * @param ProfileDTO $profile
     * @return string
     */
    public function formatFullName(ProfileDTO $profile): string
    {
        return sprintf('%s %s', $profile->getFirstName(), $profile->getLastName());
    }
}
