<?php
/**
 * 检测是否登录 中间件
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class NewCheckLogin
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
        if (!Auth::check()) {
           return redirect('/');
        }
        return $next($request);
    }
}
