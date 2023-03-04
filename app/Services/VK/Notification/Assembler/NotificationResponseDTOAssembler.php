<?php

namespace App\Services\VK\Notification\Assembler;

use App\Services\VK\DTO\Notification\NotificationResponseDTO;

class NotificationResponseDTOAssembler
{
    /**
     * @param NotificationDTOAssembler $notificationDTOAssembler
     * @param GroupDTOAssembler $groupDTOAssembler
     * @param ProfileDTOAssembler $profileDTOAssembler
     */
    public function __construct(
        private NotificationDTOAssembler $notificationDTOAssembler,
        private GroupDTOAssembler $groupDTOAssembler,
        private ProfileDTOAssembler $profileDTOAssembler,
    ) {
    }

    /**
     * @param array $params
     * @return NotificationResponseDTO
     * @throws \Exception
     */
    public function create(array $params): NotificationResponseDTO
    {
        $notifications = [];
        $profiles = [];
        $groups = [];

        foreach ($params['items'] as $notification) {
            $notifications[] = $this->notificationDTOAssembler->create($notification);
        }

        foreach ($params['groups'] as $group) {
            $groups[] = $this->groupDTOAssembler->create($group);
        }

        foreach ($params['profiles'] as $profile) {
            $profiles[] = $this->profileDTOAssembler->create($profile);
        }

        $notification = new NotificationResponseDTO(
            $notifications,
            $profiles,
            $groups
        );

        if (isset($params['last_viewed'])) {
            $notification->setLastViewed(new \DateTime(date('Y-m-d H:i:s', $params['last_viewed'])));
        }

        if (isset($params['next_from'])) {
            $notification->setNextFrom($params['next_from']);
        }

        if (isset($params['ttl'])) {
            $notification->setTtl($params['ttl']);
        }

        return $notification;
    }
}
