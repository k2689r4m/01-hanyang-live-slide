<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\Classes;
use App\Slides;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

//class AsyncOperation extends Threade {
//    public $myHome;
//    public $myHome_;
//    public $tmpFileName;
//    public $tmpPptName;
//
//    public function __construct($myHome, $myHome_, $tmpFileName, $tmpPptName) {
//        $this->myHome = $myHome;
//        $this->myHome_ = $myHome_;
//        $this->tmpFileName = $tmpFileName;
//        $this->tmpPptName = $tmpPptName;
//    }
//
//    public function run() {
//        exec('convert -density 150 '.$this->myHome.$this->tmpFileName.' '.$this->myHome_.$this->tmpPptName.'.png');
//    }
//}

class SlideController extends Controller
{
    function writeView(Request $request, $lecture_id, $class_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $class = Classes::find($class_id);

        if (!$class) {
            return redirect()->back();
        }


        return view('slide.write', ['lecture_id' => $lecture_id, 'class_id' => $class_id, 'user_url' => $class->user_url]);
    }

    function makeSlide(Request $request, $lecture_id, $class_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $lecture = Lecture::find($lecture_id);
        $class = Classes::find($class_id);

        if (!$class || !$lecture || $class->lecture_id != $lecture->id) {
            return redirect()->back();
        }

        //만약 추가로 조건 검사한다면 수업을 진행 했다면 팅구기

        if($request['ppt_file']) {
            $slide = Slides::create([
                'type' => 'image',
                'slide_content' => ['imgUrl' => $request['file_names']],
                'available' => false,
                'class_id' => $class_id,
            ]);

            if (!$class->slides_num) {
                $class->slides_num = [$slide->id];
            }
            else {
                $slides_num = $class->slides_num;
                array_push($slides_num, $slide->id);
                $class->slides_num = $slides_num;
            }
            $class->save();

            $ppt_file = $request['ppt_file'];
            $ppt_file_names =  explode("-", $ppt_file);
//            $tmpPptName = $lecture_id.'-'.$class_id.'-'.$timeName;
            $ppt_file = $ppt_file_names[0].'-'.$ppt_file_names[1].'-'.$slide->id.'-'.$ppt_file_names[2];

            $slide->slide_content = ['imgUrl' => $ppt_file];
            $slide->save();

            Storage::move('public/uploads/'.$request['ppt_file'], 'public/uploads/'.$ppt_file);

            return true;
        }
        else {
            if ($request['slide']['type'] === 'none') {
                $slide = Slides::create([
                    'type' => 'none',
                    'slide_content' => '',
                    'available' => false,
                    'class_id' => $class_id,
                ]);

                if (!$class->slides_num) {
                    $class->slides_num = [$slide->id];
                }
                else {
                    $slides_num = $class->slides_num;
                    array_push($slides_num, $slide->id);
                    $class->slides_num = $slides_num;
                }
                $class->save();

                return ['status' => true, 'slide' => $slide, 'slides_num' => $class->slides_num];
            }
        }



//        return dd($request);
    }

    function fetchSlides(Request $request, $lecture_id, $class_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $lecture = Lecture::find($lecture_id);
        $class = Classes::find($class_id);

        if (!$class || !$lecture || $class->lecture_id != $lecture->id) {
            return redirect()->back();
        }

        //만약 추가로 조건 검사한다면 수업을 진행 했다면 팅구기

        $slides = Slides::where('class_id', $class->id)->get();

        return ['status' => true, 'slides' => $slides, 'slides_num' => $class->slides_num];
    }

    function deleteSlide(Request $request, $lecture_id, $class_id, $slide_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $lecture = Lecture::find($lecture_id);
        $class = Classes::find($class_id);

        if (!$class || !$lecture || $class->lecture_id != $lecture->id) {
            return redirect()->back();
        }

        $slide = Slides::find($slide_id);
        if ($slide) {
            if ($slide->type === 'image' || $slide->type === 'text_image') {
                if ($slide->slide_content && $slide->slide_content->imgUrl) {
                    Storage::delete('public/uploads/'.$slide->slide_content->imgUrl);
                }
            }
            else if ($slide->type === 'multiple_choice') {
                if ($slide->slide_content && $slide->slide_content->answers) {
                    foreach ($slide->slide_content->answers as $answer) {
                        Storage::delete('public/uploads/'.$answer->imgUrl);
                    }
                }
            }

            $slide->delete();
            $slides_num = $class->slides_num;
            $_slides_num = [];
            foreach ($slides_num as $num) {
                if ($slide_id != $num) {
                    array_push($_slides_num, $num);
                }
            }
            $class->slides_num = $_slides_num;
            $class->save();

            return true;
        }

        return false;
    }

