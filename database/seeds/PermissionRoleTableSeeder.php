<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use App\Models\Permission;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return void
     */
    public function run()
    {
        $allPermisisons = Permission::pluck('id')->toArray();
        $rootUserRoleName = Config::get('useraccess.rootUserRoleName');
        $rootRole = Role::findByname( $rootUserRoleName);
        $rootRole->permissions()->sync( $allPermisisons);
    }
}