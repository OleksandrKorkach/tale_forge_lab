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

    public function save(Request $request, $bookId)
    {
        $path = $this->bookEditorService->loadPdfBook($request, $bookId);
        return $path;
    }

    public function viewPdf()
    {
        return Inertia::render('Editor/Reader');
//        $path = 'public/books/' . 'HUm7x8iMEqbGXTk67pX39BOtV8DDHF0hT99f52eU.pdf';
//
//        if (!Storage::disk('local')->exists($path)) {
//            abort(404);
//        }
//
//        $file = Storage::disk('local')->get($path);
//        $type = Storage::disk('local')->mimeType($path);
//
//        return response($file, 200)->header('Content-Type', $type);
    }
}
