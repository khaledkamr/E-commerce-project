<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'view roles'],
            ['name' => 'add roles'],
            ['name' => 'update roles'],
            ['name' => 'delete roles'],
            ['name' => 'view permissions'],
            ['name' => 'add permissions'],
            ['name' => 'update permissions'],
            ['name' => 'delete permissions'],
            ['name' => 'view products'],
            ['name' => 'add products'],
            ['name' => 'update products'],
            ['name' => 'delete products'],
            ['name' => 'view orders'],
            ['name' => 'create orders'],
            ['name' => 'update orders'],
            ['name' => 'delete orders'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
