<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'user_access',
            'user_create',
            'user_edit',
            'user_delete',

            'role_access',
            'role_create',
            'role_edit',
            'role_delete',

            'permission_access',
            'permission_create',
            'permission_edit',
            'permission_delete',

            'province_access',
            'province_create',
            'province_edit',
            'province_delete',

            'division_access',
            'division_create',
            'division_edit',
            'division_delete',
            
            'district_access',
            'district_create',
            'district_edit',
            'district_delete',
            
            'tehsil_access',
            'tehsil_create',
            'tehsil_edit',
            'tehsil_delete',
            
            'uncion_counsil_access',
            'uncion_counsil_create',
            'uncion_counsil_edit',
            'uncion_counsil_delete',
            'uncion_counsil_assign_worker',
            
            'household_access',
            'household_create',
            'household_edit',
            'household_delete',
            
            'household_member_access',
            'household_member_create',
            'household_member_edit',
            'household_member_delete',
            
            'assign_polio_worker_access',
            'assign_polio_worker_create',
            'assign_polio_worker_edit',
            'assign_polio_worker_delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
