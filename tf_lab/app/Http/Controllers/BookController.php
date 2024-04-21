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

    public function index(Request $request): Response
    {
        $genres = $this->bookService->getAllBookGenres();

        $sort = $request->input('sort', 1);
        $genre = $request->input('genre', null);
        $language = $request->input('language', null);
        $author = $request->input('author', null);
        $ageRating = $request->input('ageRating', null);
        $fromDate = $request->input('fromDate', null);
        $toDate = $request->input('toDate', null);
        $minMembers = $request->input('minMembers', null);
        $maxMembers = $request->input('maxMembers', null);

        $books = $this->bookService->getAllBooks($sort, $genre, $language, $author, $ageRating, $fromDate, $toDate, $minMembers, $maxMembers);

        return Inertia::render('Books/Index', [
            'books' => $books,
            'allGenres' => $genres,
            'genre' => $request->input('genre', null),
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
