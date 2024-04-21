<?php

namespace Database\Factories\user;

use App\Models\book\BookList;
use App\Models\user\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            BookList::create([
                'name' => 'readlist',
                'description' => 'readlist',
                'type' => 'readlist',
                'user_id' => $user->id,
            ]);

            BookList::create([
                'name' => 'favorite',
                'description' => 'favorite',
                'type' => 'favorite',
                'user_id' => $user->id,
            ]);

        });


    }
}
