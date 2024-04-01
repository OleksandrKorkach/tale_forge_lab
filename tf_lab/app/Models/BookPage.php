<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookPage extends Model
{
    use HasFactory;

    protected $table = 'books_pages';

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(BookPageBlock::class);
    }
}
