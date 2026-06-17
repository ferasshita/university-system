<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Super Admin', 'Academic Staff', 'Student'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'api']);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@uimp.test'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'institutional_id' => 'ADMIN001',
                'phone' => null,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('Super Admin');
    }
}
