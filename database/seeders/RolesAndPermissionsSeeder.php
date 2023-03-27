<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [

            'view_books',
            'book_create',
            'book_edit',
            'book_show',
            'book_delete',

            'view_users', // with role
            'view_roles',
            'role_create',
            'role_edit',
            'role_show',
            'role_delete',
            'edit_user_role',

            'view_genres',
            'genre_create',
            'genre_edit',
            'genre_show',
            'genre_delete',
            'genre_filter',

        ];

        foreach ($permissions as $permission)   {
            Permission::create([
                'name' => $permission
            ]);
        }

        // Create roles and assign it permissions to it

        Role::create(['name' => 'viewer'])
            ->givePermissionTo(['view_books' , 'book_show' , 'genre_filter']);

        Role::create(['name' => 'receptionist'])
            ->givePermissionTo(['view_books', 'book_create', 'book_edit', 'book_show', 'book_delete', 'genre_filter']);

        Role::create(['name' => 'admin'])
            ->givePermissionTo(['view_genres', 'genre_create', 'genre_edit', 'genre_show', 'genre_delete', 'genre_filter',
                                'view_books', 'book_edit', 'book_show', 'book_delete',
                                'view_users', 'view_roles', 'role_create', 'role_edit', 'role_show', 'role_delete', 'edit_user_role']);

    }

}

