<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'categories',
            'createCategory',
            'editCategory',
            'deleteCategory',
            'showCategory',
            'posts',
            'createPost',
            'editPost',
            'deletePost',
            'showPost',
            'users',
            'createUser',
            'editUser',
            'archivingUser',
            'setPasswordUser',
            'restoreUser',
            'forceDeleteUser',
            'archivedUsers',
            'permissions',
            'createPermission',
            'editPermission',
            'deletePermission',
            'roles',
            'createRole',
            'editRole',
            'deleteRole',
            'contentManagement',
            'accessControl',
            'userManagement',
            'showPermissions',
            'activityLogs',
            'postsLogs',
            'usersLogs',
            'rolesLogs',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
