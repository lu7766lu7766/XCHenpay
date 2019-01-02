<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SentinelAuthorize
{
    use AuthorizesRequests;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|object $ability
     * @param array $arguments
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function handle($request, Closure $next, $ability, ...$arguments)
    {
        $user = \Sentinel::getUser();
        $this->authorizeForUser($user, $ability, $arguments);

        return $next($request);
    }
}
