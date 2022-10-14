<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
