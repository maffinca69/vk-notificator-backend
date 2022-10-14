<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserGettingService
{
    /**
     * @param int $uuid
     * @return Model|null
     */
    public function getByUuid(int $uuid): ?Model
    {
        return User::query()->where(['uuid' => $uuid])->first();
    }
}
