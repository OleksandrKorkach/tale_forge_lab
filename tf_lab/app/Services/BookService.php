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
        $comments = $this->bookCommentService->getBookComments($request, $id);
        $genres = $this->getBookGenres($id);
        $tags = $this->getBookTags($id);

        $isFavourite = Auth::id() ? $this->isBookInUserFavoriteList($id, Auth::id()) : null;
        $inList = Auth::id() ? $this->isBookInUserReadList($id, Auth::id()) : null;
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
        $readList = User::find($userId)->bookLists->where('type', 'readlist')->first()->id ?? null;
        return DB::table('book_list_books')
            ->where('book_list_id', $readList)
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

    public function getAllBooks($sort = 1, $genre = null, $language = null, $author = null, $ageRating = null, $fromDate = null, $toDate = null, $minMembers = null, $maxMembers = null)
    {
        $query = Book::query()->where('is_published', true);

        if ($genre) {
            $query->whereHas('genres', function ($query) use ($genre) {
                $query->where('name', $genre);
            });
        }

        if ($author) {
            $query->where('author_name', 'like', '%' . $author . '%');
        }

        if ($language) {
            $query->where('language', $language);
        }

        if ($ageRating) {
            $query->where('age_rating', $ageRating);
        }

        if ($minMembers) {
            $query->where('members', '>=', $minMembers);
        }

        if ($maxMembers) {
            $query->where('members', '>=', $maxMembers);
        }

        if ($fromDate) {
            $query->where('published_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->where('published_at', '<=', $toDate);
        }

        if ($sort == 2){
            $query->orderBy('members', 'desc');
        } else if ($sort == 3) {
            $query->orderBy('favorite_members', 'desc');
        } else if ($sort == 4) {
            $query->orderByRaw('COALESCE(CAST(favorite_members AS FLOAT) / NULLIF(CAST(members AS FLOAT), 0), 0) DESC');
        } else if ($sort == 5){
            $query->orderBy('published_at', 'desc');
        } else {
            $query->orderByRaw('COALESCE(community_rating, 0) DESC');
        }

        return $query->get();
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
        $book = Book::find($bookId);
        $avgRating = $book->ratings()->avg('value');
        $book->community_rating = number_format($avgRating, 2, '.', '');
        $book->save();
    }

    public function deleteBookRating($bookId): void
    {
        $rating = Book::find($bookId)->ratings->where('user_id', Auth::id())->first();
        $rating->delete();
    }


}
