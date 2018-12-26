<?php

namespace App\Http\Middleware;

use App\Models\Task;
use App\Traits\WhitelistValidation;
use App\User;
use Closure;
use Sentinel;

class SentinelAdmin
{
    use WhitelistValidation;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        if (!$user = Sentinel::check()) {
            return redirect(route('signin'))->with('info', 'You must be logged in!');
        }
        if (!$this->isAllowIP($user, $request->getClientIp())) {
            Sentinel::logout();

            return redirect(route('login'))->with('error', 'Not Allowed from IP Address:' . $request->getClientIp());
        }
        $tasksCount = Task::query()->where('user_id', Sentinel::getUser()->getUserId())->count();
        $request->attributes->add(['tasks_count' => $tasksCount]);

        return $next($request);
    }
}
