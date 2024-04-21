<?php

namespace App\Models;

use App\Models\user\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityClub extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'members',

    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
