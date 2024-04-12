<?php

namespace App\Services;

use App\Models\book\Book;
use App\Models\book\BookComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookCommentService
{
    public function getBookComments(Request $request, $bookId)
    {
        $book = Book::with(['comments' => function ($query) use ($request) {
            $sortType = $request->query('sort', 1);

            if ($sortType == 2) {
                $query->selectRaw('book_comments.*, (number_of_likes + number_of_dislikes) as total_likes')
                    ->orderBy('total_likes', 'desc');
            } else if ($sortType == 1) {
                $query->orderBy('created_at', 'desc');
            } else if ($sortType == 3) {
                $query->orderBy('number_of_likes', 'desc');
            } else {

            }
        }])->findOrFail($bookId);

        return $book->comments;
    }

    public function storeComment(Request $request, $bookId): void
    {
        $user = Auth::user();
        $comment = new BookComment();
        $comment->book_id = $bookId;
        $comment->user_id = Auth::id();
        $comment->content = $request->input('content');
        $comment->username = $user->name;
        $comment->created_at = now();
        $comment->updated_at = now();
        $comment->save();
    }

    public function deleteComment($commentId): void
    {
        BookComment::destroy($commentId);
    }
}
