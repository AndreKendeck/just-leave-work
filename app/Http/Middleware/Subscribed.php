<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Subscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->team->has_active_subscription) {
            return $next($request);
        }
        return response()
            ->json([
                'message' => 'Your organization does not have an active premium subscription',
            ], 403);
    }
}
