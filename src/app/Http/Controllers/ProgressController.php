<?php

namespace App\Http\Controllers;

use App\LeaderBoard;
use App\Members;
use App\User;
use DB;
use App\Answer;
use App\Events\classesRoomEvent;
use App\Lecture;
use App\Message;
use App\Progress;
use App\Classes;
use App\Slides;
use App\GoodListInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use MongoDB\Driver\Session;

class ProgressController extends Controller
{
    function enterProgress(Request $request, $user_url) {
        $class = Classes::where('user_url', $user_url)->first();
        $request->session()->forget('error_message');
        $lecture = Lecture::find($request->get('lecture_id'));

        if (!$class || !$lecture) {
            return redirect()->back();
        }

        $slide = $class->slides()->count();

        if($slide <= 0) {
            return redirect()->back();
        }

        $pagination = [];

        $progress = Progress::where('class_id', $request->get('class_id'))->orderBy('updated_at', 'desc')->get();

        if (count($progress) <= 0) {
            if (!$request->get('isOwn')) {
                return redirect()->back()->with(['error_message' => '수업을 준비중 입니다.']);
            }
            $slide = Slides::find($class->slides_num[0]);
            Progress::create([
                'class_id' => $request->get('class_id'),
                'slide_id' => $class->slides_num[0],
                'user_id' => Auth::id(),
                'status' => $slide->type === 'multiple_choice' || $slide->type === 'short_answer' ? 'READY' : 'NONE',
            ]);

            $pagination[] = null;
            $pagination[] = $class->slides_num[0];
            $pagination[] = 1 <= count($class->slides_num) ? $class->slides_num[0] : null;

            return view('slide.professor_view',
                [
                    'lecture_id' => $request->get('lecture_id'),
                    'class_id' => $request->get('class_id'),
                    'pagination' => $pagination,
                    'professor_id' => $lecture->user_id,
                    'user_url' => $class->user_url
                ]
            );
        }
        else {
            $progress = $progress->first();

            for ($i = 0;$i < count($class->slides_num);$i++) {
                if ($class->slides_num[$i] === $progress->slide_id) {
                    $pagination[] = $i <= 0 ? null : $class->slides_num[$i - 1];
                    $pagination[] = $class->slides_num[$i];
                    $pagination[] = $i + 1 >= count($class->slides_num) ? null : $class->slides_num[$i + 1];

                    break;
                }
            }

            if ($request->get('isOwn')) {
                return view('slide.professor_view',
                    [
                        'lecture_id' => $request->get('lecture_id'),
                        'class_id' => $request->get('class_id'),
                        'pagination' => $pagination,
                        'professor_id' => $lecture->user_id,
                        'user_url' => $class->user_url
                    ]
                );
            }
            else {
                return view('slide.student_view',
                    [
                        'lecture_id' => $request->get('lecture_id'),
                        'class_id' => $request->get('class_id'),
                        'pagination' => $pagination[1],
                        'professor_id' => $lecture->user_id,
                        'user_url' => $class->user_url
                    ]
                );
            }
        }
    }

