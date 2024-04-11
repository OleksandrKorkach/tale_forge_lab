<?php

namespace App\Services;

use App\Models\book\Book;
use App\Models\book\BookComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookCommentService
{
    public function getBookComments($bookId)
    {
        return Book::find($bookId)->comments;
    }

    public function storeComment(Request $request, $bookId): void
    {
        $user = Auth::user();
        $comment = new BookComment();
        $comment->book_id = $bookId;
        $comment->content = $request->input('content');
        $comment->username = $user->name;
        $comment->created_at = now();
        $comment->updated_at = now();
        $comment->save();
    }
}
