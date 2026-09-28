<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Lecture;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    function mainView(Request $request, $lecture_id) {
        $classes = Classes::where('lecture_id', $lecture_id)->orderBy('active_start_date', 'desc')->paginate(10);
        $member_count = Lecture::find($lecture_id)->members()->count();
        $lecture = Lecture::find($lecture_id);

        $lectureProgress = floor(strtotime(now()) - strtotime($lecture->lecture_start_date) / 60 / 60 / 24 / 7);

        return view('class.main', ['lecture_id' => $lecture_id, 'classes' => $classes, 'member_count' => $member_count, 'lecture' => $lecture]);
    }

    function writeView(Request $request, $lecture_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        return view('class.write', ['lecture_id' => $lecture_id]);
    }

    function write(Request $request, $lecture_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $_time = date_create($request->active_start_date.' '.$request->period_start_hours.':'.$request->period_start_minutes.':00');
        $request->active_start_date = date_format($_time, 'Y-m-d H:i');
        $_time = date_create($request->active_end_date.' '.$request->period_end_hours.':'.$request->period_end_minutes.':00');
        $request->active_end_date = date_format($_time, 'Y-m-d H:i');
        $_time = date_create($request->record_start_date.' '.$request->record_start_hours.':'.$request->record_start_minutes.':00');
        $request->record_start_date = date_format($_time, 'Y-m-d H:i');
        $_time = date_create($request->record_end_date.' '.$request->record_end_hours.':'.$request->record_end_minutes.':00');
        $request->record_end_date = date_format($_time, 'Y-m-d H:i');

        $request->validate([
            'class_name' => ['required', 'string', 'max:255'],
            'user_url' => ['required', 'regex:/^[A-Za-z0-9+]*$/', 'max:255', 'unique:classes'],
            'active_always' => 'required|in:0,1,2',
            'active_start_date' => ['required', 'date_format:Y-m-d'],
            'active_end_date' => ['required', 'date_format:Y-m-d', 'after:active_start_date'],
            'record_always' => 'required|in:0,1,2',
            'record_start_date' => ['required', 'date_format:Y-m-d'],
            'record_end_date' => ['required', 'date_format:Y-m-d', 'after:active_start_date', 'after:record_start_date'],
        ]);


        $class = Classes::create([
            'name' => $request['class_name'],
            'user_url' => $request['user_url'],
            'active_always' => $request['active_always'],
            'active_start_date' => $request['active_start_date'],
            'active_end_date' => $request['active_end_date'],
            'record_always' => $request['record_always'],
            'record_start_date' => $request['record_start_date'],
            'record_end_date' => $request['record_end_date'],
            'active' => false,
            'lecture_id' => $lecture_id,
            'user_id' => $request['user']->id,
        ]);



        return redirect()->route('slide.writeView',
            [
                'lecture_id' => $lecture_id,
                'class_id' => $class->id,
            ]);
//        return redirect()->route('class.mainView', ['lecture_id' => $lecture_id]);
    }

    function editView(Request $request, $lecture_id, $class_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $class = Classes::find($class_id);

        if (!$class || $class->active) {
            return redirect()->back();
        }

        $class->active_start_date =  explode(" ", $class->active_start_date)[0];
        $class->active_end_date =  explode(" ", $class->active_end_date)[0];
        $class->record_start_date =  explode(" ", $class->record_start_date)[0];
        $class->record_end_date =  explode(" ", $class->record_end_date)[0];

        return view('class.edit', ['class' => $class, 'lecture_id' => $lecture_id, 'class_id' => $class_id]);
    }

    function edit(Request $request, $lecture_id, $class_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user_url' => ['required', 'string', 'max:255'],
            'active_always' => 'required|in:0,1,2',
            'active_start_date' => ['required', 'date_format:Y-m-d'],
            'active_end_date' => ['required', 'date_format:Y-m-d', 'after:active_start_date'],
            'record_always' => 'required|in:0,1,2',
            'record_start_date' => ['required', 'date_format:Y-m-d'],
            'record_end_date' => ['required', 'date_format:Y-m-d', 'after:active_start_date', 'after:record_start_date'],
        ]);

        $class = Classes::find($class_id);

        if (!$class || $class->active) {
            return redirect()->back();
        }

        $class->update([
            'name' => $request['name'],
            'user_url' => $request['user_url'],
            'active_always' => $request['active_always'],
            'active_start_date' => $request['active_start_date'],
            'active_end_date' => $request['active_end_date'],
            'record_always' => $request['record_always'],
            'record_start_date' => $request['record_start_date'],
            'record_end_date' => $request['record_end_date'],
            'active' => $class->active,
            'lecture_id' => $class->lecture_id,
            'user_id' => $class->user_id,
        ]);

        //슬라이드 에디트 화면으로 리다이엑트
        return redirect()->route('lecture.lectureView', ['lecture_id' => $lecture_id]);
    }

    function delete(Request $request, $lecture_id, $class_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $class = Classes::find($class_id);

        if (!$class || $class->user_id != $request['user']->id || $class->lecture_id != $lecture_id) {
            return redirect()->back();
        }

        $class->delete();

        return redirect()->back();
    }
}


