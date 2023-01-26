<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActiveAccount
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->status !== 'active') {
            return $request->expectsJson()
                    ? response()->json(['message' => 'your account is in '. $request->user()->status . ' status'], 403)
                    : abort(403, 'Your account is '. $request->user()->status);
        }

        return $next($request);
    }
}
