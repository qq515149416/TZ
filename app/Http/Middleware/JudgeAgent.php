<?php

namespace App\Http\Middleware;

use Closure;

use Jenssegers\Agent\Facades\Agent;

class JudgeAgent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Agent::isMobile() && strpos($request->path(),"wap")===false) {
            return redirect("/wap/".str_replace("wap/","",$request->path()));
        }
        return $next($request);
    }
}
