<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ListingSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed Users
        $this->call(UserSeeder::class);

        // Seed Listings (or other seeders)
        $this->call(ListingSeeder::class);

        // Add more seeders as needed
    }
}
