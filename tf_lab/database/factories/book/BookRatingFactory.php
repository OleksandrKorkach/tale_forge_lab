<?php

namespace Database\Factories\book;

use App\Models\book\Book;
use App\Models\user\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookRatingFactory extends Factory
{

    public function definition(): array
    {
        return [
            'book_id' => Book::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'value' => $this->faker->numberBetween(1, 10),
        ];
    }
}
