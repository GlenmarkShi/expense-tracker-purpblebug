<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;



class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = Auth::user();
        $users = User::find(1);
        $users->hasRole('admin');
        // if (Auth::check()) {
        //     if  (auth()->check() && auth()->$role->hasRole('production'))

        //     {

        //     }
        // }
        // if (!Auth::check() || !auth()->$user->hasRole($role)) {
        //     return redirect('/dashboard'); // Redirect to a default route
        // }
        // if (Auth::check()) {
        //     // Access the authenticated user and check for the role
        //     if (Auth::user()->hasRole()) {
        //         return $next($request);
        //     }
        // }
      

        return $next($request);
    }
}
