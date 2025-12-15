<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Dashboard
        Menu::create([
            'title' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'bi bi-speedometer2',
            'order' => 1,
        ]);

        // Menu Builder
        Menu::create([
            'title' => 'Menu Builder',
            'route' => 'admin.menus.index',
            'icon' => 'bi bi-list',
            'order' => 2,
        ]);

        // User Management
        Menu::create([
            'title' => 'User Management',
            'route' => 'admin.users.index',
            'icon' => 'bi bi-people',
            'order' => 3,
        ]);

        // Roles & Permissions
        $rolePermission = Menu::create([
            'title' => 'Roles & Permissions',
            'icon' => 'bi bi-shield-lock',
            'order' => 4,
        ]);

        Menu::create([
            'title' => 'Roles',
            'route' => 'admin.roles.index',
            'parent_id' => $rolePermission->id,
            'order' => 1,
        ]);

        Menu::create([
            'title' => 'Permissions',
            'route' => 'admin.permissions.index',
            'parent_id' => $rolePermission->id,
            'order' => 2,
        ]);

        // CRUD Builder
        Menu::create([
            'title' => 'CRUD Builder',
            'route' => 'crud-builder.index',
            'icon' => 'bi bi-tools',
            'order' => 5,
        ]);

        // Theme Settings
        Menu::create([
            'title' => 'Theme Settings',
            'route' => 'admin.theme.index',
            'icon' => 'bi bi-palette',
            'order' => 6,
        ]);

        // General Settings
        Menu::create([
            'title' => 'Settings',
            'route' => 'admin.settings.index',
            'icon' => 'bi bi-gear',
            'order' => 7,
        ]);
    }
}
