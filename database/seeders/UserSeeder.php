<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Super Admin',
                'username' => 'super_admin',
                'email' => 'super_admin@mail.com',
                'password' => '12345678'
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'password' => '12345678'
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@mail.com',
                'password' => '12345678'
            ]
        ];

        foreach ($data as $user) {
            User::create($user);
        }
    }
}
