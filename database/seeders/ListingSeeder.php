<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Tag;
use App\Models\User;
use Faker\Factory as Faker;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get a list of user IDs for association
        $userIds = User::inRandomOrder()->pluck('id')->toArray();

        // Get all tag IDs
        $tagIds = Tag::pluck('id')->toArray();

        // Create 10 sample listings with random tags and categories
        for ($i = 1; $i <= 10; $i++) {
            // Create a new listing with random user and sample data
            $listing = Listing::create([
                'user_id' => $userIds[array_rand($userIds)], // Assign a random user
                'title' => "Sample Listing $i",
                'description' => "This is a sample description for Listing $i.",
            ]);

            // Shuffle the tag IDs and take the first 3 to assign random tags
            $randomTags = collect($tagIds)->shuffle()->take(3)->toArray();

            // Attach random tags to the listing
            $listing->tags()->attach($randomTags);

            // Get a list of category IDs for association
            $categoryIds = Category::pluck('id')->toArray();

            // Attach random categories to the listing
            $listing->categories()->attach($categoryIds[array_rand($categoryIds)]);
        }
    }
}
