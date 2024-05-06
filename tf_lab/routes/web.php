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

Route::prefix('/users')->group(function () {
    Route::get('{user}', [UserController::class, 'show'])->name('users.show')->middleware('auth');
    Route::get('{user}/readlist', [UserController::class, 'showReadList'])->name('users.readlist.show');
    Route::get('{user}/favorite', [UserController::class, 'showFavoriteList'])->name('users.readlist.show');
    Route::get('{user}/topics', [UserController::class, 'userTopics']);
    Route::get('{user}/reviews', [UserController::class, 'userReviews']);
    Route::get('{user}/lists', [UserController::class, 'userBookLists']);
    Route::post('{user}/lists', [UserController::class, 'createList']);
    Route::post('{userId}/avatar', [UserController::class, 'updateAvatar']);
});

Route::prefix('books')->group(function () {
    Route::get('', [BookController::class, 'index'])->name('books.index');
    Route::get('{book}', [BookController::class, 'show'])->name('books.show');
    Route::post('{book}/comments', [BookCommentController::class, 'store'])->name('books.comment.store');
});

Route::prefix('/lists')->group(function () {
    Route::get('{listId}', [BookListController::class, 'show'])->name('lists.show');
    Route::post('{listId}/books/{bookId}', [BookListController::class, 'addToList']);
    Route::put('{listId}', [BookListController::class, 'update'])->name('lists.update');
    Route::delete('{listId}/remove-book/{bookId}', [BookListController::class, 'toggleBook'])->name('lists.books.remove');
    Route::get('export/{listId}', [BookListController::class, 'export']);
    Route::delete('{listId}', [BookListController::class, 'deleteList'])->name('lists.delete');
});

Route::prefix('/lab')->group(function () {
    Route::get('', [LabController::class, 'index'])->name('lab.index');
    Route::get('create', [LabController::class, 'create'])->name('lab.create');
    Route::post('store-book', [LabController::class, 'storeBook'])->name('lab.book.store');
    Route::post('update-book/{book}', [LabController::class, 'updateBook'])->name('lab.book.update');
    Route::delete('delete-book/{bookId}', [LabController::class, 'deleteBook'])->name('lab.book.delete');
    Route::delete('remove-image/{bookId}', [LabController::class, 'removeImage'])->name('lab.image.remove');
    Route::post('publish-book/{book}', [LabController::class, 'publishBook'])->name('lab.book.publish');
    Route::get('edit/{book}', [LabController::class, 'editBook'])->name('lab.book.edit');
});

Route::delete('comments/{commentId}/delete', [BookCommentController::class, 'delete'])->name('books.comment.delete');
Route::post('comments/{commentId}/likes', [BookCommentController::class, 'toggleLike'])->name('comments.store');

Route::post('favorite-books/toggle', [BookListController::class, 'toggleFavorite'])->name('favorite-books.toggle');
Route::post('booklist/toggle', [BookListController::class, 'toggleReadList'])->name('booklist.toggle');

Route::get('/editor/{bookId}', [BookEditorController::class, 'show']);
Route::post('/editor/{bookId}/save', [BookEditorController::class, 'save']);
Route::delete('/editor/{bookId}/delete', [BookEditorController::class, 'delete']);
Route::get('/view-book/{bookId}', [BookEditorController::class, 'viewPdf']);


Route::post('ratings/{book}', [BookController::class, 'setBookRating'])->name('books.set-rating');
Route::delete('ratings/{bookId}', [BookController::class, 'deleteBookRating'])->name('books.delete-rating');

Route::prefix('/community')->group(function () {
    Route::get('', [CommunityController::class, 'index'])->name('community.index');
    Route::get('/clubs', [CommunityController::class, 'clubs'])->name('community.clubs.index');
    Route::get('/clubs/{clubId}', [CommunityController::class, 'showClub'])->name('community.clubs.show');
    Route::get('/topics', [CommunityController::class, 'topics'])->name('community.topics.index');
    Route::get('/topics/{topicId}', [CommunityController::class, 'showTopic'])->name('community.topics.show');
    Route::post('/topics/{topicId}', [CommunityController::class, 'storeComment'])->name('community.topics.comments.store');
    Route::delete('/topics/{topicId}', [CommunityController::class, 'deleteTopic'])->name('community.topics.delete');
});

Route::delete('/topics/comments/{commentId}', [CommunityController::class, 'deleteComment'])->name('topics.comments.delete');
Route::post('/test/topic/create', [CommunityController::class, 'testTopic']);

Route::post('/upload-cropped-image', [CommunityController::class, 'uploadImage'])->name('upload.image');

require __DIR__.'/auth.php';
