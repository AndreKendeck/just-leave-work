<?php

namespace App\Http\Middleware;

use Closure;

class PreventBannedOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->organization->is_banned) {
            return abort(403, 'This Organization is banned');
        }
        return $next($request);
    }
}
