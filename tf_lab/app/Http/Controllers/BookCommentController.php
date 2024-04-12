<?php

namespace App\Http\Controllers;

use App\Models\book\BookCommentLike;
use App\Services\BookCommentService;
use Illuminate\Http\Request;

class BookCommentController extends Controller
{
    private BookCommentService $bookCommentService;


    public function __construct(BookCommentService $bookCommentService)
    {
        $this->bookCommentService = $bookCommentService;
    }

    public function store(Request $request, $bookId): void
    {
        $this->bookCommentService->storeComment($request, $bookId);
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


}
