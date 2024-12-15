<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleOrPermissionMiddleware
{
    public function handle($request, Closure $next, $roleOrPermission)
    {
        if (Auth::guest()) {
            return redirect()->route('dashboard.error.403'); // Redirect to a 403 error page if not logged in
        }

        $user = Auth::user();

        if ($user->hasRole($roleOrPermission) || $user->can($roleOrPermission)) {
            return $next($request);
        }

        // Redirect to a 403 error page if the user doesn't have the required role or permission
        return redirect()->route('dashboard.error.403');
    }
}
