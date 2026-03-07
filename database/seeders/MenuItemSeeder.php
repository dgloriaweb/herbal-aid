<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $manage = MenuItem::create([
            'key' => 'manage',
            'name' => 'Manage',
            'description' => 'Management area',
            'path' => '/manage',
            'parent_id' => null,
            'order' => 1,
        ]);

        $setup = MenuItem::create([
            'key' => 'setup',
            'name' => 'Setup',
            'description' => 'Setup and configuration',
            'path' => '/manage/setup',
            'parent_id' => $manage->id,
            'order' => 1,
        ]);

        MenuItem::create([
            'key' => 'languages',
            'name' => 'Languages',
            'description' => 'Manage system languages',
            'path' => '/manage/setup/languages',
            'parent_id' => $setup->id,
            'order' => 1,
        ]);

        MenuItem::create([
            'key' => 'admin',
            'name' => 'Admin Area',
            'description' => 'Administrator area',
            'path' => '/admin',
            'parent_id' => null,
            'order' => 2,
        ]);
    }
}
