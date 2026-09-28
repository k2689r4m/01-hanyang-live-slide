<!DOCTYPE html>
<html lang="ko">
<head class="header">
    <title>@yield('title')</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{--    <link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}
    <link href="{{ asset('css/myclass.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link href="{{ asset('jquery/jquery-ui-1.12.1.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slide.css') }}" rel="stylesheet">
    <script src="{{ asset('jquery/jquery-1.12.4.js') }}"></script>
    <script src="{{ asset('jquery/jquery-ui-1.12.1.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/d3.js') }}"></script>
{{--    <script src="{{asset('js/radial-progress-bar.js')}}" defer></script>--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        @yield('script')
            window.onload = () => {
            @yield('login.script')
            @yield('user.myinfo.script')
            @yield('user.secession.script')
            @yield('archive.script')
            @yield('notice.script')
            @yield('qna.script')
            @yield('lecture.write.script')
            @yield('lecture.edit.script')
            @yield('lecture.main.script')
        }
    </script>

</head>
<body>
<header class="header" id="slid_header">
    <h1 class="header__logo cp" onclick="location.href=`{{ route('lecture.mainView') }}`">헤더로고</h1>
    <ul class="top-menu">
        @auth
            <li class="top-menu__item"><a href="{{ route('user.logout') }}" class="t-primary">로그아웃</a></li>
            @php
                $lecture_exist = false;
            @endphp
            @isset ($lecture_id)
                @php
                    $lecture_exist = true;
                @endphp
            @endisset
            @isset ($lecture)
                @php
                    $lecture_exist = true;
                @endphp
            @endisset
            @isset ($lectures)
                @php
                    $lecture_exist = false;
                @endphp
            @endisset
            @if ($lecture_exist)
                <li class="top-menu__item"><a href="{{ route('lecture.lectureView', ['lecture_id' => $lecture_id ?? $lecture->id]) }}">내강의실</a></li>
            @endif
            <li class="top-menu__item"><a href="{{ route('user.myInfoView') }}">마이페이지</a></li>
        @elseauth
            <li class="top-menu__item"><a href="{{ route('user.loginView') }}" class="t-primary">로그인</a></li>
            <li class="top-menu__item"><a href="{{ route('user.register') }}">회원가입</a></li>
        @endauth
    </ul>
    <ul class="h-menu">
        <li class="h-menu__item"><a href="javascript:;">서비스소개</a></li>
        <li class="h-menu__item"><a href="javascript:;">요금</a></li>
        <li class="h-menu__item"><a href="{{ route('request.writeView') }}">문의하기</a></li>
    </ul>
    <ul class="h-menu__depth2">
        <li><a href="javascript:;">서비스 소개</a></li>
        <li><a href="javascript:;">요금제 소개</a></li>
        <li><a href="{{ route('request.writeView') }}">문의하기</a></li>
        <li><a href="javascript:;">세부기능</a></li>
    </ul>
</header>
@yield('header')
@yield('sidebar')
@yield('content')
<footer class="footer" id="slid_footer">
    <div class="footer__wrap">
        <ul class="footer-menu">
            <li class="footer-menu__item">회사소개 및 서비스소개</li>
            <li class="footer-menu__item">개인정보처리방침</li>
            <li class="footer-menu__item">이용약관</li>
        </ul>
        <ul class="company-info">
            <li class="company-info__item">사업자 : 교육 슬라이드</li>
            <li class="company-info__item">우편 : 100-100</li>
            <li class="company-info__item">주소 : 서울시 서울구 서울동 서울로 123456</li>
            <li class="company-info__item">TEL : 070-1234-5678</li>
            <li class="company-info__item">COPYRIGHT(c) . ALL RIGHTS RESERVED</li>
        </ul>
        <h1 class="footer__logo">하단로고</h1>
    </div>
</footer>
</body>
</html>