    function fetchSlide(Request $request, $user_url, $slide_id) {
        $slide = Slides::find($slide_id);
        $class = Classes::find($request->get('class_id'));
        $slides_num = $class->slides_num;

        $pagination = [];
        for ($i = 0;$i < count($slides_num);$i++) {
            if ($slides_num[$i] === $slide_id * 1) {
                $pagination[] = $i <= 0 ? null : $slides_num[$i - 1];
                $pagination[] = $slides_num[$i];
                $pagination[] = $i + 1 >= count($slides_num) ? null : $slides_num[$i + 1];

                break;
            }
        }

        $progress = Progress::where('slide_id', $slide_id)->first();

        if ($request->get('isOwn')) {
            if ($progress) {
                $progress->updated_at = now();
                if($slide->type === 'multiple_choice' || $slide->type === 'short_answer'){
                    if($progress->status === 'NONE'){
                        $progress->status = 'READY';
                    }
                }
                $progress->save();
            }
            else {
                $progress = Progress::create([
                    'class_id' => $request->get('class_id'),
                    'slide_id' => $slide_id,
                    'user_id' => Auth::id(),
                    'status' => $slide->type === 'multiple_choice' || $slide->type === 'short_answer' ? 'READY' : 'NONE',
                ]);
            }

            $goodListInfo = GoodListInfo::where('slide_id', $slide_id)->get();

            $goodListCount = [];
            for ($i = 0; $i < 4;$i++) {
                $goodListCount[] = $goodListInfo->where('flag_num', $i)->count();
            }

            return [
                'slide' => $slide,
                'pagination' => $pagination,
                'status' => $progress->status,
                'good_list_count' => $goodListCount
            ];
        }
        else {
            if ($progress) {
                $attempted = false;
                if ($slide->type === 'multiple_choice' || $slide->type === 'short_answer') {
                    $_answer = Answer::where('slide_id', $slide_id)->where('user_id', Auth::id())->first();
                    if ($_answer) {
                        $attempted = true;
                    }
                }

                if ($slide->type === 'multiple_choice') {
                    foreach ($slide->slide_content->answers as $answer) {
                        $answer->isRightAnswer = null;
                    }
                }
                else if ($slide->type === 'short_answer') {
                    $slide->slide_content->answer = null;
                }

                $goodListInfo = GoodListInfo::where('user_id', Auth::id())->where('slide_id', $slide_id)->first();

                if (!$goodListInfo) {
                    return ['slide' => $slide, 'status' => $progress->status, 'attempted' => $attempted, 'good_list_info' => null];
                }
                else {
                    return ['slide' => $slide, 'status' => $progress->status, 'attempted' => $attempted, 'good_list_info' => $goodListInfo->flag_num];
                }
            }
            else {
                return ['slide' => null, 'status' => null];
            }
        }
    }

    function statusUpdate(Request $request, $user_url, $slide_id, $status) {
        $class = Classes::where('user_url', $user_url)->first();
        if (!$class) {
            return false;
        }

        if ($class->user_id != Auth::id()) {
            return false;
        }

        $slide = Slides::find($slide_id);
        if (!$slide) {
            return false;
        }

        $lastSlide = Progress::where('class_id', $request->get('class_id'))->where('user_id', $class->user_id)->orderBy('updated_at', 'desc')->first();

        if ($slide->id != $lastSlide->slide_id) {
            return false;
        }

        $lastSlide->status = $status;
        $lastSlide->save();

        return true;
    }

    function leaderUpdate(Request $request, $user_url, $slide_id) {
        $class = Classes::where('user_url', $user_url)->first();
        if (!$class) {
            return false;
        }

        $slide = Slides::find($slide_id);
        if (!$slide) {
            return false;
        }

        $leaders = LeaderBoard::where('slide_id', $slide_id)->first();

        if(!$leaders){
            return false;
        }
        $leaders = json_decode($leaders->leader_data);
        $resultData = [];

        if (request()->get('isOwn')) {
            for ($i=0;$i<count($leaders);$i++) {
                $resultData[] = [
                    'name' => (User::where('id', $leaders[$i]->user_id)->first())->name,
                    'value' => $leaders[$i]->score,
                    'rank' => $leaders[$i]->rank,
                    'additionalScore' => $leaders[$i]->up_score,
                    'own' => false
                ];

                if($request->state === 0){
                    if(9<=$i)
                        break;
                }
            }
        }
        else{
            $isme = false;

            for ($i=0;$i<count($leaders);$i++) {
                if($leaders[$i]->user_id === Auth::id())
                    $isme = true;

                $resultData[] = [
                    'name' => (User::where('id', $leaders[$i]->user_id)->first())->name,
                    'value' => $leaders[$i]->score,
                    'rank' => $leaders[$i]->rank,
                    'additionalScore' => $leaders[$i]->up_score,
                    'own' => $leaders[$i]->user_id === Auth::id()
                ];

                if(9<=$i)
                    break;
            }

            if(!$isme){
                $resultData[] = [];

                for ($i=0;$i<count($leaders);$i++) {
                    if($leaders[$i]->user_id === Auth::id()) {
                        $resultData[] = [
                            'name' => (User::where('id', $leaders[$i]->user_id)->first())->name,
                            'value' => $leaders[$i]->score,
                            'rank' => $i + 1,
                            'additionalScore' => $leaders[$i]->up_score,
                            'own' => $leaders[$i]->user_id === Auth::id()
                        ];

                        break;
                    }
                }
            }
        }

        return $resultData;
    }