    function writeSlide(Request $request, $lecture_id, $class_id, $slide_id) {
//        return dd($request);

        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $lecture = Lecture::find($lecture_id);
        $class = Classes::find($class_id);

        if (!$class || !$lecture || $class->lecture_id != $lecture->id) {
            return redirect()->back();
        }

        $request->validate([
           'type' => ['required', 'string', 'max:255'],
           'activationAnswer' => ['required', 'boolean'],
           'activationTimeLimit' => ['required', 'boolean'],
           'activationScore' => ['required', 'boolean'],
           'activationFirstCome' => ['required', 'boolean'],
           'activationLayout' => ['required', 'boolean'],
           'slide_content' => ['required', 'array'],
        ]);

        $slide = Slides::find($slide_id);

        if ($slide) {
            if ($slide->type !== $request->type) {
                if ($slide->type === 'image' || $slide->type === 'text_image') {
                    Storage::delete('public/uploads/'.$slide->slide_content->imgUrl);
                }
                else if ($slide->type === 'multiple_choice') {
                    foreach ($slide->slide_content->answers as $answer) {
                        Storage::delete('public/uploads/'.$answer->imgUrl);
                    }
                }
            }
            else if ($slide->type === 'image' || $slide->type === 'text_image') {
                if ($slide->slide_content->imgUrl !== $request->slide_content['imgUrl']) {
                    Storage::delete('public/uploads/'.$slide->slide_content->imgUrl);
                }
            }
            else if ($slide->type === 'multiple_choice') {
                foreach($slide->slide_content->answers as $answer) {
                    $flag = false;
                    if ($answer->imgUrl) {
                        foreach ($request['slide_content']['answers'] as $_answer) {
                            if ($answer->imgUrl === $_answer['imgUrl']) {
                                $flag = true;
                            }
                        }
                    }
                    else {
                        $flag = true;
                    }

                    if (!$flag) {
                        Storage::delete('public/uploads/'.$answer->imgUrl);
                    }
                }
            }

            $slide->type = $request->type;
            $slide->activation_answer = $request->activationAnswer;
            $slide->activation_time_limit = $request->activationTimeLimit;
            $slide->activation_score = $request->activationScore;
            $slide->activation_first_come = $request->activationFirstCome;
            $slide->activation_layout = $request->activationLayout;
            $slide->slide_content = $request->slide_content;

            $slide->save();

            return true;
        }
        else {
            return false;
        }
    }

    function pptUpload(Request $request, $lecture_id, $class_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $class = Classes::find($class_id);
        if (!$class && !($class->lecture()->first()) && $class->lecture()->first()->user_id != $request['user']->id) {
            return redirect()->back();
        }

        if($request->file()) {
            $timeName = uniqid();
            $tmpFileName = $request->file->getClientOriginalName();
            $type = substr(strrchr($tmpFileName, '.'), 1);

            if(!($type === 'pptx' || $type === 'ppt' || $type === 'pdf')){
                return 'NOTYPE';
            }

            $tmpFileName = $timeName.'_'.$lecture_id.'_'.$class_id.'.'.$type;
            $tmpPptName = $lecture_id.'-'.$class_id.'-'.$timeName;

            Storage::putFileAs('public/uploads/tmp', $request->file , $tmpFileName);

            $myHome = storage_path('app/public/uploads/tmp/');
            $myHome_ = storage_path('app/public/uploads/');

            $process = new Process(['convert', $myHome.$tmpFileName, $myHome_.$tmpPptName.'.png'],null, ['HOME' => '/tmp']);
            $process->run(null,['HOME' => '/tmp']);

            exec('ls '.$myHome_.' | grep '.$tmpPptName.' | sort --version-sort', $fileNames);

            if(!$fileNames){
                return 'ERROR';
            }

            for($i=0; $i<count($fileNames); $i++){
                $request['ppt_file'] = $fileNames[$i];
                $this->makeSlide($request, $lecture_id, $class_id);
            }

            return 'TRUE';
        }

        return 'FALSE';
    }

