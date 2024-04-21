<?php

namespace Database\Factories\book;

use App\Models\book\Book;
use App\Models\book\BookComment;
use App\Models\book\BookGenre;
use App\Models\user\User;
use App\Utils\DateUtil;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $published_at = $this->faker->dateTimeBetween('-1 year', 'now');

        return [
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->paragraph,
            'author_name' => $this->faker->name,
            'published_at' => $published_at,
            'year' => $published_at->format('Y'),
            'season' => DateUtil::getSeason($published_at),
            'language' => $this->faker->randomElement([
                "English",
                "Chinese",
                "Hindi",
                "Spanish",
                "French",
                "Arabic",
                "Bengali",
                "Ukrainian",
                "Portuguese",
                "Urdu",
                "Indonesian",
                "German",
                "Japanese",
                "Swahili",
                "Marathi",
                "Telugu",
                "Turkish",
                "Korean",
                "Vietnamese",
                "Tamil"
            ]),
            'quote' => $this->faker->sentence,
            'pages' => $this->faker->numberBetween(100, 500),
            'age_rating' => $this->faker->numberBetween(8, 18) . '+',
            'is_published' => true,
            'community_rating' => $this->faker->randomFloat(2, 3, 10),
            'members' => $this->faker->numberBetween(300, 2400),
            'favorite_members' => $this->faker->numberBetween(120, 270),
            'user_id' => User::factory()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Book $book) {
            $genreIds = BookGenre::inRandomOrder()->limit(4)->pluck('id');
            $book->genres()->attach($genreIds);

            BookComment::factory(5)->create([
                'book_id' => $book->id,
                'user_id' => User::inRandomOrder()->first()->id,
            ]);
        });


    }
}
