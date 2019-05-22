<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

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
        $this-> mapPermissions();
        return $next($request);
    }

    /**
     * Assiggn the permission to the roles and users
     *
     *
     * @return void
     **/
    public function mapPermissions()
    {
        $user = Auth::user();

        if (!app()->runningInConsole() && !is_null($user)) 
        {
            $roles = Role::with('permissions')->get();

            if ($roles->isNotEmpty()) {
                foreach ($roles as $role) {
                    foreach ($role->permissions as $permissions) {
                        $permissionsArray[$permissions->name][] = $role->id;
                    }
                }
                
                foreach ($permissionsArray as $title => $roleId) {
                    
                    Gate::define($title, function (\App\Models\User $user) use ( $roleId) {
                        return count(array_intersect($user->roles->pluck('id')->toArray(), $roleId)) > 0;
                    });
                }
            }
        }
    }
}
