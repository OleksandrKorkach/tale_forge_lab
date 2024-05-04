<?php

namespace App\Services;

use App\Models\book\Book;
use App\Models\book\BookGenre;
use App\Models\book\BookRating;
use App\Models\book\BookSearchParams;
use App\Models\book\enums\BookAgeRating;
use App\Models\book\enums\BookLanguages;
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
        $lists = Auth::id() ? User::find(Auth::id())->booklists()->where('type', 'custom')->get() : null;
        $inLists = Auth::id() ? User::find(Auth::id())->booklists()->where('type', 'custom')->whereHas('books', function ($query) use ($id) {
            $query->where('book_id', $id);
        })->pluck('id')->toArray() : [];

        $isFavourite = Auth::id() ? $this->isBookInUserFavoriteList($id, Auth::id()) : null;
        $inList = Auth::id() ? $this->isBookInUserReadList($id, Auth::id()) : null;
        $rating = $book->ratings->where('user_id', auth()->id())->first();
        $rating = $rating ?: new BookRating();

        $likedComments = $this->bookCommentService->userLikedCommentsByBook(Auth::id(), $id);
        $dislikedComments = $this->bookCommentService->userDislikedCommentsByBook(Auth::id(), $id);
        return [
            'book' => $book,
            'comments' => $comments,
            'genres' => $genres,
            'tags' => $tags,
            'lists' => $lists,
            'inLists' => $inLists,
            'isFavourite' => $isFavourite,
            'likedComments' => $likedComments,
            'dislikedComments' => $dislikedComments,
            'inList' => $inList,
            'rating' => $rating,
        ];
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

    public function getAllBooks(BookSearchParams $params)
    {
        $query = Book::query()->where('is_published', true);

        $this->applyFilters($query, $params);

        $this->applySorting($query, $params->sort);

        return $query->get();
    }

    private function applyFilters($query, $params): void
    {
        $filters = [
            'genre' => 'filterByGenre',
            'author' => 'filterByAuthor',
            'language' => 'filterByLanguage',
            'ageRating' => 'filterByAgeRating',
            'minMembers' => 'filterByMinMembers',
            'maxMembers' => 'filterByMaxMembers',
            'fromDate' => 'filterByFromDate',
            'toDate' => 'filterByToDate',
        ];

        foreach ($filters as $key => $method) {
            if (!empty($params->$key)) {
                $this->$method($query, $params->$key);
            }
        }
    }

    private function applySorting($query, $sort): void
    {
        $sortOptions = [
            2 => ['members', 'desc'],
            3 => ['favorite_members', 'desc'],
            4 => ['raw', 'COALESCE(CAST(favorite_members AS FLOAT) / NULLIF(CAST(members AS FLOAT), 0), 0) DESC'],
            5 => ['published_at', 'desc'],
            1 => ['raw', 'COALESCE(community_rating, 0) DESC']
        ];

        $sortType = $sortOptions[$sort] ?? $sortOptions[1];

        if ($sortType[0] === 'raw') {
            $query->orderByRaw($sortType[1]);
        } else {
            $query->orderBy($sortType[0], $sortType[1]);
        }
    }

    private function filterByGenre($query, $genre): void
    {
        $query->whereHas('genres', function ($q) use ($genre) {
            $q->where('name', $genre);
        });
    }

    private function filterByAuthor($query, $author): void
    {
        $query->where('author_name', 'like', '%' . $author . '%');
    }

    private function filterByLanguage($query, $language): void
    {
        $query->where('language', $language);
    }

    private function filterByAgeRating($query, $ageRating): void
    {
        $query->where('age_rating', $ageRating);
    }

    private function filterByMinMembers($query, $minMembers): void
    {
        $query->where('members', '>=', $minMembers);
    }

    private function filterByMaxMembers($query, $maxMembers): void
    {
        $query->where('members', '<=', $maxMembers);
    }

    private function filterByFromDate($query, $fromDate): void
    {
        $query->where('published_at', '>=', $fromDate);
    }

    private function filterByToDate($query, $toDate): void
    {
        $query->where('published_at', '<=', $toDate);
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
