<?php

namespace App\Http\Controllers;

use App\Models\book\BookGenre;
use App\Models\book\BookList;
use App\Models\user\User;
use App\Services\UserService;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function show($userId): Response
    {
        $user = $this->userService->getUser($userId);

        $topThreeGenreIds = BookList::where('user_id', $userId)
            ->where('type', 'readlist')
            ->with(['books.genres'])
            ->get()
            ->flatMap(function ($list) {
                return $list->books;
            })
            ->flatMap(function ($book) {
                return $book->genres;
            })
            ->groupBy('id')
            ->map->count()
            ->sortDesc()
            ->take(3)
            ->keys();

        $genres = BookGenre::whereIn('id', $topThreeGenreIds)
            ->get()
            ->sortBy(function ($genre) use ($topThreeGenreIds) {
                return array_search($genre->id, $topThreeGenreIds->toArray());
            })
            ->values();

        $bookLists = $user->bookLists()->withCount('books')->get();

        $userReviews = $user->reviews();
        $userReviewsCount = $userReviews->count();

        $latestReviews = $userReviews->with('book')->orderBy('id', 'desc')->take(2)->get();

        $publishedBooks = $user->books()->where('is_published', true)->orderBy('members', 'desc')->take(6)->get();

        return Inertia::render('Users/Show', [
            'user' => $user,
            'registeredAt' => $user->created_at->format('F Y'),
            'lists' => $bookLists,
            'topics' => $user->topics->count(),
            'genres' => $genres,
            'latestReviews' => $latestReviews,
            'reviewsCount' => $userReviewsCount,
            'publishedBooks' => $publishedBooks,

        ]);
    }

    public function userTopics($userId): Response
    {
        $user = $this->userService->getUser($userId);
        return Inertia::render('Users/ShowTopics', [
            'user' => $user,
            'topics' => $user->topics,
        ]);
    }

    public function userReviews($userId): Response
    {
        $user = User::with('reviews.book')->find($userId);
        return Inertia::render('Users/ShowReviews', [
            'user' => $user,
            'reviews' => $user->reviews,
        ]);
    }

    public function showUserList($userId, $type): Response
    {
        $list = User::find($userId)->bookLists->where('type', $type)->first()->books;
        return Inertia::render('Lists/' . ucfirst($type), [
            $type . 'List' => $list,
        ]);
    }

    public function showReadList($userId): Response
    {
        $readList = User::find($userId)->bookLists->where('type', 'readlist')->first()->books;
        return Inertia::render('Lists/ReadList', [
            'readList' => $readList,
        ]);
    }

    public function showFavoriteList($userId): Response
    {
        $favoriteList = User::find($userId)->bookLists->where('type', 'favorite')->first()->books;
        return Inertia::render('Lists/Favorite', [
            'favoriteList' => $favoriteList,
        ]);
    }
}
