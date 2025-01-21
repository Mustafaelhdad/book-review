<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory()
            ->count(100)
            ->create()
            ->each(function ($book) {
                // Generate a random number of reviews (between 5 and 30)
                $reviewCount = rand(5, 30);

                // Generate reviews with random ratings (good, average, bad)
                Review::factory()
                    ->count($reviewCount)
                    ->state(function () {
                        // Randomly select one of the states (good, average, bad)
                        $states = ['good', 'average', 'bad'];
                        $state = $states[array_rand($states)];

                        // Return the selected state
                        return Review::factory()->$state()->raw();
                    })
                    ->create(['book_id' => $book->id]); // Associate reviews with the current book
            });
    }
}
