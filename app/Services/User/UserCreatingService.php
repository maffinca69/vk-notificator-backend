<?php

namespace App\Services\User;

use App\Core\DTO\UpdateDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserCreatingService
{
    /**
     * @param UpdateDTO $updateDTO
     * @return Model
     */
    public function create(UpdateDTO $updateDTO): Model
    {
        $message = $updateDTO->getMessage() ?? $updateDTO->getCallbackQuery();
        $from = $message->getFrom();
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
