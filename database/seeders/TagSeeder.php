<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create some sample tags
        Tag::create(['name' => 'javascript']);
        Tag::create(['name' => 'react']);
        Tag::create(['name' => 'vuejs']);
        Tag::create(['name' => 'webdev']);
        Tag::create(['name' => 'softwaredeveloper']);
        Tag::create(['name' => 'mobilecoding']);
        Tag::create(['name' => 'chronostep']);
        Tag::create(['name' => 'beginner']);
        Tag::create(['name' => 'programming']);
        Tag::create(['name' => 'devops']);
        Tag::create(['name' => 'cheatsheet']);
        Tag::create(['name' => 'gwapoka?']);
    }
}
