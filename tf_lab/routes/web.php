<?php

use App\Http\Controllers\BookCommentController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FavoriteBookController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Services\BookCommentService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Main', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('main')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('books')->group(function () {
    Route::get('', [BookController::class, 'index'])->name('books.index');
    Route::get('{book}', [BookController::class, 'show'])->name('books.show');
});

Route::post('books/{book}/comments', [BookCommentController::class, 'store'])->name('books.comment.store');
Route::delete('comments/{commentId}/delete', [BookCommentController::class, 'deleteComment'])->name('books.comment.delete');

Route::post('comments/{commentId}/likes', [BookCommentController::class, 'toggleLike'])->name('comments.store');

Route::get('books/{book}/pages/{page}', [PageController::class, 'show'])->name('pages.show');
Route::delete('/blocks/{block}', [PageController::class, 'destroyBlock'])->name('pages.blocks.destroy');
Route::post('books/{book}/page/{page}', [PageController::class, 'storeBlock'])->name('pages.blocks.store');

Route::post('favorite-books/toggle', [FavoriteBookController::class, 'toggleFavorite'])->name('favorite-books.toggle');
Route::post('booklist/toggle', [FavoriteBookController::class, 'toggleBooklist'])->name('booklist.toggle');

Route::get('/lab', [LabController::class, 'index'])->name('lab.index');

Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');

require __DIR__.'/auth.php';
