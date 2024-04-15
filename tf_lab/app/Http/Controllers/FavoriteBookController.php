<?php

namespace App\Http\Controllers;

use App\Models\book\Book;
use Illuminate\Http\Request;

class FavoriteBookController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $book = Book::find($request->book_id);
        $user = $request->user();

        $changes = $user->favoriteBooks()->toggle($book);

        if (count($changes['attached']) > 0) {
            $book->increment('favorite_members');
        }

        if (count($changes['detached']) > 0) {
            $book->decrement('favorite_members');
        }
    }

    public function toggleBookList(Request $request)
    {
        $book = Book::find($request->book_id);
        $user = $request->user();

        $changes = $user->booklist()->toggle($book);

        if (count($changes['attached']) > 0) {
            $book->increment('members');
        }

        if (count($changes['detached']) > 0) {
            $book->decrement('members');
        }
    }

}
