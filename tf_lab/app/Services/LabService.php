<?php

namespace App\Services;

use App\Models\book\Book;
use Illuminate\Support\Facades\Auth;

class LabService
{

    public function getUserBooks(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Book::query()
            ->where('user_id', Auth::id())
            ->get();
    }


}
