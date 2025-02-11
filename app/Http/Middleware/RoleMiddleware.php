<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userRole = auth()->user()->role;

        if (!in_array($userRole, $roles)) {
            abort(403, "Unauthorized action. Your role: $userRole. Allowed roles: " . implode(', ', $roles));
        }

        return $next($request);
    }
}
