<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthentication
{
    public function handle($request, Closure $next)
    {
        // get bearer token
        $token = $request->bearerToken();

        if ($token == env('USER_TOKEN')) {
            return $next($request);
        }

        return response([
            'error' => [
                'message' => 'Unauthenticated',
            ],
        ], 403);
    }
}
