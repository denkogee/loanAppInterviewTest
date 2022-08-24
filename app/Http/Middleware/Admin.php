<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
		if(Auth::User()->role_id != '1'){
			if( ! $request->ajax()){
			   return back()->with('error',_lang('Permission denied !'));
			}else{
				return new Response('<h5 class="text-center red">'._lang('Permission denied !').'</h5>');
			}
		}

        return $next($request);
    }
}
