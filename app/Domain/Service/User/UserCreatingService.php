<?php

namespace App\Domain\Service\User;

use App\Models\User;
use App\Services\Telegram\DTO\FromDTO;
use Illuminate\Database\Eloquent\Model;

class UserCreatingService
{
    /**
     * @param FromDTO $from
     * @return Model
     */
    public function create(FromDTO $from): Model
    {
        $uuid = $from->getId();

        return User::query()->create(
            [
                'username' => $from->getUsername(),
                'last_name' => $from->getLastName(),
                'first_name' => $from->getFirstName(),
                'uuid' => $uuid,
            ]
        );
    }
}
