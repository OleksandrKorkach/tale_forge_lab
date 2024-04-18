<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            ['name' => 'Fantasy', 'text_color' => '#FFFFFF', 'background_color' => '#9333ea'],
            ['name' => 'Sci-Fi', 'text_color' => '#FFFFFF', 'background_color' => '#22d3ee'],
            ['name' => 'Mystery', 'text_color' => '#FFFFFF', 'background_color' => '#7c3aed'],
            ['name' => 'Thriller', 'text_color' => '#FFFFFF', 'background_color' => '#dc2626'],
            ['name' => 'Horror', 'text_color' => '#FFFFFF', 'background_color' => '#030712'],
            ['name' => 'Romance', 'text_color' => '#FFFFFF', 'background_color' => '#ec4899'],
            ['name' => 'Historical', 'text_color' => '#FFFFFF', 'background_color' => '#f97316'],
            ['name' => 'Adventure', 'text_color' => '#FFFFFF', 'background_color' => '#22c55e'],
            ['name' => 'Paranormal', 'text_color' => '#FFFFFF', 'background_color' => '#14b8a6'],
            ['name' => 'Biography', 'text_color' => '#FFFFFF', 'background_color' => '#10b981'],
            ['name' => 'Philosophy', 'text_color' => '#FFFFFF', 'background_color' => '#38bdf8'],
            ['name' => 'Poetry', 'text_color' => '#FFFFFF', 'background_color' => '#e879f9'],
            ['name' => 'Drama', 'text_color' => '#FFFFFF', 'background_color' => '#facc15'],
            ['name' => 'Classics', 'text_color' => '#fafafa', 'background_color' => '#404040'],

        ];

        foreach ($genres as $genre) {
            DB::table('book_genres')->insert([
                'name' => $genre['name'],
                'text_color' => $genre['text_color'],
                'background_color' => $genre['background_color'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
