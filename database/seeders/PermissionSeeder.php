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
            'permissions.index',
            'permissions.create',
            'permissions.store',
            'permissions.show',
            'permissions.edit',
            'permissions.update',
            'permissions.destroy',
            'dashboard',
            'user.index',
            'user.create',
            'user.store',

        ];

        // $role = Role::where('name', 'admin')->first();

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission], ['guard_name' => 'web']);
            // $role->givePermissionTo($permission);
        }    }
}
