<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use App\Models\Role;
use App\Models\User;


class RoleUserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $rootRoleName = Config::get('useraccess.rootUserRoleName');
        $adminRoleName = 'ADMIN';

        $rootRoleObject = Role::findByname($rootRoleName);
        $adminRoleObject = Role::findByname($adminRoleName);

        $rootUserEmail = Config::get('useraccess.seeders.usersTable.superUserData.email');
        $rootUserObject = User::findByemail($rootUserEmail);
        $rootUserObject->roles()->sync([$rootRoleObject->id]);

        $adminUserEmail = 'admin@admin.com';
        $adminUserObject = User::findByemail($adminUserEmail);
        $adminUserObject->roles()->sync([$adminRoleObject->id]);       
        
    }
}