<?php

namespace App\Services;

use App\Models\book\Book;
use App\Models\book\BookGenre;
use App\Models\book\BookRating;
use App\Models\user\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookService
{
    private BookCommentService $bookCommentService;

    public function __construct(BookCommentService $bookCommentService)
    {
        $this->bookCommentService = $bookCommentService;
    }

    public function getBookDetails($request, $id): array
    {
        $book = $this->getBook($id);
        $averageRating = $book->ratings()->average('value');
        $book->community_rating = number_format((float) $averageRating, 2, '.', '');
        $comments = $this->bookCommentService->getBookComments($request, $id);
        $genres = $this->getBookGenres($id);
        $tags = $this->getBookTags($id);

        $isFavourite = $this->isBookInUserFavoriteList($id, Auth::id());
        $inList = $this->isBookInUserReadList($id, Auth::id());
        $rating = $book->ratings->where('user_id', auth()->id())->first();
        if (!$rating) {
            $rating = new BookRating();
        }
        $likedComments = $this->bookCommentService->userLikedCommentsByBook(Auth::id(), $id);
        $dislikedComments = $this->bookCommentService->userDislikedCommentsByBook(Auth::id(), $id);
        return [
            'book' => $book,
            'comments' => $comments,
            'genres' => $genres,
            'tags' => $tags,
            'isFavourite' => $isFavourite,
            'likedComments' => $likedComments,
            'dislikedComments' => $dislikedComments,
            'inList' => $inList,
            'rating' => $rating,
        ];
    }

    public function isBookInUserReadList($bookId, $userId): bool
    {
        $favoriteList = User::find($userId)->bookLists->where('type', 'readlist')->first()->id ?? null;
        return DB::table('book_list_books')
            ->where('book_list_id', $favoriteList)
            ->where('book_id', $bookId)
            ->exists();
    }

    public function isBookInUserFavoriteList($bookId, $userId): bool
    {
        $favoriteList = User::find($userId)->bookLists()->where('type', 'favorite')->first()->id ?? null;
        return DB::table('book_list_books')
            ->where('book_list_id', $favoriteList)
            ->where('book_id', $bookId)
            ->exists();
    }

    public function getAllBooks()
    {
        return Book::all();
    }

    public function getBook($id): Book
    {
        return Book::findOrFail($id);
    }

    public function getAllBookGenres()
    {
        return BookGenre::all();
    }

    public function getBookGenres($bookId)
    {
        return Book::find($bookId)->genres;
    }

    public function getBookTags($bookId)
    {
        return Book::find($bookId)->tags;
    }

    public function setBookRating(Request $request, $bookId): void
    {
        BookRating::updateOrCreate(
            [
                'book_id' => $bookId,
                'user_id' => Auth::id(),
            ],
            [
                'value' => $request['value']
            ]
        );
    }

    public function deleteBookRating($bookId): void
    {
        $rating = Book::find($bookId)->ratings->where('user_id', Auth::id())->first();
        $rating->delete();
    }


}
