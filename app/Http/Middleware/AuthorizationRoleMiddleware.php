<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {
                return $this->authorizeAdmin($request, $next);
            } else {
                return $this->authorizeUser($request, $next);
            }
        }

        return response()->json([
            'message' => 'Unauthorized',
        ], 403);
    }

    /**
     * Authorize an admin user to access all routes
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function authorizeAdmin(Request $request, Closure $next)
    {
        // Admin has permission to all routes
        return $next($request);
    }

    /**
     * Authorize a user to access a route
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function authorizeUser(Request $request, Closure $next)
    {
        // Custom logic for authorizing non-admin users

        // Example: Check if the user has permission to access the current route
        if ($this->userHasPermissionForRoute($request)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Check if the user has permission to access the current route
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return bool
     */
    protected function userHasPermissionForRoute(Request $request)
    {
        // Get the name of the current route
        // $routeName = $request->route()->getName();
        // // Exclude routes belonging to the AddressController
        if ($request->route()->controller instanceof \App\Http\Controllers\Role\RoleController) {
            return false;
        }
        // // Define an array of route names corresponding to methods you want to allow
        // $allowedRoutes = [
        //     'controller.get',
        //     'controller.all',
        // ];

        // // Check if the current route is in the array of allowed routes
        // return in_array($routeName, $allowedRoutes);
        // Get the name of the current route
        if ($request->route() && $request->route()->getName()) {

            $routeName = $request->route()->getName();
            $routePrefix = explode('.', $routeName)[0];
            // // Define an array of route names corresponding to methods you want to allow for user
            $allowedUserRoutes = [
                // 'address.create',
                // 'address.update',
                'color.create',
                // 'color.update',
            ];

            // Check if the current route belongs to the ColorController or AddressController
            if (
                $request->route()->controller instanceof \App\Http\Controllers\Color\ColorController 
                // $request->route()->controller instanceof \App\Http\Controllers\Address\AddressController
            ) {
                // If the current route is in the array of allowed routes for users, return true
                return in_array($routeName, $allowedUserRoutes);
            }

            // For other controllers, allow access to 'get' and 'all' routes

            if (in_array($routeName, [$routePrefix.'.get', $routePrefix.'.all'])) {

                return true;
            }
        }
    }
}
