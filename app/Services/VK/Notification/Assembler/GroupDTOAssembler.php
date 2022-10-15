<?php

namespace App\Services\VK\Notification\Assembler;

use App\Services\VK\Notification\DTO\GroupDTO;

class GroupDTOAssembler
{
    /**
     * @param array $params
     * @return GroupDTO
     */
    public function create(array $params): GroupDTO
    {
        $group = new GroupDTO($params['id']);

        if (isset($params['name'])) {
            $group->setName($params['name']);
        }

        if (isset($params['screen_name'])) {
            $group->setScreenName($params['screen_name']);
        }

        if (isset($params['is_closed'])) {
            $group->setIsClosed($params['is_closed']);
        }

        if (isset($params['type'])) {
            $group->setType($params['type']);
        }

        if (isset($params['is_admin'])) {
            $group->setIsAdmin($params['is_admin']);
        }

        if (isset($params['is_member'])) {
            $group->setIsMember($params['is_member']);
        }

        if (isset($params['is_advertiser'])) {
            $group->setIsAdvertiser($params['is_advertiser']);
        }

        if (isset($params['photo_50'])) {
            $group->setPhoto50($params['photo_50']);
        }

        if (isset($params['photo_100'])) {
            $group->setPhoto100($params['photo_100']);
        }

        if (isset($params['photo_200'])) {
            $group->setPhoto200($params['photo_200']);
        }

        return $group;
    }
}
