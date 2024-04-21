<?php

namespace Database\Seeders;

use App\Models\book\Book;
use App\Models\book\BookRating;
use App\Models\user\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookRatingSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $books = Book::all();

        foreach ($users as $user) {
            foreach ($books->random(1) as $book) {
                BookRating::factory()->create([
                    'book_id' => $book->id,
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
