<?php

namespace App\Models\book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(PageBlock::class);
    }
}
