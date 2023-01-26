<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    // handle request
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if(!$request->user()->hasAnyRole(...$roles)) {
            return $request->expectsJson()
                    ? response()->json(['message' => 'unauthorized resource'], 403)
                    : abort(403, 'You are not authorized to access this page');
        }
        return $next($request);
    }
}
