<?php

namespace App\Services;

use App\Models\user\User;

class UserService
{
    public function getReadListCount($userId)
    {
        $user = $this->getUser($userId);
        return $user->bookLists->where('type', 'readlist')->first()->books()->count();
    }

    public function getFavoriteListCount($userId)
    {
        $user = $this->getUser($userId);
        return $user->bookLists->where('type', 'favorite')->first()->books()->count();
    }

    public function getUser($userId)
    {
        return User::find($userId);
    }
}
