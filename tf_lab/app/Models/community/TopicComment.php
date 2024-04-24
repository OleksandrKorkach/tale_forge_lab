<?php

namespace App\Models\community;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TopicComment extends Model
{
    protected $table = 'topic_comments';

    use HasFactory;

    protected $fillable = [
        'content',
        'author_name',
        'user_id',
        'topic_id',
        'comment_id',
    ];

    public function replies(): HasMany
    {
        return $this->hasMany(TopicComment::class, 'comment_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(TopicComment::class, 'comment_id');
    }
}
