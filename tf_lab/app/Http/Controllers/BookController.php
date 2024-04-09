<?php

namespace App\Http\Controllers;

use App\Models\book\Book;
use App\Services\BookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class BookController extends Controller
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
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

        return Inertia::render('Books/Show', [
            'book' => $book,
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
