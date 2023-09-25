<?php

namespace Database\Seeders;

use Database\Seeders\AdminsTableSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\ListingSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed Admins (1st)
        $this->call(AdminsTableSeeder::class);

        // Seed Users (2nd)
        $this->call(UserSeeder::class);

        // Seed Categories (3rd)
        $this->call(CategorySeeder::class);

        // Seed Tags (4th)
        $this->call(TagSeeder::class);

        // Seed Listings (5th)
        $this->call(ListingSeeder::class);

        // Add more seeders as needed
    }
}
