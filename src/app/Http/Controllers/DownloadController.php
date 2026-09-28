<?php

namespace App\Http\Controllers;

use App\Archive;
use App\qna;
use App\Notice;
use App\Slides;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    function qnaDownload(Request $request, $lecture_id, $qna_id, $file_name) {
        $qna = qna::find($qna_id);
        $lock = false;

        if ($qna) {
            $lock = $qna->lock;
        }

        if (!$qna || (!$request['isOwn'] && $lock && $request['user']->id != $qna->user_id)) {
            return redirect()->back();
        }

        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $path = $storagePath.'public/qna/'.$file_name;
        $downloadName = $request->input('download_name');

        return response()->download($path, $downloadName ?? $file_name);
    }

    function noticeDownload(Request $request, $lecture_id, $notice_id, $file_name) {
        $notice = Notice::find($notice_id);

        if (!$notice) {
            return redirect()->back();
        }

        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $path = $storagePath.'public/notice/'.$file_name;
        $downloadName = $request->input('download_name');

        return response()->download($path, $downloadName ?? $file_name);
    }

    function archiveDownload(Request $request, $lecture_id, $archive_id, $file_name) {
        $archive = Archive::find($archive_id);

        if (!$archive) {
            return redirect()->back();
        }

        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $path = $storagePath.'public/archive/'.$file_name;
        $downloadName = $request->input('download_name');

        return response()->download($path, $downloadName ?? $file_name);
    }

    function slideImageDownload(Request $request, $lecture_id, $class_id, $slide_id, $file_name) {
        $slide = Slides::find($slide_id);

        if (!$slide && $slide->class_id != $class_id) {
            return redirect()->back();
        }

        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $path = $storagePath.'public/uploads/'.$file_name;

//        return Storage::get($path);
        return response()->file($path);
    }

    function _slideImageDownload(Request $request, $lecture_id, $class_id, $file_name) {
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $path = $storagePath.'public/uploads/'.$file_name;

        return response()->file($path);
    }

    function __slideImageDownload(Request $request, $user_url ,$file_name) {
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $path = $storagePath.'public/uploads/'.$file_name;

        return response()->file($path);
    }
}
