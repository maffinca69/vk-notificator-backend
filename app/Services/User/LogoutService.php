<?php

namespace App\Services\User;

use App\Models\User;

class LogoutService
{
    public const SUCCESSFUL_LOGOUT = 'Вы успешно отвязали свой аккаунт. Рассылка уведомлений остановлена';
    public const UNAVAILABLE_LOGOUT = 'Аккаунт не привязан!';
    public const FAILURE_LOGOUT = 'Что-то пошло не так :(';

    /**
     * @param User $user
     * @return bool
     */
    public function logout(User $user): bool
    {
        return $user->delete();
    }
}
