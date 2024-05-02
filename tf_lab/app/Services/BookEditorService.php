<?php

namespace App\Services;

use App\Models\book\Book;
use setasign\Fpdi\Tcpdf\Fpdi;

class BookEditorService
{

    public function loadPdfBook(\Illuminate\Http\Request $request, $bookId): void
    {
        $file = $request->file('pdf');
        $path = $file->store('public/books');
        $path = str_replace('public/', '/storage/', $path);
        $book = Book::find($bookId);
        $book->pdf_url = $path;
        $book->save();
    }
}
