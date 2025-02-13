<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $genres = collect([
            'Action',
            'Adventure',
            'Comedy',
            'Crime',
            'Drama',
            'Fantasy',
            'Historical',
            'Horror',
            'Mystery',
            'Philosophical',
            'Political',
            'Romance',
            'Science fiction',
            'Thriller',
            'Urban',
            'Western'
        ]);

        $statuses = collect(['Coming soon', 'Now playing']);

        $movies = [];

        foreach (range(1, 10) as $index) {
            $movies[] = [
                'title' => $faker->sentence(3),
                'synopsis' => $faker->paragraph(4),
                'duration' => $faker->numberBetween(80, 180), // 80 - 180 menit
                'genre' => $genres->random(),
                'rating' => $faker->randomFloat(1, 0, 10), // Rating antara 0.0 - 10.0
                'poster' => 'posters/' . Str::random(10) . '.jpg', // Simulasi path poster
                'trailer_url' => 'https://www.youtube.com/watch?v=' . Str::random(10), // Simulasi trailer URL
                'release_date' => $faker->date(),
                'status' => strtolower($statuses->random()), // Sesuai enum ['coming soon', 'now playing']
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('movies')->insert($movies);
    }
}
