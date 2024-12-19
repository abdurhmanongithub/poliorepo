<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'manage.dashboard',
            'manage.polio-data',
            'manage.custom-sms',
            'manage.afp-data',
            'manage.core-data',
        ];
        $crudPermissions = [
            'regions',
            'zones',
            'woredas',
            'users',
            'roles',
            'community-types',
            'community-members',
        ];

        foreach ($crudPermissions as $crudPermission) {
            Permission::updateOrCreate(['name' => $crudPermission . '.icrud'], ['guard_name' => 'web']);
            Permission::updateOrCreate(['name' => $crudPermission . '.index'], ['guard_name' => 'web']);
            Permission::updateOrCreate(['name' => $crudPermission . '.create'], ['guard_name' => 'web']);
            Permission::updateOrCreate(['name' => $crudPermission . '.update'], ['guard_name' => 'web']);
            Permission::updateOrCreate(['name' => $crudPermission . '.delete'], ['guard_name' => 'web']);
        }
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission], ['guard_name' => 'web']);
        }
    }
}
