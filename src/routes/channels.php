<?php

use Illuminate\Support\Facades\Broadcast;
use App\Classes;
use App\Lecture;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


//Broadcast::channel('classesroom', function ($user, $id) {
//    return $user;
//});

Broadcast::channel('classesroom_{id}', function ($user, $id) {
    $class = Classes::find($id);
    $lecture = Lecture::find($class->lecture_id);

//    $class->active_member_count = $class->active_member_count + 1;
//    $class->save();

    $isUser = [];
    if($lecture->use_nickname){
        $isUser = [
            'id' => $user->id,
            'name' => $user->nickname
        ];
    }
    else{
        $isUser = [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }

    return $isUser;
});

