<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SearchPermission
{
    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $openSource = [
        ];
        $protectOthers = [
        ];
        $method = $request->route()->getActionMethod();
        $user = Sentinel::getUser();
        if (in_array($method, $openSource)) {
            return $next($request);
        }
        if ($user->hasAccess('search')) {
            return $next($request);
        }
        if (in_array($method, $protectOthers) && $user->id == $request->route()->user->id) {
            return $next($request);
        }
        if ($user->hasAccess('search.' . $method) || $user->hasAccess('search')) {
            return $next($request);
        }
        // Execute this code if the permission check failed
        //return redirect()->route('admin.authcode.index')->with('error', "您所造访的页面不存在");
        return response()->json(['code' => 404, 'data' => [], 'message' => "您所造访的页面不存在"], 404);
    }
}
