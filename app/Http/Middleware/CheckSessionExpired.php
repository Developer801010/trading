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
            $lastActive = $request->session()->get('last_active');
            $currentTime = time();
            // dd($currentTime - $lastActive);
             // Check if 1 hour (3600 seconds) has passed since last activity
            if ($currentTime - $lastActive > 60) {
                // Perform logout and redirect
                Auth::logout();
                $request->session()->flash('message', 'Session expired due to inactivity. Please login again.');
                return redirect('login');
            }
        }
        
         // Update last active timestamp
        $request->session()->put('last_active', time());
        return $next($request);
    }
}
