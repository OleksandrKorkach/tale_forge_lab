<?php

namespace App\Http\Controllers;

use App\Models\book\BookComment;
use App\Services\BookCommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


}
