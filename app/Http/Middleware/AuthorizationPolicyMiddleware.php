<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class AuthorizationPolicyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this-> setPermissionToRole();
        return $next($request);
    }

    /**
     * Set the Permission to user via role
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     **/
    public function setPermissionToRole()
    {
        $authorizedUser = Auth::user();

        if ($this->checkApplicationState()) {

            $rolesOfUser = Role::with('permissions')
                                ->whereIn('id', $authorizedUser->roles->pluck('id'))
                                ->get();

            $permissionsOfUser = Permission::with('users')
                                            ->whereIn('id', $authorizedUser->permissions->pluck('id'))
                                            ->pluck('name');

            $permissionsRole = $specialAccess = [];

            if ($rolesOfUser->isNotEmpty()) 
            {
                foreach ($rolesOfUser as  $userRole) 
                {
                    if ($userRole->permissions->pluck( 'name')->toArray() !== []) 
                    {
                        $permissionsRole[] =  $userRole->permissions->pluck( 'name')->toArray();
                    }
                }
            }

            $specialAccess = $permissionsOfUser->toArray();
            $permissionsRole = array_unique(array_reduce($permissionsRole, 'array_merge', []));
            $uniquePermission = array_unique(array_merge( $specialAccess, $permissionsRole));

            if (isset( $uniquePermission)) 
            {
                foreach ( $uniquePermission as $permissionName) {
                    Gate::define($permissionName, function () {
                        return true;
                    });
                }
            }
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
        return !App::runningInConsole() && !is_null($authorizedUser);
    }

}
