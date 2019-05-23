<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
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
        $this-> setPermissionToUser();
        return $next($request);
    }

    /**
     * Sets all the Permission that is granted to the specific User
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     **/
    public function setPermissionToUser()
    {
        $authorizedUser = Auth::user();

        if ($this->checkApplicationState()) 
        {
            $permissionToUser = [];
            
            if ($authorizedUser->permissions->isNotEmpty()) 
            {
                $permissionToUser[] = $authorizedUser->permissions->pluck('name')->toArray();
            }

            $uniqued =  array_keys(array_flip(Arr::collapse($permissionToUser)));

            $arrayCount = count($uniqued);

            if ($arrayCount !== 0) 
            {
                foreach ($uniqued as $permissionName) 
                {
                    Gate::define($permissionName, function () {
                        return true;
                    });
                }
            }
        }
    }

    /**
     * Set the Permission to user via role
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     **/
    public function setPermissionToRole()
    {
        $authorizedUser = Auth::user();

        if ($this->checkApplicationState()) 
        {
            $userPermissionViaRole = [];

            $rolesOfUser = $authorizedUser->roles;

            if ($rolesOfUser->isNotEmpty()) 
            {
                foreach ($rolesOfUser as  $userRole) 
                {
                    $roleWithPermisison = $userRole->load('permissions');
                    $userPermissionViaRole[] =  $roleWithPermisison->permissions->pluck('name')->toArray();
                }
            }

            $uniqued =  array_keys(array_flip(Arr::collapse($userPermissionViaRole)));

            $arrayCount = count($uniqued);

            if ($arrayCount !== 0) {
                foreach ($uniqued as $permissionName) {
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
