<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class tradeLogPermission
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
            'index',
            'data',
            'dataInit',
            'feeData',
            'showFeeInfo',
            'callNotify',
            'showInfo',
            'orderTradeInfo'
        ];
        $protectOthers = [
        ];
        $method = $request->route()->getActionMethod();
        $user = Sentinel::getUser();
        if (in_array($method, $openSource)) {
            return $next($request);
        }
        if ($user->hasAccess('logQuery')) {
            return $next($request);
        }
        if (in_array($method, $protectOthers) && $user->id == $request->route()->user->id) {
            return $next($request);
        }
        if ($user->hasAccess('logQuery.' . $method)) {
            return $next($request);
        }

        // Execute this code if the permission check failed
        return redirect()->route('admin.authcode.index')->with('error', "您所造访的页面不存在");
    }
}
