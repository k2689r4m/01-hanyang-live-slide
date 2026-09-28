<?php

namespace App\Http\Controllers;

use Exception;
use App\Archive;
use App\Comment;
use App\Members;
use App\Notice;
use App\Slides;
use App\User;
use App\Lecture;
use App\qna;
use App\Classes;
use App\Answer;
use App\Progress;
use App\Mail\VerificationMail;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LectureController extends Controller
{
    /** QnA */
    function qnaView(Request $request, $lecture_id) {
//        $qnas = qna::where('lecture_id', $lecture_id)->orderBy('id', 'desc')->paginate(10);
        $lecture = Lecture::find($lecture_id);

        $qnas = qna::where('lecture_id', $lecture_id)->orderBy('id', 'desc')->get();
        $index = $qnas->count();
        $data = [];
        foreach($qnas as $qna) {
            $data[] = ['index'=> $index--, 'qna' => $qna];
        }

        $perPage = 10;

        $data = collect($data);

        $paginate = new LengthAwarePaginator(
            $data->forPage(Paginator::resolveCurrentPage(), $perPage),
            $data->count(),
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('lecture.qna_view', ['data' => $paginate, 'lecture_id' => $lecture_id, 'lecture' => $lecture]);
    }

    function qnaWriteView(Request $request, $lecture_id) {
        if ($request['isOwn']) {
            return redirect()->back();
        }

        $lecture = Lecture::find($lecture_id);

        return view('lecture.qna_write', ['lecture_id' => $lecture_id, 'lecture' => $lecture]);
    }

    function qnaWrite(Request $request, $lecture_id) {
        if ($request['isOwn']) {
            return redirect()->back();
        }

//        $request->validate([
//            'title' => ['required', 'string', 'max:255'],
//            'content' => ['required', 'string', 'max:255'],
//            'file[]' => ['file']
//        ]);

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'lock' => ['required', 'numeric', 'max:1', 'min:0'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'file[]' => ['file'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '첨부파일 형식이 잘못됬습니다.'];
        }

        $files = [];

        if ($request->file) {
            foreach ($request->file as $file) {
                $fileRealName = $file->getClientOriginalName();
                $fileName = uniqid();

                $files[] = [ 'fileName' => $fileName, 'fileRealName' => $fileRealName ];
                Storage::putFileAs('public/qna', $file, $fileName);
            }
        }

        $newQna = qna::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'file' => $files,
            'lock' => $request['lock'],
            'lecture_id' => $lecture_id,
            'user_id' => $request['user']->id
        ]);

        return ['status' => 'success', 'content' => route('lecture.qna.detailView', ['lecture_id' => $lecture_id, 'qna_id' => $newQna['id']])];
    }

    function qnaEditView(Request $request, $lecture_id, $qna_id) {
        if ($request['isOwn']) {
            return redirect()->back();
        }

        $qna = qna::find($qna_id);
        if ($qna['user_id'] != $request['user']->id) {
            return redirect()->back();
        }

        $lecture = Lecture::find($lecture_id);

        return view('lecture.qna_edit', ['lecture_id' => $lecture_id, 'qna' => $qna, 'lecture' => $lecture]);
    }

    function qnaEdit(Request $request, $lecture_id, $qna_id) {
        $lecture = Lecture::find($lecture_id);
        if ($request['isOwn']) {
            return ['status' => 'error 2', 'content' => route('lecture.qnaView', ['lecture_id' => $lecture_id, 'lecture' => $lecture])];
        }

        $qna = qna::find($qna_id);
        if (!$qna) {
            return ['status' => 'error 2', 'content' => route('lecture.qnaView', ['lecture_id' => $lecture_id, 'lecture' => $lecture])];
        }

        if ($qna['lecture_id'] != $lecture_id) {
            return ['status' => 'error 2', 'content' => route('lecture.qnaView', ['lecture_id' => $lecture_id, 'lecture' => $lecture])];
        }

        if ($qna->user_id != Auth::id()) {
            return ['status' => 'error 2', 'content' => route('lecture.qnaView', ['lecture_id' => $lecture_id, 'lecture' => $lecture])];
        }

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'lock' => ['required', 'numeric', 'max:1', 'min:0'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'file[]' => ['file'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '첨부파일 형식이 잘못됬습니다.'];
        }

        $files = [];

        if ($request->existFileList) {
            $exist_file_list = explode(',', $request->existFileList);

            for ($i = 0; $i < count($exist_file_list);$i++) {
                if (!$exist_file_list[$i]) {
                    Storage::delete('public/qna/'.$qna->file[$i]->fileName);
                }
                else {
                    $files[] = $qna->file[$i];
                }
            }
        }

        if ($request->file) {
            foreach ($request->file as $file) {
                $fileRealName = $file->getClientOriginalName();
                $fileName = uniqid();

                $files[] = [ 'fileName' => $fileName, 'fileRealName' => $fileRealName ];
                Storage::putFileAs('public/qna', $file, $fileName);
            }
        }

        $qna->update([
            'title' => $request->title,
            'content' => $request->content,
            'file' => $files,
            'lock' => $request->lock,
            'user_id' => Auth::id(),
            'lecture_id' => $request['lecture_id'],
        ]);

        return ['status' => 'success', 'content' => route('lecture.qna.detailView', ['lecture_id' => $lecture_id, 'qna_id' => $qna->id])];
    }

    function qnaDetailView(Request $request, $lecture_id, $qna_id) {
        $lecture = Lecture::find($lecture_id);

        if (!$lecture) {
            return redirect()->back();
        }

        $qna = qna::find($qna_id);
        if ($qna['user_id'] != $request['user']->id && $qna['lock'] && !$request['isOwn']) {
            return redirect()->back();
        }

//        $comments = Comment::where('qna_id', $qna_id)->orderBy('bundle_id', 'asc')->get();
        $comments = Comment::where('qna_id', $qna_id)->where('depth', 0)->orderBy('bundle_id', 'asc')->get();

        return view('lecture.qna_detail', ['lecture_id' => $lecture_id, 'qna' => $qna, 'comments' => $comments, 'use_nickname' => $lecture->use_nickname, 'lecture' => $lecture]);
    }

    function qnaDelete(Request $request, $lecture_id, $qna_id) {
        $qna = qna::find($qna_id);
        if ($qna['user_id'] != $request['user']->id && !$request['isOwn']) {
            return redirect()->back();
        }

        if ($qna['file']) {
            for ($i = 0;$i < count($qna['file']);$i++) {
                Storage::delete('public/qna/'.$qna['file'][$i]->fileName);
            }
        }

        $qna->delete();

        return redirect()->back();
    }

    function qnaCommentWrite(Request $request, $lecture_id, $qna_id) {
        $qna = qna::find($qna_id);

        if (!$qna) {
            return redirect()->back();
        }

        $comment = Comment::find($request['comment_id']);

        if ($qna->lock && ($qna->user_id != $request['user']->id && !$request['isOwn'])) {
            if ($comment && $comment->user_id != $request['user']->id) {
                return redirect()->back();
            }
        }

        $request->validate([
            'comment_id' => ['required'],
            'content' => ['required', 'string', 'max:255'],
            'lock' => ['required', 'numeric', 'max:1', 'min:0'],
        ]);

        if ($comment) {
            Comment::create([
                'user_id' => $request['user']->id,
                'depth' => 1,
                'qna_id' => $qna_id,
                'bundle_id' => $comment->id,
                'content' => $request['content'],
                'lock' => $request['lock'],
            ]);
        }
        else {
            if ($request['comment_id'] === '-1') {
                $last_comment = Comment::orderBy('id', 'desc')->first();

                Comment::create([
                    'user_id' => $request['user']->id,
                    'depth' => 0,
                    'qna_id' => $qna_id,
                    'bundle_id' => $last_comment ? $last_comment->id + 1 : 0,
                    'content' => $request['content'],
                    'lock' => $request['lock'],
                ]);
            }
        }

        return redirect()->back();
    }

    function qnaCommentDelete(Request $request, $lecture_id, $qna_id, $comment_id) {
        $comment = Comment::find($comment_id);

        if (!$comment) {
            return redirect()->back();
        }

        $qna = qna::find($qna_id);

        if (!$qna) {
            return redirect()->back();
        }

        if (!request()->get('isOwn') && Auth::id() != $comment->user_id) {
            return redirect()->back();
        }

        $comment->delete();

        return redirect()->back();
    }
    /** End QnA */

    /** Notice */
    function noticeView(Request $request, $lecture_id) {
//        $notices = Notice::where('lecture_id', $lecture_id)->orderBy('id', 'desc')->paginate(10);
        $lecture = Lecture::find($lecture_id);

        $notices = Notice::where('lecture_id', $lecture_id)->orderBy('id', 'desc')->get();
        $data = [];
        $index = $notices->count();
        foreach($notices as $notice) {
            $created = date('Y.m.d', strtotime($notice->created_at));
            $data[] = ['index' => $index--, 'title' => $notice->title, 'created' => $created, 'id' => $notice->id];
        }

        $perPage = 10;

        $data = collect($data);

        $paginate = new LengthAwarePaginator(
            $data->forPage(Paginator::resolveCurrentPage(), $perPage),
            $data->count(),
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('lecture.notice_view', ['data' => $paginate, 'lecture_id' => $lecture_id, 'lecture' => $lecture]);
    }

    function noticeWriteView(Request $request, $lecture_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $lecture = Lecture::find($lecture_id);

        return view('lecture.notice_write', ['lecture_id' => $lecture_id, 'lecture' => $lecture]);
    }

    function noticeWrite(Request $request, $lecture_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

//        $request->validate([
//            'title' => ['required', 'string', 'max:255'],
//            'content' => ['required', 'string', 'max:255'],
//            'file[]' => ['file']
//        ]);

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'file[]' => ['file'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '첨부파일 형식이 잘못됬습니다.'];
        }

        $files = [];

        if ($request->file) {
            foreach ($request->file as $file) {
                $fileRealName = $file->getClientOriginalName();
                $fileName = uniqid();

                $files[] = [ 'fileName' => $fileName, 'fileRealName' => $fileRealName ];
                Storage::putFileAs('public/notice', $file, $fileName);
            }
        }

        $newNotice = Notice::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'file' => $files,
            'lecture_id' => $lecture_id,
        ]);

        return ['status' => 'success', 'content' => route('lecture.notice.detailView', ['lecture_id' => $lecture_id, 'notice_id' => $newNotice['id']])];
    }

    function noticeEditView(Request $request, $lecture_id, $notice_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $lecture = Lecture::find($lecture_id);
        $notice = Notice::find($notice_id);

        return view('lecture.notice_edit', ['lecture_id' => $lecture_id, 'notice' => $notice, 'lecture' => $lecture]);
    }

    function noticeEdit(Request $request, $lecture_id, $notice_id) {
        $lecture = Lecture::find($lecture_id);
        if (!$request['isOwn']) {
            return ['status' => 'error 2', 'content' => route('lecture.noticeView', ['lecture_id' => $lecture_id, 'lecture' => $lecture])];
        }

        $notice = Notice::find($notice_id);
        if (!$notice) {
            return ['status' => 'error 2', 'content' => route('lecture.noticeView', ['lecture_id' => $lecture_id, 'lecture' => $lecture])];
        }

        if ($notice['lecture_id'] != $lecture_id) {
            return ['status' => 'error 2', 'content' => route('lecture.noticeView', ['lecture_id' => $lecture_id, 'lecture' => $lecture])];
        }

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'file[]' => ['file'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '첨부파일 형식이 잘못됬습니다.'];
        }

        $files = [];

        if ($request->existFileList) {
            $exist_file_list = explode(',', $request->existFileList);

            for ($i = 0; $i < count($exist_file_list);$i++) {
                if (!$exist_file_list[$i]) {
                    Storage::delete('public/notice/'.$notice->file[$i]->fileName);
                }
                else {
                    $files[] = $notice->file[$i];
                }
            }
        }

        if ($request->file) {
            foreach ($request->file as $file) {
                $fileRealName = $file->getClientOriginalName();
                $fileName = uniqid();

                $files[] = [ 'fileName' => $fileName, 'fileRealName' => $fileRealName ];
                Storage::putFileAs('public/notice', $file, $fileName);
            }
        }

        $notice->update([
            'title' => $request->title,
            'content' => $request->content,
            'file' => $files,
            'lecture_id' => $request['lecture_id'],
        ]);

        return ['status' => 'success', 'content' => route('lecture.notice.detailView', ['lecture_id' => $lecture_id, 'notice_id' => $notice->id])];
    }

    function noticeDetailView(Request $request, $lecture_id, $notice_id) {
        $notice = Notice::find($notice_id);
        $lecture = Lecture::find($lecture_id);

        return view('lecture.notice_detail', ['lecture_id' => $lecture_id, 'notice' => $notice, 'lecture' => $lecture]);
    }

    function noticeDelete(Request $request, $lecture_id, $notice_id) {
        $notice = Notice::find($notice_id);
        if ($notice['lecture_id'] != $lecture_id || !$request['isOwn']) {
            return redirect()->back();
        }

        if ($notice['file']) {
            for ($i = 0;$i < count($notice['file']);$i++) {
                Storage::delete('public/notice/'.$notice['file'][$i]->fileName);
            }
        }

        $notice->delete();

        return redirect()->back()->with(['success' => true]);
    }
    /** End Notice */

    /** Archive */
    function archiveView(Request $request, $lecture_id) {
//        $archives = Archive::where('lecture_id', $lecture_id)->orderBy('id', 'desc')->paginate(10);
        $lecture = Lecture::find($lecture_id);

        $archives = Archive::where('lecture_id', $lecture_id)->orderBy('id', 'desc')->get();
        $data = [];
        $index = $archives->count();

        foreach($archives as $archive) {
            $data[] = ['index'=> $index--, 'title' => $archive->title, 'created' => date('Y.m.d', strtotime($archive->created_at)), 'id' => $archive->id];
        }

        $perPage = 10;

        $data = collect($data);

        $paginate = new LengthAwarePaginator(
            $data->forPage(Paginator::resolveCurrentPage(), $perPage),
            $data->count(),
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('lecture.archive_view', ['data' => $paginate, 'lecture_id' => $lecture_id, 'lecture' => $lecture]);
    }

    function archiveWriteView(Request $request, $lecture_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $lecture = Lecture::find($lecture_id);

        return view('lecture.archive_write', ['lecture_id' => $lecture_id, 'lecture' => $lecture]);
    }

    function archiveWrite(Request $request, $lecture_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

//        $request->validate([
//            'title' => ['required', 'string', 'max:255'],
//            'content' => ['required', 'string', 'max:255'],
//            'file[]' => ['file']
//        ]);

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'file[]' => ['file'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '첨부파일 형식이 잘못됬습니다.'];
        }

        $files = [];

        if ($request->file) {
            foreach ($request->file as $file) {
                $fileRealName = $file->getClientOriginalName();
                $fileName = uniqid();

                $files[] = [ 'fileName' => $fileName, 'fileRealName' => $fileRealName ];
                Storage::putFileAs('public/archive', $file, $fileName);
            }
        }

        $newArchive = Archive::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'file' => $files,
            'lecture_id' => $lecture_id,
        ]);

        return ['status' => 'success', 'content' => route('lecture.archive.detailView', ['lecture_id' => $lecture_id, 'archive_id' => $newArchive['id']])];
    }

    function archiveEditView(Request $request, $lecture_id, $archive_id) {
        if (!$request['isOwn']) {
            return redirect()->back();
        }

        $archive = Archive::find($archive_id);

        $lecture = Lecture::find($lecture_id);

        return view('lecture.archive_edit', ['lecture_id' => $lecture_id, 'archive' => $archive, 'lecture' => $lecture]);
    }

    function archiveEdit(Request $request, $lecture_id, $archive_id) {
        $lecture = Lecture::find($lecture_id);
        if (!$request['isOwn']) {
            return ['status' => 'error 2', 'content' => route('lecture.archiveView', ['lecture_id' => $lecture_id, 'lecture' => $lecture])];
        }

        $archive = Archive::find($archive_id);
        if (!$archive) {
            return ['status' => 'error 2', 'content' => route('lecture.archiveView', ['lecture_id' => $lecture_id, 'lecture' => $lecture])];
        }

        if ($archive['lecture_id'] != $lecture_id) {
            return ['status' => 'error 2', 'content' => route('lecture.archiveView', ['lecture_id' => $lecture_id, 'lecture' => $lecture])];
        }

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '필수입력사항을 모두 입력해주세요.'];
        }
        $validator = Validator::make($request->all(), [
            'file[]' => ['file'],
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'content' => '첨부파일 형식이 잘못됬습니다.'];
        }

        $files = [];

        if ($request->existFileList) {
            $exist_file_list = explode(',', $request->existFileList);

            for ($i = 0; $i < count($exist_file_list);$i++) {
                if (!$exist_file_list[$i]) {
                    Storage::delete('public/archive/'.$archive->file[$i]->fileName);
                }
                else {
                    $files[] = $archive->file[$i];
                }
            }
        }

        if ($request->file) {
            foreach ($request->file as $file) {
                $fileRealName = $file->getClientOriginalName();
                $fileName = uniqid();

                $files[] = [ 'fileName' => $fileName, 'fileRealName' => $fileRealName ];
                Storage::putFileAs('public/archive', $file, $fileName);
            }
        }

        $archive->update([
            'title' => $request->title,
            'content' => $request->content,
            'file' => $files,
            'lecture_id' => $request['lecture_id'],
        ]);

        return ['status' => 'success', 'content' => route('lecture.archive.detailView', ['lecture_id' => $lecture_id, 'archive_id' => $archive->id])];
    }

    function archiveDetailView(Request $request, $lecture_id, $archive_id) {
        $archive = Archive::find($archive_id);
        $lecture = Lecture::find($lecture_id);

        return view('lecture.archive_detail', ['lecture_id' => $lecture_id, 'archive' => $archive, 'lecture' => $lecture]);
    }

    function archiveDelete(Request $request, $lecture_id, $archive_id) {
        $archive = Archive::find($archive_id);
        if ($archive['lecture_id'] != $lecture_id || !$request['isOwn']) {
            return redirect()->back();
        }

        if ($archive['file']) {
            for ($i = 0;$i < count($archive['file']);$i++) {
                Storage::delete('public/archive/'.$archive['file'][$i]->fileName);
            }
        }

        $archive->delete();

        return redirect()->back()->with(['success' => true]);
    }
    /** End Archive */

    /** Lecture */
    function mainView(Request $request) {
//        $lectures = DB::table('lectures')
//            ->leftJoin('members', 'lectures.id', '=', 'members.lecture_id')
//            ->select('lectures.*', 'members.user_id as member_user_id')
//            ->orWhere('lectures.user_id', '=', $request['user']->id)
//            ->orWhere('members.user_id', '=', $request['user']->id)
//            ->paginate(10);

//        $lectures =
//            DB::table('lectures')
//            ->join('members', function($join){
//                $join->on('lectures.id', '=','members.lecture_id')
//                    ->where('members.user_id', '=', Auth::user()->id);
//            })
//            ->paginate(10);

//        $lectures = Members::where('user_id', Auth::id())->lecture()->paginate(10);
//        $lectures = Lecture::with('members')->where('members.user_id', Auth::id())->paginate(10);
//        $lectures = Lecture::whereHas('members', function($query) { return $query->where('user_id', Auth::id()); })->orderBy('id', 'desc')->paginate(10);
        $myLectures = Lecture::where('user_id', Auth::id());
        $lecture_count = $myLectures->count();
        $myLectures = $myLectures->orderBy('id','desc')->get();

        $lectures = Lecture::whereHas('members', function($query) { return $query->where('user_id', Auth::id()); })->orderBy('id', 'desc')->get();
        $index = $lectures->count();
        $data = [];
        foreach($lectures as $lecture) {
            $created = date('Y.m.d', strtotime($lecture->created_at));
            $data[] = ['index' => $index--, 'lecture' => $lecture];
        }

        $perPage = 10;

        $data = collect($data);

        $paginate = new LengthAwarePaginator(
            $data->forPage(Paginator::resolveCurrentPage(), $perPage),
            $data->count(),
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('lecture.main', ['lectures' => $paginate, 'lecture_count' => $lecture_count, 'my_lectures' => $myLectures]);//, 'items' => $items]);
    }

    function join(Request $request) {
        $messages = [
            'required' => '잘못된 입장코드입니다.',
        ];

        $validator = Validator::make($request->all(), [
            'lecture_code' => ['required'],
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $lecture = Lecture::where('lecture_code', $request['lecture_code'])->first();

        if (!$lecture) {
            $validator->errors()->add('lecture_code', '잘못된 입장코드입니다.');
            return redirect()->back()->withErrors($validator);
        }

        if ($lecture->user_id === $request['user']->id) {
            $validator->errors()->add('lecture_code', '해당 강의의 소유자입니다.');
            return redirect()->back()->withErrors($validator);
        }

        $member = Members::where('lecture_id', $lecture->id)->where('user_id', $request['user']->id)->first();

        if ($member) {
            $validator->errors()->add('lecture_code', '해당 강의를 이미 수강중입니다.');
            return redirect()->back()->withErrors($validator);
        }

        $member = Members::create([
            'lecture_id' => $lecture->id,
            'user_id' => $request['user']->id,
            'score' => 0
        ]);

        if (!$member) {
            $validator->errors()->add('lecture_code', '강의를 생성할 수 없습니다.');
            return redirect()->back()->withErrors($validator);
        }

        return redirect()->back();
    }

    function lectureView(Request $request, $lecture_id) {
        $lecture =  Lecture::find($lecture_id);
        $notices = Notice::where('lecture_id', $lecture_id)->orderBy('id', 'desc')->take(4)->get();
        $archives = Archive::where('lecture_id', $lecture_id)->orderBy('id', 'desc')->take(4)->get();
        $qnas = qna::where('lecture_id', $lecture_id)->orderBy('id', 'desc')->take(4)->get();
        $classes = Classes::where('lecture_id', $lecture_id)->orderBy('active_start_date', 'desc')->take(5)->get();
        $classes_count = Classes::where('lecture_id', $lecture_id)->count();

        $yesterday = strtotime(date('yy-m-d', strtotime('-1 days')));

        $notices->new = false;
        foreach($notices as $notice) {
            if (strtotime($notice->created_at) > $yesterday) {
                $notice->new = true;
                $notices->new = true;
            }
            else {
                $notice->new = false;
            }
        }

        $archives->new = false;
        foreach($archives as $archive) {
            if (strtotime($archive->created_at) > $yesterday) {
                $archive->new = true;
                $archives->new = true;
            }
            else {
                $archive->new = false;
            }
        }

        $qnas->new = false;
        foreach($qnas as $qna) {
            if (strtotime($qna->created_at) > $yesterday) {
                $qna->new = true;
                $qnas->new = true;
            }
            else {
                $qna->new = false;
            }
        }

        return view('lecture.lecture_view', ['lecture' => $lecture, 'notices' => $notices, 'archives' => $archives, 'qnas' => $qnas, 'classes' => $classes, 'member_count' => $lecture->members()->count(), 'classes_count' => $classes_count]);
    }

    function infoView(Request $request) {
        $lecture = Lecture::find($request['lecture_id']);
        return view('lecture.info', ['lecture' => $lecture, 'lecture_id', $lecture->id]);
    }

    function analysisView(Request $request, $lecture_id) {
//            $classes = Classes::where('lecture_id', $lecture_id)->orderBy('id', 'desc')->paginate(10);
        $lecture = Lecture::find($lecture_id);

        $classes = Classes::where('lecture_id', $lecture_id)->orderBy('id', 'desc')->get();

        $data = [];

        $index = $classes->count();
        foreach ($classes as $class) {
            $slides = $class->slides()->get();

            $reseach = 0;
            $quiz = 0;
            $common = 0;

            foreach ($slides as $slide) {
                switch ($slide->type) {
                    case 'multiple_choice':
                    case 'short_answer':
                        if ($slide->activation_answer) {
                            $quiz++;
                        }
                        else {
                            $reseach++;
                        }
                        break;
                    case 'text':
                        $common++;
                        break;
                    case 'image':
                        $common++;
                        break;
                    case 'text_image':
                        $common++;
                        break;
                    default:
                        $common++;
                        break;
                }
            }

            $total = $reseach + $quiz + $common;

            if (request()->get('isOwn')) {
                $data[] = ['id' => $class->id,'index' => $index--, 'name' => $class->name, 'created' => date('Y.m.d', strtotime($class->created_at)), 'slides' => $total.'('.$reseach.','.$quiz.','.$common.')', 'attempt' => '0'];
            }
            else {
                $data[] = ['id' => $class->id,'index' => $index--, 'name' => $class->name, 'created' => '참여일', 'slides' => $total.'('.$reseach.','.$quiz.','.$common.')'];
            }
        }

        $perPage = 10;

        $data = collect($data);

        $paginate = new LengthAwarePaginator(
            $data->forPage(Paginator::resolveCurrentPage(), $perPage),
            $data->count(),
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('lecture.analysis', ['lecture_id' => $lecture_id, 'classes' => $paginate, 'lecture' => $lecture]);
    }

    function analysisGraphDetailView(Request $request, $lecture_id, $class_id) {
        $lecture = Lecture::find($lecture_id);
        $class = Classes::find($class_id);

        if (!$class) {
            return redirect()->back()->with(['error' => '수업 없음 에러임 이부분 나중에 수정']);
        }

        if (request()->get('isOwn')) {
            $progress = Progress::where('class_id', $class_id)->first();

            if (!$progress) {
                return redirect()->back()->with(['error' => '수업진행 안했음 이부분 나중에 수정']);
            }

            $answers = Answer::where('lecture_id', $lecture_id)->where('class_id', $class_id)->get();

            if (!$answers) {
                return redirect()->back()->with(['error' => '수업은 진행 했지만 퀴즈는 진행한 적이 없음 이부분 나중에 수정']);
            }

            $slides = Slides::where('class_id', $class_id)->whereIn('type', ['multiple_choice', 'short_answer'])->get();

            if (!$slides) {
                return redirect()->back()->with(['error' => '퀴즈 관련 슬라이드가 없음 이부분 나중에 수정']);
            }

            //sorting
            $slides_num = $class->slides_num;
            
            if (!$slides_num) {
                return redirect()->back()->with(['error' => '수업 진행 후 슬라이드 삭제 등 꼬임 이부분 나중에 수정']);
            }

            $ordered = [];
            $data = [];
            $data['order'] = [];
            $data['layout'] = [];
            $data['num'] = [];
            $data['question'] = [];
            for ($i = 0;$i < count($slides_num); $i++) {
                for ($j = 0;$j < count($slides); $j++) {
                    if ($slides_num[$i] === $slides[$j]->id) {
                        $ordered[] = $slides[$j];
                        $data['num'][] = $i + 1;
                        $data['order'][] = $slides_num[$i];
                        $data['question'][] = $slides[$j]->slide_content->question;
                        $data['layout'][] = $slides[$j]->slide_content->resultLayout;
                    }
                }
            }

            $data['data'] = [];
            foreach($ordered as $order) {
                if ($order->type == 'multiple_choice') {
                    $answer = $order->slide_content->answers;

                    $data['data'][$order->id] = [];
                    foreach($answer as $a) {
                        $data['data'][$order->id][] = ['name' => $a->answer, 'value' => 0];
                    }

                    if (!!$answers->count()) {
                        $answer = $answers->where('slide_id', $order->id);

                        if (!!$answer->count()) {
                            foreach($answer as $a) {
                                $data['data'][$order->id][$a->answer_data]['value'] = $data['data'][$order->id][$a->answer_data]['value'] + 1;
                            }
                        }
                    }
                }
                else {
                    $answer = $order->slide_content->answer;

                    $data['data'][$order->id] = [];
                    $data['data'][$order->id][] = ['name' => $answer, 'value' => 0];

                    if (!!$answers->count()) {
                        $answer = $answers->where('slide_id', $order->id);

                        if (!!$answer->count()) {
                            foreach($answer as $a) {
                                $flag = false;
                                foreach($data['data'][$order->id] as $an) {
                                    if (property_exists($an, 'name')) {
                                        if ($an['name'] == $a->answer_data) {
                                            $an->value += 1;
                                            $flag = true;
                                            break;
                                        }
                                    }
                                }

                                if (!$flag) {
                                    $data['data'][$order->id][] = ['name' => $a->answer_data, 'value' => 1];
                                }

//                                if (property_exists($data['data'][$order->id], $a->answer_data)) {
//                                    $data['data'][$order->id][$a->answer_data]['value'] = $data['data'][$order->id][$a->answer_data]['value'] + 1;
//                                }
//                                else {
//                                    $data['data'][$order->id][$a->answer_data] = ['name' => $a->answer_data, 'value' => 1];
//                                }
                            }
                        }
                    }
                }
            }

            return view('lecture.analysis_graph_detail', ['lecture_id' => $lecture_id, 'lecture' => $lecture, 'class_id' => $class_id, 'class' => $class, 'data' => $data]);
        }
        else {
            return redirect()->back();
        }
    }

    function analysisListDetailView(Request $request, $lecture_id, $class_id) {
        if (!request()->get('isOwn')) {
            return redirect()->back();
        }

        $lecture = Lecture::find($lecture_id);

        $class = Classes::find($class_id);

        if (!$class) {
            return redirect()->back()->with(['error' => '클래스 없음 비정상 적인 접근 나중에 수정 해야함']);
        }

        $slides = $class->slides()->get();

        $slides_num = $class->slides_num;

        for ($i = 0;$i < count($slides_num);$i++) {
            for ($j = 0;$j < $slides->count();$j++) {
                if ($slides_num[$i] == $slides[$j]->id) {
                    $temp = $slides[$i];
                    $slides[$i] = $slides[$j];
                    $slides[$j] = $temp;
                }
            }
        }

        $data = [];

        for ($i = 0;$i < $slides->count();$i++) {
            $answers = null;
            if (!!$lecture->use_nickname) {
                $answers = Answer::select('answer_data', 'user_id')->where('slide_id', $slides[$i]->id)->with('user:id,nickname')->get();
            }
            else {
                $answers = Answer::select('answer_data', 'user_id')->where('slide_id', $slides[$i]->id)->with('user:id,name')->get();
            }

//            $answers = Answer::with('user:id,name,nickname')->get();
//            $answers_data = [];

//            if ($slides[$i]->type == 'multiple_choice') {
//                $_answers_data = DB::table('answers')->select('answer_data', DB::raw('count(answer_data) as count'))->orderBy('answer_data', 'asc')->groupBy('answer_data')->get();
//
//                foreach ($_answers_data as $_a) {
//                    $answers_data[$_a['answer_data']] = $_a['count'];
//                }
//            }

            $scores = null;
            if (!!$lecture->use_nickname) {
                $scores = Answer::select('score', 'result', 'user_id')->where('slide_id', $slides[$i]->id)->with('user:id,nickname')->orderBy('score', 'desc')->get();
            }
            else {
                $scores = Answer::select('score', 'result', 'user_id')->where('slide_id', $slides[$i]->id)->with('user:id,nickname')->orderBy('score', 'desc')->get();
            }

            $correct = $scores->where('result', '1')->count();
            $incorrect = $scores->count() - $correct;

            $correct_rate = null;
            if (!!$slides[$i]->activation_answer) {
                if ($correct + $incorrect != 0) {
                    $correct_rate = floor(($correct) / ($correct + $incorrect) * 100 * 100);
                    $correct_rate /= 100;
                    $correct_rate = $correct_rate.'%';
                }
            }

            $data[$i] = ['index' => $i + 1, 'slide_type' => $slides[$i]->type, 'attempt_rate' => 'x%', 'correct_rate' => $correct_rate, 'ratings' => null, 'answers' => null];

            if ($slides[$i]->type == 'multiple_choice' || $slides[$i]->type == 'short_answer') {
                if (!!$slides[$i]->activation_answer && !!$slides[$i]->activation_score) {
                    $data[$i]['ratings'] = $scores->toArray();
                }
            }

            $data[$i]['answers'] = $answers->toArray();
        }

        $perPage = 10;

        $data = collect($data);

        $paginate = new LengthAwarePaginator(
            $data->forPage(Paginator::resolveCurrentPage(), $perPage),
            $data->count(),
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]//url('http://www.plushdev.com/lecture/analysis/1/analysis/82/list')]
        );

        return view('lecture.analysis_list_detail', ['lecture_id' => $lecture_id, 'class_id' => $class_id, 'class' => $class, 'lecture' => $lecture, 'pagination' => $paginate]);
    }

    function analysisStudentDetailView(Request $request, $lecture_id, $class_id) {
        if (request()->get('isOwn')) {
            return redirect()->back();
        }

        $lecture = Lecture::find($lecture_id);
        $class = Classes::find($class_id);

        $slides_num = $class->slides_num;
        $slides = $class->slides()->select('id', 'type')->get();

        $ordered = [];
        $data = [];

        if ($slides_num) {
            foreach($slides_num as $num) {
                foreach($slides as $slide) {
                    if ($num == $slide->id) {
                        $ordered[] = $slide;
                    }
                }
            }

            $index = 1;
            foreach($ordered as $order) {
                $answers = $order->answer()->select('result', 'score', 'answer_data', 'user_id')->get();

                $correct_rate = '';
                $rank = '';
                $total = $answers->count();
                $myAnswer = ['answer_data' => '', 'result' => ''];
                $attempt = false;
                if ($total > 0) {
                    $correct = $answers->where('result', '1')->count();
                    $correct_rate = ($correct / $total) * 100 * 100;
                    $correct_rate /= 100;
                    $correct_rate = $correct_rate.'%';

                    $myAnswer = $answers->where('user_id', Auth::id())->first();

                    if ($myAnswer) {
                        if ($order->type == 'multiple_choice') {
                            $myAnswer->answer_data++;

                            $rank = $answers->where('score', '>', $myAnswer->score)->count() + 1;
                            $rank = $rank.'/'.$answers->count();
                        }

                        $attempt = true;
                    }
                    else {
                        $myAnswer = ['answer_data' => '', 'result' => ''];
                    }
                }

                $data[] = ['index' => $index++, 'type' => $order->type, 'attempt' => $attempt, 'correct_rate' => $correct_rate, 'rank' => $rank, 'answer' => $myAnswer['answer_data'], 'is_answer' => $myAnswer['result']];
            }
        }

        return view('lecture.analysis_student', ['lecture_id' => $lecture_id, 'class_id' => $class_id, 'lecture' => $lecture, 'class' => $class, 'data' => $data]);
    }

    function writeView(Request $request) {
        $lecture = null;
        // 복사하기 이용 시 lecture를 조회하여 값을 뿌려줍니다.
        if ($request->query('id')) {
            $lecture = Lecture::find($request->query('id'));
        }
        $lecture_code = strtoupper(uniqid());
        return view('lecture.write', [ "lecture_code" => $lecture_code, "lecture" => $lecture ]);
    }

    function createLectureCode(Request $request) {
        $lectureCode = strtoupper(uniqid());
        return $lectureCode;
    }

    function editView(Request $request) {
        $lecture = Lecture::find($request['id']);

        if (!$lecture || $lecture['user_id'] != $request['user']->id) {
            return redirect()->back();
        }

        return view('lecture.edit', ['lecture' => $lecture]);
    }

    function delete(Request $request) {
        $lecture = Lecture::find($request['id']);
        if ($lecture && $lecture['user_id'] == $request['user']->id) {
            $classes = Classes::where('lecture_id', $lecture->id)->get();

            foreach ($classes as $class) {
                $slides = Slides::where('class_id', $class->id)->get();

                foreach ($slides as $slide) {
                    if ($slide->type === 'image' || $slide->type === 'text_image') {
//                        return dd($slide->slide_content->imgUrl);
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
                }
            }

            $lecture->delete();

//            return view('lecture.mainView', ['complete' => true]);
        }

        return redirect()->back();
    }

    function edit(Request $request) {
        $lecture = Lecture::find($request['id']);

        if (!$lecture || $lecture['user_id'] != $request['user']->id) {
            return redirect()->back();
        }

        $request->validate([
            'lecture_code' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'lecture_goal_desc' => ['required', 'string', 'max:255'],
            'lecture_start_date' => ['required', 'date_format:Y-m-d'],
            'lecture_end_date' => ['required', 'date_format:Y-m-d', 'after:lecture_start_date'],
            'class_title' => ['required', 'array'],
            'class_desc' => ['required', 'array'],
            'eval_factor' => ['required', 'array'],
            'eval_ratio' => ['required', 'array'] ]);

        // lecture code timestamp 검증. 현재 이 후의 timestamp 값은 허용하지 않음. (악의적인 수정이라 판단)
        try {
            if (
                strlen($request['lecture_code']) < 8
                || hexdec(substr($request['lecture_code'],0,8)) > hexdec(substr(uniqid(),0,8))
            ) {
                throw new Exception('Wrong Lecture Code');
            }
        } catch (Exception $e) {
            return redirect()->back();
        }

        $classes = [];
        $eval = [];

        try {
            // 주차 별 수업 안내 파라미터 검증
            if ($request['use_classes']) {
                if (count($request['class_title']) !== count($request['class_desc'])) {
                    throw new Exception('List item length not matched.');
                }

                for ($i = 0; $i < count($request['class_title']); $i++) {
                    if (
                        strlen(trim($request['class_title'][$i])) <= 0
                        || strlen(trim($request['class_desc'][$i])) <= 0
                    ) throw new Exception('EMPTY CLASS');
                }

                // 주차별 수업안내 객체 생성
                for ($i = 0; $i < count($request['class_title']); $i++) {
                    $classes[] = ['title' => $request['class_title'][$i], 'desc' => $request['class_desc'][$i]];
                }
            }

            if ($request['use_evaluation']) {
                // 평가 방법 파라미터 검증
                if (count($request['eval_factor']) !== count($request['eval_ratio'])) {
                    throw new Exception('List item length not matched.');
                }

                for ($i = 0; $i < count($request['eval_factor']); $i++) {
                    if (
                        strlen(trim($request['eval_factor'][$i])) <= 0
                        || strlen(trim($request['eval_ratio'][$i])) <= 0
                    ) throw new Exception('EMPTY EVALUATION');
                }

                // 평가방법 객체 생성
                for ($i = 0; $i < count($request['eval_factor']); $i++) {
                    $eval[] = ['factor' => $request['eval_factor'][$i], 'ratio' => $request['eval_ratio'][$i]];
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(
                [$e->getMessage() => $e->getMessage()]
            );
        }

        $lecture->update([
            'lecture_code' => $request['lecture_code'],
            'name' => $request['name'],
            'description' => $request['description'],
            'lecture_goal_desc' => $request['lecture_goal_desc'],
            'lecture_start_date' => $request['lecture_start_date'],
            'lecture_end_date' => $request['lecture_end_date'],
            'use_nickname' => $request['use_nickname'] ? true : false,
            'use_classes' => $request['use_classes'] ? true : false,
            'use_evaluation' => $request['use_evaluation'] ? true : false,
            'classes' => $classes,
            'evaluation' => $eval,
            'user_id' => $request['user']->id
        ]);

        return redirect()->back()->with(['success' => true]);
    }

    function write(Request $request) {
        $request->validate([
            'lecture_code' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'lecture_goal_desc' => ['required', 'string', 'max:255'],
            'lecture_start_date' => ['required', 'date_format:Y-m-d'],
            'lecture_end_date' => ['required', 'date_format:Y-m-d', 'after:lecture_start_date'],
            'class_title' => ['required', 'array'],
            'class_desc' => ['required', 'array'],
            'eval_factor' => ['required', 'array'],
            'eval_ratio' => ['required', 'array'] ]);

        // lecture code timestamp 검증. 현재 이 후의 timestamp 값은 허용하지 않음. (악의적인 수정이라 판단)
        try {
            if (
                strlen($request['lecture_code']) < 8
                || hexdec(substr($request['lecture_code'],0,8)) > hexdec(substr(uniqid(),0,8))
            ) {
                throw new Exception('Wrong Lecture Code');
            }
        } catch (Exception $e) {
            return redirect()->back();
        }

        $classes = [];
        $eval = [];

        try {
            // 주차 별 수업 안내 파라미터 검증
            if ($request['use_classes']) {
                if (count($request['class_title']) !== count($request['class_desc'])) {
                    throw new Exception('List item length not matched.');
                }

                for ($i = 0; $i < count($request['class_title']); $i++) {
                    if (
                        strlen(trim($request['class_title'][$i])) <= 0
                        || strlen(trim($request['class_desc'][$i])) <= 0
                    ) throw new Exception('EMPTY CLASS');
                }

                // 주차별 수업안내 객체 생성
                for ($i = 0; $i < count($request['class_title']); $i++) {
                    $classes[] = ['title' => $request['class_title'][$i], 'desc' => $request['class_desc'][$i]];
                }
            }

            if ($request['use_evaluation']) {
                // 평가 방법 파라미터 검증
                if (count($request['eval_factor']) !== count($request['eval_ratio'])) {
                    throw new Exception('List item length not matched.');
                }

                for ($i = 0; $i < count($request['eval_factor']); $i++) {
                    if (
                        strlen(trim($request['eval_factor'][$i])) <= 0
                        || strlen(trim($request['eval_ratio'][$i])) <= 0
                    ) throw new Exception('EMPTY EVALUATION');
                }

                // 평가방법 객체 생성
                for ($i = 0; $i < count($request['eval_factor']); $i++) {
                    $eval[] = ['factor' => $request['eval_factor'][$i], 'ratio' => $request['eval_ratio'][$i]];
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(
                [$e->getMessage() => $e->getMessage()]
            );
        }

        $lecture = Lecture::create([
            'lecture_code' => $request['lecture_code'],
            'name' => $request['name'],
            'description' => $request['description'],
            'lecture_goal_desc' => $request['lecture_goal_desc'],
            'lecture_start_date' => $request['lecture_start_date'],
            'lecture_end_date' => $request['lecture_end_date'],
            'use_nickname' => $request['use_nickname'] ? true : false,
            'use_classes' => $request['use_classes'] ? true : false,
            'use_evaluation' => $request['use_evaluation'] ? true : false,
            'classes' => $classes,
            'evaluation' => $eval,
            'user_id' => $request['user']->id
        ]);

        Members::create([
            'lecture_id' => $lecture->id,
            'user_id' => $request['user']->id
        ]);

        return redirect()->back()->with(['success' => true]);
    }
    /** End Lecture */
}
