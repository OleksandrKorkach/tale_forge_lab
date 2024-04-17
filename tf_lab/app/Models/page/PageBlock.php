<?php

namespace App\Models\page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageBlock extends Model
{
    protected $table = 'page_blocks';

    use HasFactory;

    protected $fillable = [
        'content',
        'block_type',
        'page_id'
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
