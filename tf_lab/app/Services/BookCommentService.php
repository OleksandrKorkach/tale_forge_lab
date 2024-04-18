<?php

namespace App\Services;

use App\Models\book\Book;
use App\Models\book\BookComment;
use App\Models\book\BookCommentLike;
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

    public function toggleLike(Request $request, $commentId): void
    {
        $like = BookCommentLike::where('user_id', auth()->id())
            ->where('comment_id', $commentId)
            ->first();

        if ($like) {
            if ($like->type === $request->type) {
                $like->delete();
            } else {
                $like->update(['type' => $request->type]);
            }
        } else {
            BookCommentLike::create([
                'user_id' => auth()->id(),
                'comment_id' => $commentId,
                'type' => $request->type
            ]);
        }
    }

    public function userLikedCommentsByBook($userId, $bookId)
    {
        return BookComment::where('book_id', $bookId)
        ->whereHas('likes', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->where('type', 'like');
        })
            ->pluck('id');
    }

    public function userDislikedCommentsByBook($userId, $bookId)
    {
        return BookComment::where('book_id', $bookId)
            ->whereHas('likes', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('type', 'dislike');
            })
            ->pluck('id');
    }
}
