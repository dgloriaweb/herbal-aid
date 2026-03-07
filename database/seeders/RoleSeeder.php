<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['description' => 'Administrator role with full access', 'level' => 1]
        );

        $champion_role = Role::firstOrCreate(
            ['name' => 'Champion'],
            ['description' => 'Champion role with management access', 'level' => 2]
        );

        $user_role = Role::firstOrCreate(
            ['name' => 'User'],
            ['description' => 'Basic user role', 'level' => 3]
        );

        $first_user = User::first();
        if ($first_user && !$first_user->roles()->where('name', 'Admin')->exists()) {
            $first_user->roles()->attach($admin_role->id);
            $this->command->info("Admin role assigned to user: {$first_user->email}");
        }
    }
}
