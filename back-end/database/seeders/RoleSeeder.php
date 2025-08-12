<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'owner'],
            ['name' => 'admin'],
            ['name' => 'seller'],
            ['name' => 'user'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
