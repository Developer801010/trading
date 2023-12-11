<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'web')
    {
        if (!$request->hasValidSignature()) {
            switch ($guard) {
                case 'sanctum':
                    $redirect_url = '/api/unauthorized';
                    break;
                case 'admin':
                    $redirect_url = '/admin/login';
                    break;
                case 'web':
                    $redirect_url = '/login';
                default:
                    $redirect_url = '/login';
                    break;
            }
            if (!Auth::guard($guard)->check()) {
                return redirect($redirect_url);
            }
        }

        return $next($request);
    }
}
