<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        if (is_null(auth()->user())) {
            return response()->json([
                'error' => 'You are not logged in'
            ], 403);
        }

        return $next($request);
    }
}
