<?php
namespace App\Http\Middleware;

use Closure;
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
