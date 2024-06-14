<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class userxMiddlewar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        if($path=='user-account'){
            if(session('userSession')){
                return redirect('/');
            }else{
              return $next($request);
            }
        } if($path=='card-detail'){
            if(!session('userSession')){
                return redirect('/user-account');
            }else{
              return $next($request);
            }
        }
        return $next($request);
    }
}
