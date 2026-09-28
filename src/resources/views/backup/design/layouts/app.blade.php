<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- 클라이언트 요구 한글 폰트 -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- 클라이언트 요구 영어 폰트를 구할 수 없어 임시 폰트 사용  -->
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        html, body, #app {
            padding: 0;
            margin: 0;
            width: 100%;
            height: 100%;
            overflow-x: hidden !important;
            background-color: #fff;
        }
    </style>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
    <div class="roc-modal-container">
        <div class="roc-modal">
            <p class="roc-modal-content"></p>
            <div class="roc-modal-btns">
               <button type="button" class="roc-modal-cancel-btn">취소</button>
                <button type="button" class="roc-modal-ok-btn">확인</button>
            </div>
        </div>
    </div>
    <div class="roc-alert-container">
        <div class="roc-alert">
            <p class="roc-alert-content"></p>
            <div class="roc-alert-btn">
                <button type="button" class="roc-alert-ok-btn">확인</button>
            </div>
        </div>
    </div>
    <div id="app">
        @yield('content')
    </div>
</body>
    <script>
        @yield('script')
    </script>
</html>
