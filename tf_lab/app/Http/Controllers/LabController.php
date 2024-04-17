<?php

namespace App\Http\Controllers;

use App\Models\book\Book;
use App\Services\BookService;
use App\Services\LabService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LabController extends Controller
{
    private LabService $labService;
    private BookService $bookService;

    public function __construct(LabService $labService, BookService $bookService)
    {
        $this->labService = $labService;
        $this->bookService = $bookService;
    }

    public function index(): Response
    {
        $books = $this->labService->getUserBooks();
        return Inertia::render('Lab/Index', [
            'books' => $books,
        ]);
    }

    public function create(): Response
    {
        $allGenres = $this->bookService->getAllBookGenres();
        return Inertia::render('Lab/Create', [
            'allGenres' => $allGenres,

        ]);
    }

    public function storeBook(Request $request): RedirectResponse
    {
        $this->labService->storeBook($request);
        return redirect(route('lab.index'));
    }

    public function updateBook(Request $request, $book): RedirectResponse
    {
        $this->labService->updateBook($request, $book);
        return redirect(route('lab.index'));
    }

    public function editBook($bookId): Response
    {
        $book = $this->bookService->getBook($bookId);
        $genres = $this->bookService->getBookGenres($bookId);
        $allGenres = $this->bookService->getAllBookGenres();
        $tags = $this->bookService->getBookTags($bookId);
        return Inertia::render('Lab/Edit', [
            'book' => $book,
            'genres' => $genres,
            'tags' => $tags,
            'allGenres' => $allGenres,
        ]);
    }

    public function deleteBook($bookId): RedirectResponse
    {
        $this->labService->deleteBook($bookId);
        return redirect(route('lab.index'));
    }

    public function publishBook($bookId): RedirectResponse
    {
        $this->labService->publishBook($bookId);
        return redirect('/lab/edit/' . $bookId);
    }

}
