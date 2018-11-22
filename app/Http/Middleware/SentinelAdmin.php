<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Sentinel;

class SentinelAdmin
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
        if (!Sentinel::check()) {
            return redirect('admin/signin')->with('info', 'You must be logged in!');
        }
        $tasksCount = Task::query()->where('user_id', Sentinel::getUser()->getUserId())->count();
        $request->attributes->add(['tasks_count' => $tasksCount]);

        return $next($request);
    }
}