    ////////////////////////////////////////////
    function graphUpdate(Request $request, $user_url, $slide_id) {
        $class = Classes::where('user_url', $user_url)->first();
        if (!$class) {
            return false;
        }

        $slide = Slides::find($slide_id);
        if (!$slide) {
            return false;
        }


        $answers = DB::table('answers')
            ->where('slide_id', '=', $slide_id)
            ->select('answer_data', DB::raw('count(id) as total'))
            ->groupBy('answers.answer_data')->get();

        $user_answer = Answer::where('user_id', Auth::user()->id)->where('slide_id', $slide_id)->first();

        if (!$answers) {
            return false;
        }

        $resultData = [];
        if ($slide->type === 'multiple_choice') {
            $_url = request()->headers->get('referer');
            foreach ($slide->slide_content->answers as $_data) {
                $selectedAnswer = false;
                $img = null;
                if ($_data->imgUrl) {
                    $img = $_url . '/api/downloadImage/' . $_data->imgUrl;
                }

                $resultData[] = [
                    'name' => $_data->answer,
                    'value' => 0,
                    'image' => $img,
                    'isRightAnswer' => $_data->isRightAnswer,
                    'selectedAnswer' => false,
                ];
            }

            foreach ($answers as $answer) {
                if(!$request->get('isOwn')){
                    if($user_answer){
                        if($user_answer->answer_data === $answer->answer_data){
                            $selectedAnswer = true;
                        }
                    }
                }

                $resultData[(int)$answer->answer_data]['value'] = $answer->total;
                $resultData[(int)$answer->answer_data]['selectedAnswer'] = $selectedAnswer;
            }

        } elseif ($slide->type === 'short_answer') {
            $_data = $slide->slide_content;

            $resultData[] = [
                'name' => $_data->answer,
                'value' => 0,
                'image' => null,
                'isRightAnswer' => true,
                'selectedAnswer' => false,
            ];

            foreach ($answers as $answer) {
                $img = null;
                $isAnswer = false;
                $selectedAnswer = false;

                if ($slide->slide_content->answer === $answer->answer_data) {
                    $isAnswer = true;
                }

                if(!$request->get('isOwn')){
                    if($user_answer){
                        if($user_answer->answer_data === $answer->answer_data){
                            $selectedAnswer = true;
                        }
                    }
                }

                if($resultData[0]['name'] === $answer->answer_data){

                    $resultData[0]['value'] = $answer->total;
                    $resultData[0]['selectedAnswer'] = $selectedAnswer;
                }
                else{
                    $resultData[] = [
                        'name' => $answer->answer_data,
                        'value' => $answer->total,
                        'image' => $img,
                        'isRightAnswer' => $isAnswer,
                        'selectedAnswer' => $selectedAnswer,
                    ];
                }
            }
        }

        return $resultData;
    }
    ////////////////////////////////////////////

