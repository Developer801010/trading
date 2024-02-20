<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SanctumRolePermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if($token){
            // Authenticate user				
            $user = Auth::guard('sanctum')->user();
                // Get user's role and permissions
            $role = $user->roles()->with('permissions')->first(); // Assuming user has only one role
        
            $roleName = null;
            $permissions = [];
    
            if ($role) {
                    $roleName = $role->name;
                    $permissions = $role->permissions->pluck('name')->toArray();
            }
                        
            if ($user) {
                // User is authenticated, you can access user information here
                // Check if user has the required permission or is an admin
                if ($user->hasRole('admin')) {
                    // User is admin, allow access
                    return $next($request);
                }
    
                // User is not admin, deny access
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized. Insufficient permissions.',
                ], 403);
            }
    
            // User is not authenticated, return error
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }	
    }
}
