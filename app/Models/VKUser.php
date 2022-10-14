<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class VKUser extends Model
{
    protected $table = 'vk_user';

    protected $fillable = [
        'access_token',
        'user_id',
        'email',
        'vk_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setAccessTokenAttribute(string $token)
    {
        $this->attributes['access_token'] = Crypt::encrypt($token);
    }

    public function getAccessTokenAttribute(string $token): string
    {
        return Crypt::decrypt($token);
    }
}
