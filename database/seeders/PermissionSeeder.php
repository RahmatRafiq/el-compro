<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'create user',
                'guard_name' => 'web',
                'route' => 'user.create'
            ],
            [
                'name' => 'read user',
                'guard_name' => 'web',
                'route' => 'user.read'
            ],
            [
                'name' => 'update user',
                'guard_name' => 'web',
                'route' => 'user.update'
            ],
            [
                'name' => 'delete user',
                'guard_name' => 'web',
                'route' => 'user.delete'
            ],
            [
                'name' => 'create role',
                'guard_name' => 'web',
                'route' => 'role.create'
            ],
            [
                'name' => 'read role',
                'guard_name' => 'web',
                'route' => 'role.read'
            ],
            [
                'name' => 'update role',
                'guard_name' => 'web',
                'route' => 'role.update'
            ],
            [
                'name' => 'delete role',
                'guard_name' => 'web',
                'route' => 'role.delete'
            ],
            [
                'name' => 'create permission',
                'guard_name' => 'web',
                'route' => 'permission.create'
            ],
            [
                'name' => 'read permission',
                'guard_name' => 'web',
                'route' => 'permission.read'
            ],
            [
                'name' => 'update permission',
                'guard_name' => 'web',
                'route' => 'permission.update'
            ],
            [
                'name' => 'delete permission',
                'guard_name' => 'web',
                'route' => 'permission.delete'
            ],
        ];

        foreach ($data as $permission) {
            \App\Models\Permission::create($permission);
        }
    }
}
