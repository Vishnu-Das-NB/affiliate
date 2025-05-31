<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();
        $users = [
            ['name' => 'Vishnu Das NB', 'email' => 'vishnudasnb.official@gmail.com', 'password' => 'dasnb@123'],
            ['name' => 'Anshad', 'email' => 'buylokofficial@gmail.com', 'password' => 'Bylok@admin123'],
        ];

        foreach ($users as $user) {
            if (!User::where('email', $user['email'])->exists()) {
                User::create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => Hash::make($user['password'] ?? 'password'), // Default password
                ]);
            }
        }
    }
}
