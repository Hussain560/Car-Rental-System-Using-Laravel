<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check authentication using the admin guard
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }
        
        $admin = Auth::guard('admin')->user();
        
        // Check if the admin has manager role
        if (!$admin->isManager()) {
            // Redirect to a 403 error page or dashboard with an error message
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this page.');
        }
        
        return $next($request);
    }
}