    function snedAnswer(Request $request, $user_url, $slide_id) {
        $request->validate([
            'user_answer' => ['required']
        ]);


        $class = Classes::where('user_url', $user_url)->first();
        if (!$class) {
            return false;
        }

        $slide = Slides::find($slide_id);
        if (!$slide || $slide->class_id != $class->id) {
            return false;
        }

        $lastProgress = Progress::where('class_id', $class->id)->orderBy('updated_at', 'desc')->first();
        if (!$lastProgress || $lastProgress->slide_id != $slide->id) {
            return false;
        }

        if (($slide->type !== 'multiple_choice' && $slide->type !== 'short_answer') || $lastProgress->status !== 'START') {
            return false;
        }

        if (0 <= $request['user_answer']) {
            $answer = $request['user_answer'];

            if ($slide->type === 'multiple_choice') {
                $answer = $answer."";
            }

            $result = null;

            if (!$slide->activation_answer) {
                //survay
                Answer::create([
                    'answer_data' => $answer,
                    'user_id' => Auth::id(),
                    'lecture_id' => $class->lecture_id,
                    'class_id' => $class->id,
                    'slide_id' => $slide->id,
                    'result' => false,
                    'score' => -1
                ]);
            }
            else {
                if ($slide->type === 'multiple_choice') {
                    $slideContent = $slide->slide_content;

                    if (!$slideContent->answers) {
                        return false;
                    }

                    $answers = $slideContent->answers;

                    if (!$answers[$answer]) {
                        return false;
                    }

//                    정답인지 결론
                    if ($answers[$answer]->isRightAnswer) {
                        $result = true;
                    }
                    else {
                        $result = false;
                    }
                }
                else if ($slide->type === 'short_answer') {


                    $slideContent = $slide->slide_content;

                    if ($slideContent->answer != 0 && !$slideContent->answer) {
                        return false;
                    }

                    $answers = $slideContent->answer;

                    if ($answers == $answer) {
                        $result = true;
                    }
                    else {
                        $result = false;
                    }
                }
                else {
                    return false;
                }

                if (!$slide->activation_score) {
                    Answer::create([
                        'answer_data' => $answer,
                        'user_id' => Auth::id(),
                        'lecture_id' => $class->lecture_id,
                        'class_id' => $class->id,
                        'slide_id' => $slide->id,
                        'result' => $result,
                        'score' => 0
                    ]);

//                    return ['result' => $result];
                }
                else {
                    $_score = 0;

                    if ($slide->activation_time_limit) {
                        if ($slide->activation_first_come) {
                            //score calc
                            $answerRank = Answer::where('slide_id', $slide_id)->where('result', true)->orderBy('created_at', 'asc')->count();
                            $maxScore = $slide->slide_content->maxScore;
                            $minScore = $slide->slide_content->minScore;
                            $quizStartTime = $lastProgress->updated_at;
                            $nowTime = now();
                            $timeout = $slide->slide_content->timeout;

                            $timeDiff = strtotime($nowTime) - strtotime($quizStartTime);

                            $score = $minScore + (($maxScore - $minScore) * (($timeout - $timeDiff) / $timeout));


                            if($score < 0){
                                $score = 0;
                            }

                            /////////////////////////////////////////////////////////////
                            $_score = $result ? (int)floor($score) : 0;
                            /////////////////////////////////////////////////////////////

                            Answer::create([
                                'answer_data' => $answer,
                                'user_id' => Auth::id(),
                                'lecture_id' => $class->lecture_id,
                                'class_id' => $class->id,
                                'slide_id' => $slide->id,
                                'result' => $result,
                                'score' => $result ? floor($score) : 0,
                            ]);
                        }
                        else {
                            /////////////////////////////////////////////////////////////
                            $_score = $result ? $slide->slide_content->maxScore : 0;
                            /////////////////////////////////////////////////////////////

                            Answer::create([
                                'answer_data' => $answer,
                                'user_id' => Auth::id(),
                                'lecture_id' => $class->lecture_id,
                                'class_id' => $class->id,
                                'slide_id' => $slide->id,
                                'result' => $result,
                                'score' => $result ? $slide->slide_content->maxScore : 0,
                            ]);
                        }
                    }
                    else {
                        /////////////////////////////////////////////////////////////
                        $_score = $result ? $slide->slide_content->maxScore : 0;
                        /////////////////////////////////////////////////////////////


                        Answer::create([
                            'answer_data' => $answer,
                            'user_id' => Auth::id(),
                            'lecture_id' => $class->lecture_id,
                            'class_id' => $class->id,
                            'slide_id' => $slide->id,
                            'result' => $result,
                            'score' => $result ? $slide->slide_content->maxScore : 0,
                        ]);
                    }


                    /////////////////////////////////////////////////////////////
                    ///  리더보드 데이터
                    /////////////////////////////////////////////////////////////
                    $leader = LeaderBoard::where('slide_id', $slide->id)->first();
                    $member = Members::where('lecture_id', $class->lecture_id)->where('user_id', Auth::id())->first();

                    if(!$leader){
                        $leader_data = [];
                        $mem_list = Members::where('lecture_id',$class->lecture_id)->get();

                        foreach ($mem_list as $mem) {
                            if($mem->user_id !== $class->user_id) {
                                $leader_data[] = [
                                    'user_id' => $mem->user_id,
                                    'score' => (int)$mem->score,
                                    'rank' => -1,
                                    'up_score' => 0,
                                ];
                            }
                        }

                        LeaderBoard::create([
                            'slide_id' => $slide->id,
                            'leader_data' => json_encode($leader_data),
                        ]);
                    }

                    $leader = LeaderBoard::where('slide_id', $slide->id)->first();
                    $leader_data = json_decode($leader->leader_data);

                    usort($leader_data, function ($item1, $item2) {
                        return $item2->score <=> $item1->score;
                    });

                    for($i=0;$i<count($leader_data);$i++){
                        if($leader_data[$i]->user_id === Auth::id()){
                            $leader_data[$i]->score  = (int)$member->score + $_score;
                            $leader_data[$i]->up_score = (int)$_score;
                            $leader_data[$i]->rank = $i+1;
                        }
                        $leader_data[$i]->rank = $i+1;
                    }





                    $leader->leader_data = json_encode($leader_data);
                    $leader->save();
                    $member->score = (int)$member->score + $_score;
                    $member->save();
                    /////////////////////////////////////////////////////////////
                }
            }
        }



    }

