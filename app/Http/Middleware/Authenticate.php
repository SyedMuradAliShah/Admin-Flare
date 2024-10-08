<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Override;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as AuthenticationMiddleware;

class Authenticate extends AuthenticationMiddleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    #[Override]
    protected function redirectTo(Request $request): ?string
    {

        // Check if the current route is under the 'user' prefix and the guard is 'web'
        if ($request->routeIs('user.*')) {
            return $request->expectsJson() ? null : route('home');
        }

        // Check if the current route is under the 'admin' prefix and the guard is 'admin'
        if ($request->routeIs('admin.*')) {
            return $request->expectsJson() ? null : route('admin.login');
        }

        return null;
    }
}
