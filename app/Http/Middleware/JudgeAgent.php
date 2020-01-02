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
        if(!$request->has('ignorance')){
            if(Agent::isMobile() && strpos($request->path(),"wap")===false) {
                $arr = explode('/',$request->path());
                if ($arr[0] == 'detail') {//如果是新闻详细页
                    $last = count($arr)-1;
                    return redirect("/wap/detail/new/".$arr[$last]);
                }elseif ($arr[0] == 'help') {//如果是帮助详细页
                    $last = count($arr)-1;
                    return redirect("/wap/help_articles/".$arr[$last]);
                }else{
                    return redirect("/wap/".str_replace("wap/","",$request->path()));
                } 
            }
        };
        return $next($request);
    }
}
