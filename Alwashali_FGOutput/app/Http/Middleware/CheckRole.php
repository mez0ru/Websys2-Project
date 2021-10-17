<?php

namespace App\Http\Middleware;

use Closure;
use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        switch ($role) {
            case 'candidate':
                if (Auth::user()->role !== Roles::CANDIDATE)
                    abort(403);
                break;
            case 'hirer':
                if (Auth::user()->role !== Roles::HIRER)
                    abort(403);
                break;
            
            default:
                abort(403);
                break;
        }

        return $next($request);
    }
}
