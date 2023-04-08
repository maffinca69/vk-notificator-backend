<?php

namespace App\Services\VK\Notification;

use App\Services\VK\DTO\Notification\ProfileDTO;

class NotificationProfileGettingService
{
    /**
     * @param int $id
     * @param array $profiles
     * @return ProfileDTO|null
     */
    public function getProfile(int $id, array $profiles): ?ProfileDTO
    {
        /** @var ProfileDTO $profile */
        foreach ($profiles as $profile) {
            if ($profile->getId() === $id) {
                return $profile;
            }
        }

        return null;
    }
}
