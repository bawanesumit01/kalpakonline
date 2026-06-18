<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        if (!auth()->check()) {
            abort(403);
        }

        if (!auth()->user()->hasPermission($permission)) {
            abort(403, 'No permission');
        }

        return $next($request);
    }
}