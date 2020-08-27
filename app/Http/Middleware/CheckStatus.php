<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckStatus
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        //If the status is not approved redirect to login 
        if(Auth::check() && Auth::user()->active == false){
            Auth::logout();
            return redirect()->back()
                ->with('message', \GeneralHelper::formatMessage('Akun anda belum aktif. Silahkan hubungi Admin - 085211111 !', 'danger'));
        }

        return $response;
    }
}
