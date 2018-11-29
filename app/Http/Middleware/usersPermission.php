<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Users\UserInterface;
use Closure;
use Illuminate\Support\Facades\Route;
use Sentinel;

class usersPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $openSource = [
            'showProfile',
            'passwordreset',
            'lockscreen',
            'postLockscreen'
        ];
        $protectOthers = [
            'show'
        ];
        $method = $request->route()->getActionMethod();
        /** @var UserInterface $user */
        $user = Sentinel::getUser();
        if (in_array($method, $openSource)) {
            return $next($request);
        }
        if ($user->hasAccess('users')) {
            return $next($request);
        }
        if (in_array($method, $protectOthers) && $user->id == $request->route()->user->id) {
            return $next($request);
        }
        if ($user->hasAccess('users.' . $method) || $user->hasAccess('users')) {
            return $next($request);
        }
        if (Route::hasMiddlewareGroup('json_api')) {
            return response("您所造访的页面不存在", 404);
        }

        // Execute this code if the permission check failed
        return redirect()->route('admin.authcode.index')->with('error', "您所造访的页面不存在");
    }
}
