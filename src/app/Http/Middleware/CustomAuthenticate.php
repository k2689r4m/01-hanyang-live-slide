<?php

namespace App\Http\Middleware;

use App\Lecture;
use App\User;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CustomAuthenticate
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
       $user = Auth::user();

        // 로그인 되어있지 않다면 로그인 페이지로 이동.
        if (!$user) {
            return redirect()->route('user.loginView');
        }

        if ($request['lecture_id']) {
            $member = null;
            $student = null;
            $professor = null;
            $lecture = Lecture::where('id', $request['lecture_id'])->get();//find($request['lecture_id']);

            if (count($lecture) > 0) {
                $student = $lecture[0]->members()
                    ->where('user_id', $user->id)
                    ->first();

                $professor = $lecture->where('user_id', $user->id)
                    ->first();
            }

            // 교수, 학생이 아니라면 이전 페이지로 이동
            if ((!$student && !$professor) || !$lecture) {
                return redirect()->back();
            } else if ($professor) {
                $request->merge(["isOwn" => true]);
            } else if ($student) {
                $request->merge(["isOwn" => false]);
            }

            $request->merge(["member" => $student]);
            $request->merge(["lecture" => $professor]);
        }

        $request->merge(["user" => $user]);

        return $next($request);
    }
}
