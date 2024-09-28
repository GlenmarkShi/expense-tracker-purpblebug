<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        $admin->assignRole($adminRole);

        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage expense categories']);
        Permission::create(['name' => 'manage expenses']);
        Permission::create(['name' => 'access user management']);

        $adminRole->givePermissionTo([
            'manage users',
            'manage expense categories',
            'manage expenses',
            'access user management',
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),

        ]);
        $user->assignRole($userRole);

        Permission::create(['name' => 'change password']);
        Permission::create(['name' => 'manage own expenses']);

        // Assign permissions to User role
        $userRole->givePermissionTo([
            'change password',
            'manage own expenses',
        ]);
    }
}
