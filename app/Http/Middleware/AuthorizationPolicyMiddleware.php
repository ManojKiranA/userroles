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
        $user = Auth::user();
       
        if (!app()->runningInConsole() && $user) 
        {
            $roles = Role::with('permissions')->get();

            if($roles->isNotEmpty())
            {
                foreach ($roles as $role) {
                    foreach ($role->permissions as $permissions) {
                        $permissionsArray[$permissions->name][] = $role->id;
                   }
                }

                foreach ($permissionsArray as $title => $roles) {
                Gate::define($title, function (\App\Models\User $user) use ($roles) {
                    return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
                });
                }
            }
            
            
            
            
        }
        return $next($request);
    }
}