<?php

namespace App\Http\Controllers;

use App\Models\book\Book;
use App\Services\BookCommentService;
use App\Services\BookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class BookController extends Controller
{
    private BookService $bookService;
    private BookCommentService $bookCommentService;

    public function __construct(BookService $bookService, BookCommentService $bookCommentService)
    {
        $this->bookService = $bookService;
        $this->bookCommentService = $bookCommentService;
    }


    public function index(): Response
    {
        $books = Book::all();
        return Inertia::render('Books/Index', [
            'books' => $books,
        ]);
    }

    public function show($id): Response
    {
        $book = $this->bookService->getBook($id);
        $comments = $this->bookCommentService->getBookComments($id);
        $genres = [];
        return Inertia::render('Books/Show', [
            'book' => $book,
            'comments' => $comments,
            'genres' => $genres,
        ]);
    }

    public function showPage($book, $page): Response
    {
        $bookModel = $this->bookService->getBook($book);
        $blocks = $this->bookService->getPageBlocks($book, $page);

        return Inertia::render('Books/ShowPage', [
            'book' => $bookModel,
            'blocks' => $blocks,
        ]);
    }

    public function addBlockToPage(Request $request, $book, $page): RedirectResponse
    {
        $this->bookService->storeBlock($request, $book, $page);
        return Redirect::back();
    }

    public function destroyPageBlock($block): RedirectResponse
    {
        $this->bookService->deleteBlock($block);
        return Redirect::back();
    }
}
