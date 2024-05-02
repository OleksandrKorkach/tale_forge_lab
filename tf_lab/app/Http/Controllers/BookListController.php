<?php

namespace App\Http\Controllers;

use App\Exports\BookListExport;
use App\Models\book\Book;
use App\Models\book\BookList;
use App\Models\user\User;
use App\Services\BookListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;

class BookListController extends Controller
{
    private BookListService $bookListService;

    public function __construct(BookListService $bookListService)
    {
        $this->bookListService = $bookListService;
    }

    public function show($listId): Response
    {
        $list = $this->bookListService->getListWithGenres($listId);
        return Inertia::render('Lists/Show', [
            'list' => $list,
        ]);
    }

    public function toggleBook($listId, $bookId): void
    {
        $this->bookListService->toggleBookInList($bookId, $listId);
    }

    public function toggleFavorite(Request $request): void
    {
        $this->bookListService->toggleUserList($request, 'favorite', 'favorite');
    }

    public function toggleReadList(Request $request): void
    {
        $this->bookListService->toggleUserList($request, 'readlist', 'readlist');
    }

    public function export($listId)
    {
        $date = date('Y-m-d_H-i-s');
        $filename = "export_list{$listId}_{$date}.xlsx";

        return Excel::download(new BookListExport($listId), $filename);
    }
}
