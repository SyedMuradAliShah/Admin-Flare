<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request):Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the route is for students and the web guard is authenticated
        if ($request->routeIs('user.login') && Auth::guard('web')->check()) {
            return redirect(route('user.dashboard'));
        }

        // If the route is for admin and the admin guard is authenticated
        if ($request->routeIs('admin.login') && Auth::guard('admin')->check()) {
            return redirect(route('admin.dashboard'));
        }

        return $next($request);
    }
}