    function sendReaction(Request $request, $user_url, $slide_id) {
        $request->validate([
            'flagType' => ['required', 'min:0', 'max:3']
        ]);

        if ($request['isOwn']) {
            return false;
        }

        $flagType = $request['flagType'];

        $goodListInfo = GoodListInfo::where('user_id', Auth::id())->where('slide_id', $slide_id)->first();

        if ($goodListInfo) {
            $goodListInfo->flag_num = $flagType;
            $goodListInfo->save();
        }
        else {
            GoodListInfo::create([
                'flag_num' => $flagType,
                'slide_id' => $slide_id,
                'user_id' => Auth::id()
            ]);
        }

        return true;
    }

    function fetchReaction(Request $request, $user_url, $slide_id) {
        if ($request['isOwn']) {
            $goodListInfo = GoodListInfo::where('slide_id', $slide_id)->get();

            if (!$goodListInfo) {
                return false;
            }

            $goodList = [];
            for($i = 0;$i < 4;$i++) {
                $goodList[] = $goodListInfo->where('flag_num', $i)->count();
            }

            return $goodList;
        }
        else {
            $goodListInfo = GoodListInfo::where('slide_id', $slide_id)->where('user_id', Auth::id())->first();

            if (!$goodListInfo) {
                return false;
            }

            return $goodListInfo->flag_num;
        }
    }

    function fetchMessages(Request $request, $user_url){
        $lecture = Lecture::find($request->get('lecture_id'));

        if($lecture->use_nickname) {
            return Message::where('class_id', $request->get('class_id'))->with(['user' => function ($query) {
                $query->select(['id', 'nickname as name']);
            }])->get();
        }
        else{
            return Message::where('class_id', $request->get('class_id'))->with(['user' => function ($query) {
                $query->select(['id', 'name as name']);
            }])->get();
        }
    }

    function sendMessage(Request $request, $user_url){
        $message = Auth()->user()->messages()->create([
            'message' => $request->get('message'),
            'user_id' => Auth::id(),
            'class_id' => $request->get('class_id')
        ]);

        $lecture = Lecture::find($request->get('lecture_id'));

        if($lecture->use_nickname){
            broadcast(new classesRoomEvent($message->load(['user' => function($query){
                $query->select(['id', 'nickname as name']);
            }]), $request->get('class_id')))->toOthers();
        }
        else{
            broadcast(new classesRoomEvent($message->load(['user' => function($query){
                $query->select(['id', 'name as name']);
            }]), $request->get('class_id')))->toOthers();
        }

//        broadcast(new classesRoomEvent($message->load('user'), $request->get('class_id')))->toOthers();
//        broadcast(new classesRoomEvent($message->load('user'), $request->get('class_id')))->toOthers();

        $isUser = [];
        if($lecture->use_nickname){
            $isUser = [
                'id' => Auth::user()->id,
                'name' => Auth::user()->nickname
            ];
        }
        else{
            $isUser = [
                'id' => Auth::user()->id,
                'name' => Auth::user()->name
            ];
        }

        return $isUser;
    }

    function sendMemberCount(Request $request, $user_url) {
//        $request->validate([
//            'count_members' => ['required', 'numeric', 'min:1'],
//        ]);
//        $class = Classes::where('user_url', $user_url)->first();

        $class = Classes::find($request->get('class_id'));
        $class->active_member_count = $class->active_member_count + 1;
        $class->save();
    }
}
