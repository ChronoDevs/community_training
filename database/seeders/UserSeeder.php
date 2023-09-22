<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default users
        User::create([
            'name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'user_name' => 'john_smith',
            'nickname' => 'JD',
            'gender' => 'Male',
            'date_of_birth' => '1990-05-15',
            'contact_number' => '123-456-7890',
            'zip_code' => '12345',
            'address' => '123 Main Street',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Jane',
            'middle_name' => 'Marie',
            'last_name' => 'Johnson',
            'user_name' => 'jane_johnson',
            'nickname' => 'JJ',
            'gender' => 'Female',
            'date_of_birth' => '1985-08-20',
            'contact_number' => '987-654-3210',
            'zip_code' => '54321',
            'address' => '456 Oak Avenue',
            'email' => 'jane@example.com',
            'password' => Hash::make('password456'),
            'role' => 'user',
        ]);

        // Add more user data as needed
    }
}
