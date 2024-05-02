<?php

namespace App\Services;

use App\Models\book\Book;
use App\Models\book\BookList;
use App\Models\user\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookListService
{

    public function getListWithGenres($listId)
    {
        return BookList::with('books.genres')->find($listId);
    }

    public function toggleBookInList($bookId, $listId): void
    {
        $list = BookList::find($listId);
        $book = Book::find($bookId);
        $list->books()->toggle($book);
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
}
