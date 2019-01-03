<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Sentinel;

class SystemSettingPermission
{
    /**
     * @param $request
     * @param Closure $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $method = $request->route()->getActionMethod();
        /** @var User $user */
        $user = Sentinel::getUser();
        if ($user->hasAccess('systemSetting.' . $method) || $user->hasAccess('systemSetting')) {
            return $next($request);
        }

        return redirect(route('admin.authcode.index'))->with('error', "您所造访的页面不存在");
    }
}
