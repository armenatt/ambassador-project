<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $roles = [
            'ambassador' => [0, 1],
            'admin' => [1]
        ];
        if (!in_array($request->user()->is_admin, $roles[$role])) {
            return response(['error' => 'You don\'t have permissions for this action'], 403);
        }
        return $next($request);
    }
}
