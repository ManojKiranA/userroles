<?php

namespace App\Models\Gatedefiner;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;

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
            if(! Session::has('_authUser'))
            {
                $this->assignPermissionOnFirstTime($authorizedUser);
            }else {
                $this->assignPermisisonFromSession();
            }
        }       
    }

    /**
     * Assign the Permisison from the session
     *
     *
     * @param mixed $authorizedUser
     * @return void
     **/
    public function assignPermisisonFromSession()
    {
        $permissionsOfRole = Session::get('_authUserPermissionViaRole',[]);

        $permissionsOfUser = Session::get('_authUserDirectPermision',[]);
        
        $uniquePermissionOnRole = array_unique(array_reduce($permissionsOfRole, 'array_merge', []));

        $allUniqued = array_unique(array_merge($uniquePermissionOnRole, $permissionsOfUser));

        $this->defineGate($allUniqued);
    }
 

    /**
     * Assign the Permisison on the first Time Login
     *
     *
     * @param mixed $authorizedUser
     * @return void
     **/
    public function assignPermissionOnFirstTime($authorizedUser)
    {
        $this->removeSession();

        Session::put('_authUser', array_merge(Arr::only($authorizedUser->getOriginal(), ['id','email','name']), ['logged_in_at' => now()]));
        Session::put('_authUserLoggedIn', ['logged_in_at' => now()]);
        
        $relationCallBack = function ($query) {
            $query->select('id', 'name');
        };

        $roleIdUser = $authorizedUser->roles->pluck('id')->toArray();
        
        $permissionIdUser = $authorizedUser->permissions->pluck('id')->toArray();

        $rolesOfUser = Role::with(['permissions' => $relationCallBack,'users' => $relationCallBack])
                        ->select('name', 'id')
                        ->whereIn('id', $roleIdUser)
                        ->get();

        if ($permissionIdUser !== []) {
            $permissionsOfUser = Permission::with(['roles' => $relationCallBack,'users' => $relationCallBack])
                            ->select('name', 'id')
                            ->whereIn('id', $permissionIdUser)
                            ->get();
        } else {
            $permissionsOfUser =   new Collection();
        }

            if ($rolesOfUser->isNotempty() || $permissionsOfUser->isNotempty()) {
                $permissionsOfUser = $permissionsOfUser->pluck('name')->toArray();

                foreach ($rolesOfUser as $key => $eachUserRole) {
                    $erolPerm = $eachUserRole->permissions->pluck('name')->toArray();
                    if ($erolPerm !== []) {
                        $permissionsOfRole[$key] = $erolPerm;
                    }
                }
                $uniquePermissionOnRole = array_unique(array_reduce($permissionsOfRole, 'array_merge', []));

                $allUniqued = array_unique(array_merge($uniquePermissionOnRole, $permissionsOfUser));

                Session::put('_authUserRole', $rolesOfUser->pluck('name')->toArray());
                Session::put('_authUserPermissionViaRole', $permissionsOfRole);
                Session::put('_authUserDirectPermision', $permissionsOfUser);
            }

            $this->defineGate($allUniqued);
    }

    /**
     * Forget all the Session
     *
     * @return void
     **/
    public function removeSession()
    {
        Session::forget([
                '_authUser',
                '_authUserLoggedIn',
                '_authUserRole',
                '_authUserPermissionViaRole',
                '_authUserDirectPermision'
                        ]);
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