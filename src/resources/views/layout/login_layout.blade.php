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
    <link href="{{ asset('css/slide.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <script src="{{ asset('jquery/jquery-1.12.4.js') }}"></script>
    <script src="{{ asset('jquery/jquery-ui-1.12.1.js') }}"></script>
    <script src="{{ asset('js/d3.js') }}"></script>

    {{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        @yield('script')
            window.onload = () => {
            @yield('login.script')
            @yield('register.script')
        }
    </script>
</head>
<body>
@yield('sidebar')
@yield('content')
<footer class="footer">
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
