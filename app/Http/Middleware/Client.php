<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Client
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next) {
        return auth()->user();
        if (Auth::User()->user_type != 'customer') {
            if (!$request->ajax()) {
                return back()->with('error', _lang('Permission denied !'));
            } else {
                return new Response('<h5 class="text-center red">' . _lang('Permission denied !') . '</h5>');
            }
        }

        if (get_option('mobile_verification') == 'enabled' && Auth::User()->sms_verified_at == null) {
            return redirect()->route('profile.mobile_verification');
        }

        if (get_option('enable_kyc') == 'yes' && Auth::User()->document_verified_at == null) {
            return redirect()->route('profile.document_verification');
        }

        return $next($request);
    }
}
