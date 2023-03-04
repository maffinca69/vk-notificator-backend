<?php

namespace App\Domain\Service\VKUser;

use App\Domain\Service\User\UserGettingService;
use App\Models\VKUser;
use App\Services\VK\OAuth\DTO\VKOAuthDTO;
use Illuminate\Database\Eloquent\Model;

class VKUserCreatingService
{
    public function __construct(private UserGettingService $userGettingService)
    {
    }

    /**
     * @param VKOAuthDTO $oauthDTO
     * @return Model
     */
    public function create(VKOAuthDTO $oauthDTO): Model
    {
        $state = $oauthDTO->getState();
        $vkId = $oauthDTO->getUserId();

        $user = $this->userGettingService->getByUuid($state);

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
