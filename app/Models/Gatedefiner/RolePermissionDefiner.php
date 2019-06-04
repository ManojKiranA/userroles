<?php

namespace App\Models\Gatedefiner;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

/**
 * Defines the Permission Via Role
 */
trait RolePermissionDefiner
{
    /**
     * Returns the root role name of the application
     *
     * @return string
     **/
    public function rootRole()
    {
        return Config::get('useraccess.rootUserRoleName');
    }
    
    /**
     * Gets all the permisison names that is assigned via
     * role
     *
     * @return array
     **/
    public function permissionViaRole($rolesOfUser): array
    {
        $permissionsRole = [];

        if ($rolesOfUser->isNotEmpty()) {
            foreach ($rolesOfUser as  $userRole) {
                $permisisonOnRole = $userRole->permissions->pluck('name')->toArray();
                if ($permisisonOnRole !== []) {
                    $permissionsRole[] =  $permisisonOnRole;
                }
            }
            return $permissionsRole;
        }
    }

    /**
     * Get All the Roles Of the User
     *
     * It Gets All the Roles of User
     * and plucks id and Name
     *
     * @param string $selectFiled The Filed Need to Sele
     * @return Illuminate\Database\Eloquent\Collection
     **/
    public function assignedRolesToUser()
    {
        $roleIdsOfUser = Auth::user()->roles->pluck('id')->toArray();
        $rolesOfUser = Role::with('permissions')
                        ->select('name','id')
                        ->get()
                        ->filter(function($eachRole) use ($roleIdsOfUser)
                        {
                            return in_array($eachRole->id,$roleIdsOfUser);
                        });

        return $rolesOfUser;
    }
}
