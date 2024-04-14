<?php

namespace App\Http\Controllers;

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

    public function delete($commentId): void
    {
        $this->bookCommentService->deleteComment($commentId);
    }

    public function toggleLike(Request $request, $commentId): void
    {
        $this->bookCommentService->toggleLike($request, $commentId);
    }

}
