<?php

namespace App\Http\Controllers;

use App\Models\book\Book;
use App\Services\BookEditorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class BookEditorController extends Controller
{
    private BookEditorService $bookEditorService;

    public function __construct(BookEditorService $bookEditorService)
    {
        $this->bookEditorService = $bookEditorService;
    }

    public function show($bookId): Response
    {
        return Inertia::render('Editor/Show', [
            'book' => Book::find($bookId)
        ]);
    }

    public function save(Request $request, $bookId): void
    {
        $this->bookEditorService->loadPdfBook($request, $bookId);
    }

    public function viewPdf($bookId): Response
    {
        $book = Book::find($bookId);
        return Inertia::render('Editor/Reader', [
            'pdfUrl' => $book->pdf_url,
        ]);
    }
}
