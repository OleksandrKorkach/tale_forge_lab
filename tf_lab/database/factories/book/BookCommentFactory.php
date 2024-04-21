<?php

namespace Database\Factories\book;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookCommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph,
            'username' => $this->faker->name,
            'number_of_likes' => $this->faker->numberBetween(10, 50),
            'number_of_dislikes' => $this->faker->numberBetween(0, 20),

        ];
    }
}
