<?php

namespace App\Services\VK\Notification;

use App\Services\VK\Notification\DTO\GroupDTO;

class NotificationGroupGettingService
{
    /**
     * @param int $id
     * @param array $groups
     * @return GroupDTO|null
     */
    public function getGroup(int $id, array $groups): ?GroupDTO
    {
        foreach ($groups as $group) {
            if ($group->getId() === abs($id)) {
                return $group;
            }
        }

        return null;
    }
}
