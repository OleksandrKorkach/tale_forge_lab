<?php

use App\Http\Controllers\BookCommentController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookEditorController;
use App\Http\Controllers\BookListController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('auth');
Route::get('/users/{user}/readlist', [UserController::class, 'showReadList'])->name('users.readlist.show');
Route::get('/users/{user}/favorite', [UserController::class, 'showFavoriteList'])->name('users.readlist.show');
Route::get('/users/{user}/topics', [UserController::class, 'userTopics']);
Route::get('/users/{user}/reviews', [UserController::class, 'userReviews']);

Route::prefix('books')->group(function () {
    Route::get('', [BookController::class, 'index'])->name('books.index');
    Route::get('{book}', [BookController::class, 'show'])->name('books.show');
});
Route::post('books/{book}/comments', [BookCommentController::class, 'store'])->name('books.comment.store');

Route::delete('comments/{commentId}/delete', [BookCommentController::class, 'delete'])->name('books.comment.delete');
Route::post('comments/{commentId}/likes', [BookCommentController::class, 'toggleLike'])->name('comments.store');

Route::post('favorite-books/toggle', [BookListController::class, 'toggleFavorite'])->name('favorite-books.toggle');
Route::post('booklist/toggle', [BookListController::class, 'toggleReadList'])->name('booklist.toggle');

Route::get('lists/{listId}', [BookListController::class, 'show'])->name('lists.show');
Route::delete('lists/{listId}/remove-book/{bookId}', [BookListController::class, 'toggleBook'])->name('lists.books.remove');
Route::get('lists/export/{listId}', [BookListController::class, 'export']);

Route::get('/lab', [LabController::class, 'index'])->name('lab.index');
Route::get('/lab/create', [LabController::class, 'create'])->name('lab.create');
Route::post('/lab/store-book', [LabController::class, 'storeBook'])->name('lab.book.store');
Route::post('/lab/update-book/{book}', [LabController::class, 'updateBook'])->name('lab.book.update');
Route::delete('/lab/delete-book/{bookId}', [LabController::class, 'deleteBook'])->name('lab.book.delete');
Route::post('/lab/publish-book/{book}', [LabController::class, 'publishBook'])->name('lab.book.publish');
Route::get('/lab/edit/{book}', [LabController::class, 'editBook'])->name('lab.book.edit');
Route::get('/editor/{bookId}', [BookEditorController::class, 'show']);
Route::post('/editor/{bookId}/save', [BookEditorController::class, 'save']);
Route::get('/view-pdf', [BookEditorController::class, 'viewPdf']);


Route::post('ratings/{book}', [BookController::class, 'setBookRating'])->name('books.set-rating');
Route::delete('ratings/{bookId}', [BookController::class, 'deleteBookRating'])->name('books.delete-rating');

Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
Route::get('/community/clubs', [CommunityController::class, 'clubs'])->name('community.clubs.index');
Route::get('/community/clubs/{clubId}', [CommunityController::class, 'showClub'])->name('community.clubs.show');
Route::get('/community/topics', [CommunityController::class, 'topics'])->name('community.topics.index');
Route::get('/community/topics/{topicId}', [CommunityController::class, 'showTopic'])->name('community.topics.show');
Route::post('/community/topics/{topicId}', [CommunityController::class, 'storeComment'])->name('community.topics.comments.store');
Route::delete('/topics/comments/{commentId}', [CommunityController::class, 'deleteComment'])->name('topics.comments.delete');
Route::post('/test/topic/create', [CommunityController::class, 'testTopic']);
Route::delete('/community/topics/{topicId}', [CommunityController::class, 'deleteTopic'])->name('community.topics.delete');

Route::post('/upload-cropped-image', [CommunityController::class, 'uploadImage'])->name('upload.image');

require __DIR__.'/auth.php';
