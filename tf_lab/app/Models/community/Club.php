<?php

namespace App\Models\community;

use App\Models\user\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Club extends Model
{
    use HasFactory;

    protected $table = 'clubs';

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

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}
