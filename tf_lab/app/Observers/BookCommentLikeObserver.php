<?php

namespace App\Observers;

use App\Models\book\BookCommentLike;

class BookCommentLikeObserver
{
    public function created(BookCommentLike $like): void
    {
        if ($like->type === 'like') {
            $like->comment->increment('number_of_likes');
        } else {
            $like->comment->increment('number_of_dislikes');
        }
    }

    public function updated(BookCommentLike $like): void
    {
        if ($like->isDirty('type')) {
            if ($like->getOriginal('type') === 'like') {
                $like->comment->decrement('number_of_likes');
                $like->comment->increment('number_of_dislikes');
            } else {
                $like->comment->decrement('number_of_dislikes');
                $like->comment->increment('number_of_likes');
            }
        }
    }

    public function deleted(BookCommentLike $like): void
    {
        if ($like->type === 'like') {
            $like->comment->decrement('number_of_likes');
        } else {
            $like->comment->decrement('number_of_dislikes');
        }
    }

    public function restored(BookCommentLike $bookCommentLike): void
    {
        //
    }

    public function forceDeleted(BookCommentLike $bookCommentLike): void
    {
        //
    }
}
