<?php

namespace App\Services\VK\OAuth\Assembler;

use App\Services\VK\OAuth\DTO\VKOAuthDTO;

class VKOauthDTOAssembler
{
    /**
     * @param array $params
     * @return VKOAuthDTO
     */
    public function create(array $params): VKOAuthDTO
    {
        $oauthDTO = new VKOAuthDTO(
            $params['access_token'],
            $params['user_id']
        );

        if (isset($params['email'])) {
            $oauthDTO->setEmail($params['email']);
        }

        if (isset($params['state'])) {
            $oauthDTO->setState($params['state']);
        }

        return $oauthDTO;
    }
}
