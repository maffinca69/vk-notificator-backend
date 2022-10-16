<?php

namespace App\Services\VK\Notification\Formatter;

use App\Services\VK\Notification\DTO\ProfileDTO;

class ProfileLinkFormatter
{
    public const BASE_PROFILE_URL = 'https://vk.com/id';

    /**
     * @param ProfileDTO $profile
     * @return string
     */
    public function format(ProfileDTO $profile): string
    {
        $fullName = $this->formatFullName($profile);
        $url = self::BASE_PROFILE_URL . $profile->getId();

        return sprintf('[%s](%s)', $fullName, $url);
    }

    /**
     * @param ProfileDTO $profile
     * @return string
     */
    private function formatFullName(ProfileDTO $profile): string
    {
        return sprintf('%s %s', $profile->getFirstName(), $profile->getLastName());
    }
}
