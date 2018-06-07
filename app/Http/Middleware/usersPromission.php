<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class usersPromission
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
        $openSource = array(
            'showProfile',
            'editProfile',
            'passwordreset',
        );
        $protectOthers = array(
            'show',
            'edit',
            'update',
        );

        $method = $request->route()->getActionMethod();
        $user = Sentinel::getUser();

        if(in_array($method, $openSource))
            return $next($request);

        if($user->hasAccess('users'))
            return $next($request);

        if(in_array($method, $protectOthers) && $user->id == $request->route()->user->id)
            return $next($request);

        if ($user->hasAccess('users.'.$method)|| $user->hasAccess('users'))
            return $next($request);

        // Execute this code if the permission check failed
        return redirect()->route('admin.dashboard')->with('error', "premission denied.");

    }
}
