@extends('layout.layout')

@section('title')
    @yield('title')
@endsection

@section('modal.content')
    @yield('modal.content')
@endsection

@section('script')
    @yield('script')
@endsection

@section('archive.script')
    @yield('archive.script')
@endsection

@section('header')
{{--    <header class="header">--}}
{{--        <!— <h1 class="header__logo">헤더로고</h1>--}}
{{--        <ul class="h-menu">--}}
{{--            <li class="h-menu__item">서비스소개</li>--}}
{{--            <li class="h-menu__item">내 강의실</li>--}}
{{--            <li class="h-menu__item">게시판</li>--}}
{{--            <li class="h-menu__item">내정보</li>--}}
{{--        </ul>--}}
{{--        <button class="header__right-btn">감나무</button> —>--}}
{{--    </header>--}}
@endsection

@section('sidebar')
    <div class="left-menu">
        <ul class="left-menu__list">
            <li class="left-menu__item tit myclass cp" onclick="location.href=`{{ route('lecture.lectureView', ['lecture_id' => $lecture_id ?? $lecture->id]) }}`">내 강의실</li>
            <li class="left-menu__item"><a href="{{ route('class.mainView', ['lecture_id' => $lecture_id ?? $lecture->id]) }}">{{ $lecture->name }}<br><span class="state">{{ floor((strtotime(now()) - strtotime($lecture->lecture_start_date)) / 60 / 60 / 24 / 7) }}주차 진행 중</span></a></li>
            <li class="left-menu__item @if($lecture->notice()->orderBy('created_at', 'desc')->count() > 0 ? floor((strtotime(now()) - strtotime($lecture->notice()->orderBy('created_at', 'desc')->first()->created_at)) / 60 / 60 / 24) < 1 : false) new @endif"><a href="{{ route('lecture.noticeView', ['lecture_id' => $lecture_id ?? $lecture->id]) }}">공지사항</a></li>
            <li class="left-menu__item @if($lecture->archive()->orderBy('created_at', 'desc')->count() > 0 ? floor((strtotime(now()) - strtotime($lecture->archive()->orderBy('created_at', 'desc')->first()->created_at)) / 60 / 60 / 24) < 1 : false) new @endif"><a href="{{ route('lecture.archiveView', ['lecture_id' => $lecture_id ?? $lecture->id]) }}">자료실(서랍)</a></li>
            <li class="left-menu__item @if($lecture->qna()->orderBy('created_at', 'desc')->count() > 0 ? floor((strtotime(now()) - strtotime($lecture->qna()->orderBy('created_at', 'desc')->first()->created_at)) / 60 / 60 / 24) < 1 : false) new @endif"><a href="{{ route('lecture.qnaView', ['lecture_id' => $lecture_id ?? $lecture->id]) }}">질문답변</a></li>
        </ul>
    </div>
@endsection

@section('content')
    @yield('content')
@endsection