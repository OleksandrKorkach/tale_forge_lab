<?php

namespace App\Providers;

use App\Models\book\BookCommentLike;
use App\Observers\BookCommentLikeObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        BookCommentLike::observe(BookCommentLikeObserver::class);
    }
}
