<?php

namespace App\Services\User;

use App\Core\DTO\FromDTO;
use App\Core\DTO\UpdateDTO;
use App\Models\User;
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

        return User::query()->firstOrCreate(
            ['uuid' => $uuid],
            [
                'username' => $from->getUsername(),
                'last_name' => $from->getLastName(),
                'first_name' => $from->getFirstName(),
                'uuid' => $uuid,
            ],
        );
    }
}
