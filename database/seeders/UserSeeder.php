<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = now();

        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'mobile' => '9999999999',
                'role' => 'admin',
                'password' => Hash::make('admin@123'),
                'created_at' => $now,
                'updated_at' => $now
            ], [
                'name' => 'User',
                'email' => 'user@example.com',
                'mobile' => '9876543210',
                'role' => 'user',
                'password' => Hash::make('Demo@123'),
                'created_at' => $now,
                'updated_at' => $now
            ],


        ]);
    }
}
