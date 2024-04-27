<?php

namespace App\Http\Controllers;

use App\Exports\BookListExport;
use App\Models\book\Book;
use App\Models\book\BookList;
use App\Models\user\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;

class BookListController extends Controller
{
    public function show($listId): Response
    {
        $list = BookList::with('books.genres')->find($listId);

        return Inertia::render('Lists/Show', [
            'list' => $list,
        ]);
    }

    public function toggleBook($listId, $bookId): void
    {
        $list = BookList::find($listId);
        $book = Book::find($bookId);
        $list->books()->toggle($book);
    }

    public function toggleFavorite(Request $request): void
    {
        $this->toggleUserList($request, 'favorite', 'favorite');
    }

    public function toggleReadList(Request $request): void
    {
        $this->toggleUserList($request, 'readlist', 'readlist');
    }

    public function toggleUserList(Request $request, $listName, $listType): void
    {
        $book = Book::find($request->book_id);

        $changes = User::find(Auth::id())
            ->bookLists
            ->where('type', $listType)
            ->where('name', $listName)
            ->first()
            ->books()
            ->toggle($book);

        if (count($changes['attached']) > 0) {
            $this->incrementMembers($listType, $book);
        }

        if (count($changes['detached']) > 0) {
            $this->decrementMembers($listType, $book);
        }
    }

    public function incrementMembers($listType, $book): void
    {
        if ($listType == 'readlist') {
            $book->increment('members');
        } elseif ($listType == 'favorite') {
            $book->increment('favorite_members');
        }
    }

    public function decrementMembers($listType, $book): void
    {
        if ($listType == 'readlist') {
            $book->decrement('members');
        } elseif ($listType == 'favorite') {
            $book->decrement('favorite_members');
        }
    }

    public function export($listId)
    {
        $date = date('Y-m-d_H-i-s');
        $filename = "export_list{$listId}_{$date}.xlsx";

        return Excel::download(new BookListExport($listId), $filename);
    }
}
