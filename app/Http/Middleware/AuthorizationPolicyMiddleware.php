<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Gatedefiner\AssignGate;
use Illuminate\Support\Facades\Log;

class AuthorizationPolicyMiddleware
{
    use AssignGate;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->assignGates();
        return $next($request);
    }
}
