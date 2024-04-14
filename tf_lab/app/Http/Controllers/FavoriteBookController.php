<?php

namespace App\Http\Controllers;

use App\Models\book\Book;
use Illuminate\Http\Request;

class FavoriteBookController extends Controller
{
    public function toggleFavorite(Request $request): void
    {
        $book = Book::find($request->book_id);
        $request->user()->favoriteBooks()->toggle($book);;
    }

}
