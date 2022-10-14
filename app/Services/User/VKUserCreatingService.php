<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\VKUser;
use App\Services\VK\OAuth\DTO\VKOAuthDTO;
use Illuminate\Database\Eloquent\Model;

class VKUserCreatingService
{
    /**
     * @param VKOAuthDTO $oauthDTO
     * @return Model
     */
    public function create(VKOAuthDTO $oauthDTO): Model
    {
        $state = $oauthDTO->getState();
        $vkId = $oauthDTO->getUserId();

        $user = User::query()->where(['uuid' => $state])->first();

        return VKUser::query()->firstOrCreate(
            ['vk_id' => $vkId],
            [
                'access_token' => $oauthDTO->getAccessToken(),
                'email' => $oauthDTO->getUserId(),
                'vk_id' => $vkId,
                'user_id' => $user->id,
            ]
        );
    }
}
