<?php

namespace App\Http\Controllers;

use App\Progress;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    function requestWriteView(Request $request) {
        return view('request.request_write_view');
    }

    function requestWrite(Request $request) {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'content' => ['required', 'string', 'max:1000', 'min:2'],
            'required_check_box' => ['required'],
        ]);

        \App\Request::create([
           'email' => $request['email'],
           'name' => $request['name'],
           'title' => $request['title'],
           'content' => $request['content'],
        ]);

        return redirect()->route('user.loginView');
    }
}
