<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CustomGuest
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
        // 로그인 되어있다면 수강 메인페이지로 이동
        if (Auth::user()) {
            return redirect()->route('lecture.mainView');
        }

        return $next($request);
    }
}
