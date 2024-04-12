<?php

namespace App\Models;

use App\Models\book\Book;
use App\Models\book\BookCommentLike;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(BookCommentLike::class);
    }
}
