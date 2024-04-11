<?php

namespace App\Models\book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'username',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
