<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define an array of category names to be seeded
        $categories = [
            'Web Development',
            'Mobile Development',
            'REACT Dev',
            'Vuejs',
            'Javascript',
            'Magento',
            'WordPress',
            'UI/UX Design',
            'HTML/CSS',
            'Angular',
            'PHP LARAVEL',
            'Quality Testing',
        ];

        // Loop through the array and create Category records in the database
        foreach ($categories as $category) {
            // Create a new Category record with the specified name
            Category::create(['name' => $category]);
        }
    }
}
