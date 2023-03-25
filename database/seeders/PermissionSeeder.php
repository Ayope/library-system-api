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
        $user = Role::create(['name' => 'User']);

        $userPermissions = [
            'ingredient_create',
            'meal_create',
            'meal_edit',
            'meal_show',
            'meal_delete',
            'meal_access',
            'comment_create',
            'comment_edit',
            'comment_show',
            'comment_delete',
            'comment_access',
        ];

        foreach ($userPermissions as $permission)   {
            $user->givePermissionTo($permission);
        }
    }
}
