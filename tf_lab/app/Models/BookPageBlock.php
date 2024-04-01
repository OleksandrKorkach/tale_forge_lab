<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookPageBlock extends Model
{
    protected $table = 'books_pages_blocks';

    use HasFactory;

    protected $fillable = [
        'content',
        'block_type'
    ];

    public function bookPage(): BelongsTo
    {
        return $this->belongsTo(BookPage::class);
    }
}
