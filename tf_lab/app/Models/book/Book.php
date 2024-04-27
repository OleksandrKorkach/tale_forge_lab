<?php

namespace App\Models\book;

use App\Models\book\enums\BookLanguages;
use App\Models\page\Page;
use App\Models\user\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'description',
        'author_name',
        'season',
        'year',
        'language',
        'quote',
        'pages',
        'age_rating',
        'url',
        'user_id',
        'ai_generated',
    ];

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(BookRating::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(BookComment::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(BookGenre::class, 'book_genre', 'book_id', 'genre_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BookTag::class, 'book_tag', 'book_id', 'tag_id');
    }

}
