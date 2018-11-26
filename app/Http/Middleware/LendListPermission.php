<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Sentinel;

class LendListPermission
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $openSource = [
        ];
        $protectOthers = [
        ];
        $method = $request->route()->getActionMethod();
        /** @var User $user */
        $user = Sentinel::getUser();
        if (in_array($method, $openSource)) {
            return $next($request);
        }
        if ($user->hasAccess('lendList')) {
            return $next($request);
        }
        if (in_array($method, $protectOthers) && $user->id == $request->route()->user->id) {
            return $next($request);
        }
        if ($user->hasAccess('lendList.' . $method) || $user->hasAccess('lendList')) {
            return $next($request);
        }

        // Execute this code if the permission check failed
        return redirect()->route('admin.authcode.index')->with('error', "您所造访的页面不存在");
    }
}
