<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Request;
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
        $books = $this->bookService->getAllBooks();
        return Inertia::render('Books/Index', ['books' => $books]);
    }

    public function show(Request $request, $id): Response
    {
        $data = $this->bookService->getBookDetails($request, $id);
        return Inertia::render('Books/Show', $data);
    }

    public function setRating(Request $request, $bookId): void
    {
        $this->bookService->setBookRating($request, $bookId);
    }

    public function deleteBookRating($bookId): void
    {
        $this->bookService->deleteBookRating($bookId);
    }

}
