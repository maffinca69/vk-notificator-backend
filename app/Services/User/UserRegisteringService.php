<?php

namespace App\Services\User;

use App\Core\DTO\FromDTO;
use Illuminate\Database\Eloquent\Model;

class UserRegisteringService
{
    public function __construct(
        protected UserGettingService $userGettingService,
        protected UserCreatingService $userCreatingService,
    ) {
    }

    /**
     * @param FromDTO $from
     * @return Model
     */
    public function register(FromDTO $from): Model
    {
        $user = $this->userGettingService->getByUuid($from->getId());
        if ($user === null) {
            $user = $this->userCreatingService->create($from);
        }

        return $user;
    }
}
