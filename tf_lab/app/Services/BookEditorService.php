<?php

namespace App\Services;

use App\Models\book\Book;
use Exception;
use setasign\Fpdi\Tcpdf\Fpdi;

class BookEditorService
{

    public function loadPdfBook(\Illuminate\Http\Request $request, $bookId): void
    {
        $book = Book::find($bookId);
        $file = $request->file('pdf');
        $path = $file->store('public/books');
        try {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile(storage_path('app/' . $path));
        } catch (Exception $e) {
            $pageCount = 0;
        }

        $book->pdf_url = str_replace('public/', '/storage/', $path);
        $book->pages = $pageCount;
        $book->save();
    }

    public function deletePdfBook($bookId): void
    {
        $book = Book::find($bookId);
        $book->pdf_url = null;
        $book->save();
    }
}
