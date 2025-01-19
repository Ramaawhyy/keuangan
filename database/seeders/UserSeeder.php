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
            'password' => Hash::make('admin123'), // Password: admin123
            'role' => 'admin_besar',
        ]);

        User::create([
            'name' => 'Admin Keuangan',
            'username' => 'adminkeuangan',
            'email' => 'adminkeuangan@example.com',
            'password' => Hash::make('keuangan123'), // Password: keuangan123
            'role' => 'admin_keuangan',
        ]);

        User::create([
            'name' => 'Admin Inventory',
            'username' => 'admininventory',
            'email' => 'admininventory@example.com',
            'password' => Hash::make('inventory123'), // Password: inventory123
            'role' => 'admin_inventory',
        ]);
    }
}
