<?php

namespace App\Http\Middleware;

use App\Classes;
use App\Lecture;
use App\Slides;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Study
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
        $userId = Auth::id();
        $user = $userId ? User::find($userId) : [];

        // 로그인 되어있지 않다면 로그인 페이지로 이동.
        if (!$userId || !$user) {
            return redirect()->route('user.loginView');
        }

        if ($request['user_url']) {
            $slide = true;
            if ($request['slide_id']) {
                $slide = Slides::find($request['slide_id']);
            }
            $class = Classes::where('user_url', $request['user_url'])->first();
            if (!$class) {
                return redirect()->back();
            }

            if (!$slide) {
                return redirect()->back();
            }
            else {
                if ($slide != true && $slide->class_id != $class->id) {
                    return redirect()->back();
                }
            }

            $lecture = $class->lecture()->first();

            if (!$lecture) {
                return redirect()->back();
            }

            if ($lecture->user_id === $user->id) {
                $request->merge(['isOwn' => true]);
            }
            else {
                $member = $lecture->members()->where('user_id', $user->id)->first();

                if ($member) {
                    $request->merge(['isOwn' => false]);
                }
                else {
                    return redirect()->route('lecture.main');
                }
            }

            $request->merge(['lecture_id' => $lecture->id]);
            $request->merge(['class_id' => $class->id]);

            return $next($request);
        }
        else {
            return redirect()->back();
        }
    }
}
