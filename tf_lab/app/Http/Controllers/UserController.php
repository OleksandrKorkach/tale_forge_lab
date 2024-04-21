<?php

namespace App\Http\Controllers;

use App\Models\user\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
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
        $readListCount = $this->userService->getReadListCount($userId);
        $favoriteCount = $this->userService->getFavoriteListCount($userId);
        $user = $this->userService->getUser($userId);
        $bookLists = $user->bookLists;
        return Inertia::render('Users/Show', [
            'userInfo' => $user,
            'readList' => $readListCount,
            'favorite' => $favoriteCount,
            'bookLists' => $bookLists,
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
