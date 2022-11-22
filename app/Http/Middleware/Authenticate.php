<?php

namespace App\Http\Middleware;

use App\Models\Tokens;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return string|null
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $token = $request->bearerToken();

        $checkToken = Tokens::where([
            ['token', $token],
            ['expires_at', '>=', now()]
        ]);

        if ( !$checkToken->first() ) return response()->json([
            'message' => 'Invalid token.'
        ], 401);

        if ( !$request->isMethod('GET') ) {
            if ( !$request->isJson() ) return response()->json([
                'message' => 'Invalid input.'
            ], 401);
        }

        $checkToken->update([
            'last_used_at' => now(),
            'ip' => $request->getClientIp()
        ]);

        return $next($request);
    }
}
