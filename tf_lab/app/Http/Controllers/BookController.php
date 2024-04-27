<?php

namespace App\Http\Controllers;

use App\Models\book\BookSearchParams;
use App\Models\book\enums\BookAgeRating;
use App\Models\book\enums\BookLanguages;
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

    public function index(Request $request): Response
    {
        $genres = $this->bookService->getAllBookGenres();
        $allAgeRatings = BookAgeRating::values();
        $allLanguages = BookLanguages::values();

        $bookParams = new BookSearchParams($request->all());
        $books = $this->bookService->getAllBooks($bookParams);

        return Inertia::render('Books/Index', [
            'books' => $books,
            'allGenres' => $genres,
            'allAgeRatings' => $allAgeRatings,
            'allLanguages' => $allLanguages,
            'genre' => $request->input('genre'),
        ]);
    }

    public function show(Request $request, $id): Response
    {
        $data = $this->bookService->getBookDetails($request, $id);
        return Inertia::render('Books/Show', $data);
    }

    public function setBookRating(Request $request, $bookId): void
    {
        $this->bookService->setBookRating($request, $bookId);
    }

    public function deleteBookRating($bookId): void
    {
        $this->bookService->deleteBookRating($bookId);
    }

}
