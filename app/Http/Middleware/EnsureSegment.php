<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSegment
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $segment = $request->route('segment');

        if (! $user || ! $segment) {
            return $next($request);
        }

        $query = method_exists($user, 'roles')
            ? $user->roles()->where('is_active', 1)
            : null;

        $hasMatchingRole = $query ? $query->where('route_segment', $segment)->exists() : false;

        if ($hasMatchingRole) {
            return $next($request);
        }

        // If user has an active role but wrong segment, redirect to their first active role segment
        $firstRole = $query ? $query->select('route_segment')->first() : null;
        if ($firstRole && $firstRole->route_segment) {
            return redirect('/' . ltrim($firstRole->route_segment, '/'));
        }

        abort(403);
    }
}

