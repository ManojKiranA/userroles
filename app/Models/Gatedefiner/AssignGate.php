<?php

namespace App\Models\Gatedefiner;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Collection;


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
        $authorizedUser = Auth::user();

        if(! App::runningInConsole() && ! is_null($authorizedUser))
        {
            $relationCallBack = function ($query) {
                $query->select('id', 'name');
            };

            $roleIdUser = $authorizedUser->roles->pluck('id')->toArray();

            $permissionIdUser = $authorizedUser->permissions->pluck('id')->toArray();

            $rolesOfUser = Role::with(['permissions' => $relationCallBack,'users' => $relationCallBack])
                            ->select('name', 'id')
                            ->whereIn('id',$roleIdUser)
                            ->get();

            if($permissionIdUser !== [])
            {
                $permissionsOfUser = Permission::with(['roles' => $relationCallBack,'users' => $relationCallBack])
                                ->select('name', 'id')
                                ->whereIn('id',$permissionIdUser)
                                ->get();
            }else
            {
                $permissionsOfUser =   new Collection();
            }


            if ($rolesOfUser->isNotempty() || $permissionsOfUser->isNotempty() ) {
                $permissionsOfUser = $permissionsOfUser->pluck('name')->toArray();

                foreach ($rolesOfUser as $key => $eachUserRole) {
                    $permissionsOfRole[$key] = $eachUserRole->permissions->pluck('name')->toArray();
                }

                $uniquePermissionOnRole = array_unique(array_reduce($permissionsOfRole, 'array_merge', []));

                $allUniqued = array_unique(array_merge($uniquePermissionOnRole, $permissionsOfUser));

                $this->defineGate($allUniqued);
            }
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

}