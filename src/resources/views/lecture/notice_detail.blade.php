@extends('layout.sidebar_layout')

@section('title')
    공지사항
@endsection

@section('content')

<div class="page-nav-wrap">
    <ul class="page-nav gray">
        <li class="page-nav__item home cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture_id]) }}'"></li>
        <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.lectureView', ['lecture_id' => $lecture_id]) }}'">내 강의실</li>
        <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.noticeView', ['lecture_id' => $lecture_id]) }} '">공지사항</li>
        <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.notice.detailView', ['lecture_id' => $lecture_id, 'notice_id' => $notice['id']]) }} '">공지사항 상세</li>
    </ul>
</div>
<!-- professor board -->
<div class="content__wrap exist-nav exist-leftmenu round">
    <div class="content analysis__wrap">
        <h2 class="content__tit board-tit">공지사항</h2>
        <div class="board-detail">
            <div class="board-detail__tit">
                <h3 class="tit">{{ $notice['title'] }}</h3>
                <span class="date">{{ date('Y.m.d', strtotime($notice ['created_at'])) }}</span>
                @if (request()->get('isOwn'))
                    <a class="modi" href="{{ route('lecture.notice.editView', ['lecture_id' => $lecture_id, 'notice_id' => $notice['id']]) }}">수정</a><br/>
                @endif
            </div>
            <div class="board-detail__con">
                <p class="con">
                    {{ $notice['content'] }}
                </p>
                @foreach($notice['file'] as $file)
                    <div class="download"><a href="{{ route('lecture.notice.download', ['lecture_id' => $lecture_id, 'notice_id' => $notice['id'], 'file_name' => $file->fileName, 'download_name' => $file->fileRealName]) }}">{{ $file->fileRealName }}</a></div>
                @endforeach

            </div>
        </div>
        <div class="a-center p-30">
            <button class="btn-gray btn-line btn-normal btn-round btn-back" onclick="location.href='{{ route('lecture.noticeView', ['lecture_id' => $lecture_id]) }}'">목록으로</button>
{{--            <a class="btn-gray btn-line btn-normal btn-round btn-back" href="{{ route('lecture.noticeView', ['lecture_id' => $lecture_id]) }}">목록으로</a>--}}
        </div>
    </div>
</div>
@endsection
<!-- //professor board -->


{{--NOTICE DETAIL--}}
{{--<p>{{ $notice['title'] }}</p>--}}
{{--<p>{{ $notice ['created_at'] }}</p>--}}
{{--@if (request()->get('isOwn'))--}}
{{--    <a href="{{ route('lecture.notice.editView', ['lecture_id' => $lecture_id, 'notice_id' => $notice['id']]) }}">수정</a><br/>--}}
{{--@endif--}}
{{--<p>{{ $notice['content'] }}</p>--}}
{{--<hr/>--}}
{{--@foreach($notice['file'] as $file)--}}
{{--    <a href="{{ route('lecture.notice.download', ['lecture_id' => $lecture_id, 'notice_id' => $notice['id'], 'file_name' => $file->fileName, 'download_name' => $file->fileRealName]) }}">{{ $file->fileRealName }}</a><br/>--}}
{{--@endforeach--}}
{{--<hr/>--}}
{{--<a href="{{ route('lecture.noticeView', ['lecture_id' => $lecture_id]) }}">목록으로</a>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}




