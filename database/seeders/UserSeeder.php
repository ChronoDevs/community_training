<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Create default users
        User::create([
            'name' => $faker->firstName,
            'middle_name' => $faker->lastName,
            'last_name' => $faker->lastName,
            'user_name' => $faker->userName,
            'nickname' => $faker->firstName,
            'gender' => $faker->randomElement(['Male', 'Female']),
            'date_of_birth' => $faker->date($format = 'Y-m-d', $max = '1990-05-15'),
            'contact_number' => $faker->phoneNumber,
            'zip_code' => $faker->postcode,
            'address' => $faker->address,
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('password123'),
        ]);

        // Create more users with random data
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->firstName,
                'middle_name' => $faker->lastName,
                'last_name' => $faker->lastName,
                'user_name' => $faker->userName,
                'nickname' => $faker->firstName,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'date_of_birth' => $faker->date($format = 'Y-m-d', $max = '2000-01-01'),
                'contact_number' => $faker->phoneNumber,
                'zip_code' => $faker->postcode,
                'address' => $faker->address,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
            ]);
        }
    }
}
