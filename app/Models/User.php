<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model
{
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'username',
        'last_name',
        'first_name',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function vkUser(): HasOne
    {
        return $this->hasOne(VKUser::class, 'user_id', 'id');
    }

    /**
     * @return VKUser|null
     */
    public function getVKUser(): ?VKUser
    {
        return $this->vkUser;
    }

    /**
     * @return int
     */
    public function getUuid(): int
    {
        return $this->uuid;
    }

    /**
     * @return array|null
     */
    public function getSettings(): ?array
    {
        return $this->settings;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }
}
