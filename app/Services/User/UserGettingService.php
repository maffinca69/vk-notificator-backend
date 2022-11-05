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
        return User::query()->where(['uuid' => $uuid])->firstOrFail();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getById(int $id): Model
    {
        return User::query()->where(['id' => $id])->firstOrFail();
    }
}
