<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Besar',
            'username' => 'adminbesar',
            'email' => 'adminbesar@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_besar',
        ]);

        User::create([
            'name' => 'Admin Keuangan',
            'username' => 'adminkeuangan',
            'email' => 'adminkeuangan@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_keuangan',
        ]);

        User::create([
            'name' => 'Admin Inventory',
            'username' => 'admininventory',
            'email' => 'admininventory@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin_inventory',
        ]);
    }
}
