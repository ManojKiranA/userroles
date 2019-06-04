<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use App\Models\Gatedefiner\AssignPermission;

class AuthorizationPolicyMiddleware
{
    use AssignPermission;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->assignPermissionToUser();
        return $next($request);
    }
    
}