    function imageUpload(Request $request, $lecture_id, $class_id, $slide_id)
    {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $class = Classes::find($class_id);


        if (!$class && !($class->lecture()->first())) {
            return redirect()->back();
        }

        $fileNames = [];
        for ($i = 0;$i < $request->length;$i++) {
            if ($request[$i] != 'none') {
                $file = $request[$i];
                $fileRealName = $file->getClientOriginalName();
                $type = explode('/', $file->getClientMimeType());
                $fileName = $lecture_id . '-' . $class_id . '-' . $slide_id . '-' . uniqid() . '.' . end($type);

                Storage::putFileAs('public/uploads', $file, $fileName);
                $fileNames[] = $fileName;
            }
            else {
                $fileNames[] = '';
            }
        }

        return $fileNames;
    }


    function slideExCheck(Request $request, $lecture_id, $class_id){
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $curClass = Classes::find($class_id);

        if($curClass){
            if(!$curClass->slides_num){
                return Classes::select('id', 'name')->where('lecture_id', $lecture_id)->get();
            }
        }

        return false;
    }

    function slideExOn(Request $request, $lecture_id, $class_id){
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $curClass = Classes::find($request->slideEx['id']);
        $myClass = Classes::find($class_id);

        $idx = [];

        if(!$curClass){
            return false;
        }

        if(!$curClass->slides_num){
            return false;
        }

        if(!$myClass){
            return false;
        }

        foreach ($curClass->slides_num as $_data){
            $idx[] = $_data;
        }


        for($i=0; $i<count($idx); $i++){
            $copyToSlide = Slides::find($idx[$i]);


            if($copyToSlide->type === 'none'){
                $slide = Slides::create([
                    'type' => 'none',
                    'slide_content' => '',
                    'available' => false,
                    'class_id' => $class_id,
                ]);
            }
            else{
                $slide = Slides::create([
                    'type' => $copyToSlide->type,
                    'activation_answer' => $copyToSlide->activation_answer,
                    'activation_time_limit' => $copyToSlide->activation_time_limit,
                    'activation_score' => $copyToSlide->activation_score,
                    'activation_first_come' => $copyToSlide->activation_first_come,
                    'activation_layout' => $copyToSlide->activation_layout,
                    'slide_content' => '',
                    'available' => false,
                    'class_id' => $class_id,
                ]);

                if($copyToSlide->type === 'image' || $copyToSlide->type === 'text_image'){
                    $slideContent = $copyToSlide->slide_content;
                    if($copyToSlide->slide_content->imgUrl){
                        $file = $copyToSlide->slide_content->imgUrl;
                        $type = substr(strrchr($file, '.'), 1);
                        $fileName = $lecture_id . '-' . $class_id . '-' . $slide->id . '-' . uniqid() . '.' . $type;

                        Storage::copy('public/uploads/'.$file,'public/uploads/'.$fileName);
                        $slideContent->imgUrl = $fileName;
                    }
                    $slide->slide_content = $slideContent;
                    $slide->save();
                }
                else if($copyToSlide->type === 'multiple_choice'){
                    $slideContent = $copyToSlide->slide_content;

                    for ($j=0;$j<count($copyToSlide->slide_content->answers);$j++){
                        if($copyToSlide->slide_content->answers[$j]->imgUrl) {
                            $file = $copyToSlide->slide_content->answers[$j]->imgUrl;
                            $type = substr(strrchr($file, '.'), 1);
                            $fileName = $lecture_id . '-' . $class_id . '-' . $slide->id . '-' . uniqid() . '.' . $type;

                            Storage::copy('public/uploads/' . $file, 'public/uploads/' . $fileName);
                            $slideContent->answers[$j]->imgUrl = $fileName;
                        }
                    }
                    $slide->slide_content = $slideContent;
                    $slide->save();
                }
                else{
                    $slide->slide_content = $copyToSlide->slide_content;
                    $slide->save();
                }
            }

            if (!$myClass->slides_num) {
                $myClass->slides_num = [$slide->id];
            }
            else {
                $slides_num = $myClass->slides_num;
                array_push($slides_num, $slide->id);
                $myClass->slides_num = $slides_num;
            }
            $myClass->save();
        }

        return true;
    }

    function slideMove(Request $request, $lecture_id, $class_id){
        if (!$request['isOwn']) {
            return redirect()->back();
        }
        $class = Classes::find($class_id);

        if(!$class){
            return false;
        }

        $class->slides_num = $request->slidesIdx;
        $class->save();

        return true;
    }
}
