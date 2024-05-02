<?php

namespace App\Models\user;

use App\Models\book\Book;
use App\Models\book\BookComment;
use App\Models\book\BookCommentLike;
use App\Models\book\BookList;
use App\Models\book\BookRating;
use App\Models\community\Club;
use App\Models\community\Topic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

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

    public function ratings(): HasMany
    {
        return $this->hasMany(BookRating::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(BookCommentLike::class);
    }

    public function bookLists(): HasMany
    {
        return $this->hasMany(BookList::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(BookComment::class);
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function createdClubs(): HasMany
    {
        return $this->hasMany(Club::class);
    }

    public function clubs(): BelongsToMany
    {
        return $this->belongsToMany(Club::class, 'club_user', 'user_id', 'club_id');
    }


}
