<?php

namespace App\Models\Gatedefiner;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\App;


/**
 * Check the Current Application State
 */
trait AssignGate
{
    /**
     * Assigns the Gates Based the current user permissions
     *
     *
     * @return void
     **/
    public function assignGates()
    {
        $authorizedUser = Auth::user()->load(['roles','permissions']);

        $roleIdUser = $authorizedUser->roles->pluck('id')->toArray();

        $permissionIdUser = $authorizedUser->permissions->pluck('id')->toArray();

        $allRoles = Role::select('name', 'id')
                            ->get();
        
        $allPermissions = Permission::select('name', 'id')
                            ->get();

        $rolesOfUser = $allRoles->filter(function ($eachRole) use ($roleIdUser) {
            return in_array($eachRole->id, $roleIdUser);
        });

        $permissionsOfUser = $allPermissions->filter(function ($eachPermission) use ($permissionIdUser) {
            return in_array($eachPermission->id, $permissionIdUser);
        });         


        if($rolesOfUser->isNotempty() || $permissionsOfUser->isNotempty())
        {

            $permissionsOfUser = $permissionsOfUser->pluck('name')->toArray();

            foreach ($rolesOfUser as $key => $eachRole) {
                $permissionsOfRole[$key] = $eachRole->permissions->pluck('name')->toArray();
            }

            $uniquePermissionOnRole = array_unique(array_reduce($permissionsOfRole, 'array_merge', []));

            $allUniqued = array_unique(array_merge($uniquePermissionOnRole, $permissionsOfUser));

            $this->defineGate($allUniqued);
        }
    }

    /**
     * Defines the Array of the Gates
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $gatArray Array of Permisisons
     * @return void
     **/
    public function defineGate(array $allPermissions): void
    {
        foreach ($allPermissions as $allPermission) {
            Gate::define($allPermission, static function () {
                return true;
            });
        }
    }

    /**
     * Check the Current State to map the Permission
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return bool
     **/
    public function checkApplicationState()
    {
        $authorizedUser = Auth::user();
        return ! App::runningInConsole() && ! is_null($authorizedUser);
    }
}