<?php

namespace App\Services;

use setasign\Fpdi\Tcpdf\Fpdi;

class BookEditorService
{

    public function loadPdfBook(\Illuminate\Http\Request $request, $bookId)
    {
        $file = $request->file('pdf');
        $path = $file->store('public/books');

        return str_replace('public/', '/storage/', $path);
//        $pdf = new Fpdi();
//        $pdf->
//        $pdf = $request->file('pdf');
//        $bookId = $request->input('bookId');
    }
}
