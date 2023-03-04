<?php

namespace App\Services\VK\Notification\Assembler;

use App\Services\VK\DTO\Notification\ProfileDTO;
use App\Services\VK\DTO\Notification\ProfileOnlineInfoDTO;

class ProfileDTOAssembler
{
    /**
     * @param array $params
     * @return ProfileDTO
     * @throws \Exception
     */
    public function create(array $params): ProfileDTO
    {
        $profile = new ProfileDTO($params['id']);

        if (isset($params['sex'])) {
            $profile->setSex($params['sex']);
        }

        if (isset($params['screen_name'])) {
            $profile->setScreenName($params['screen_name']);
        }

        if (isset($params['photo_50'])) {
            $profile->setPhoto50($params['photo_50']);
        }

        if (isset($params['photo_100'])) {
            $profile->setPhoto100($params['photo_100']);
        }

        if (isset($params['online'])) {
            $profile->setOnline($params['online']);
        }

        if (isset($params['first_name'])) {
            $profile->setFirstName($params['first_name']);
        }

        if (isset($params['last_name'])) {
            $profile->setLastName($params['last_name']);
        }

        if (isset($params['can_access_closed'])) {
            $profile->setCanAccessClosed($params['can_access_closed']);
        }

        if (isset($params['is_closed'])) {
            $profile->setIsClosed($params['is_closed']);
        }

        if (isset($params['online_info'])) {
            $onlineInfo = $this->createOnlineInfo($params['online_info']);
            $profile->setOnlineInfo($onlineInfo);
        }

        return $profile;
    }

    /**
     * @param array $params
     * @return ProfileOnlineInfoDTO
     * @throws \Exception
     */
    private function createOnlineInfo(array $params): ProfileOnlineInfoDTO
    {
        $visible = $params['visible'];
        $onlineInfo = new ProfileOnlineInfoDTO($visible);

        if (!$visible) {
            $onlineInfo->setStatus($params['status']);
            return $onlineInfo;
        }

        $onlineInfo->setIsOnline($params['is_online']);
        $onlineInfo->setIsMobile($params['is_mobile']);

        if (isset($params['last_seen'])) {
            $onlineInfo->setLastSeen(new \DateTime(date('Y-m-d H:i:s', $params['last_seen'])));
        }

        return $onlineInfo;
    }
}
