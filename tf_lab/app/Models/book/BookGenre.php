<?php

namespace App\Models\book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookGenre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'text_color',
        'background_color',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_genre', 'genre_id', 'book_id');
    }
}
