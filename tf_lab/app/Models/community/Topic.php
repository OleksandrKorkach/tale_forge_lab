<?php

namespace App\Models\community;

use App\Models\user\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    protected $table = 'topics';

    protected $fillable = [
        'title',
        'description',
        'username',
        'user_id',
        'club_id',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TopicComment::class);
    }

}
