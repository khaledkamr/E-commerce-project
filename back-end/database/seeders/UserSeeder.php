<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Khaled Kamr',
                'email' => 'kk@gmail.com',
                'password' => 111,
                'phone' => '0123456789',
            ],
            [
                'name' => 'Yossif Kamr',
                'email' => 'yk@gmail.com',
                'password' => 111,
                'phone' => '0123456789',
            ],
            [
                'name' => 'nike',
                'email' => 'nike@gmail.com',
                'password' => 111,
                'phone' => '0123456789',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => 111,
                'phone' => '0123456789',
            ],
            [
                'name' => 'shein',
                'email' => 'shein@gmail.com',
                'password' => 111,
                'phone' => '0123456789',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
