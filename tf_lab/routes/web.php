<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LabController;
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

Route::get('books', [BookController::class, 'index'])->name('books.index');
Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('books/{book}/page/{page}', [BookController::class, 'showPage'])->name('books.show.page');

Route::post('books/{book}/comments', [BookCommentService::class, 'storeComment'])->name('books.comment.store');

Route::post('books/{book}/page/{page}', [BookController::class, 'addBlockToPage'])->name('books.add.block');
Route::delete('/blocks/{block}', [BookController::class, 'destroyPageBlock'])->name('book.page.destroy');

Route::get('/lab', [LabController::class, 'index'])->name('lab.index');

Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');

require __DIR__.'/auth.php';
