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
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Jangan lupa mengganti password ini di production
        ]);

        User::create([
            'name' => 'User',
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => Hash::make('user123'), 
        ]);
    }
}
