<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() && $request->session()->has('last_active')) {
            $request->session()->flash('message', 'Session expired. Please login again.');            
            return redirect('login');
        }

        $request->session()->put('last_active', time());
        return $next($request);
    }
}
