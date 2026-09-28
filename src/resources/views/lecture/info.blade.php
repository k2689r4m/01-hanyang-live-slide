@extends('layout.sidebar_layout')
@section('title')
    기본정보
@endsection

@section('content')
    <ul class="tab-menu">
        {{--            기본정보 <a href="{{ route('class.mainView', ['lecture_id' => $lecture->id]) }}">수업</a> <a href="{{ route('lecture.analysisView', ['lecture_id' => $lecture->id]) }}">통계</a><br/>--}}
        <li class="tab-menu__item active"><a href="">기본정보</a></li>
        <li class="tab-menu__item"><a href="{{ route('class.mainView', ['lecture_id' => $lecture->id]) }}">수업</a></li>
        <li class="tab-menu__item"><a href="{{ route('lecture.analysisView', ['lecture_id' => $lecture->id]) }}">통계</a></li>
    </ul>
    <div class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home cp" onclick="location.href=`{{ route('lecture.mainView') }}`"></li>
            <li class="page-nav__item cp" onclick="location.href=`{{ route('lecture.mainView') }}`">내 강의실</li>
            <li class="page-nav__item cp" onclick="location.href=`{{ route('lecture.infoView', ['lecture_id' => $lecture->id]) }}`">기본정보</li>
        </ul>
    </div>
    <div class="content__wrap exist-nav exist-leftmenu round">
        <div class="content exist-tab">
            <div class="class-info">
                <div class="class-info__sub">
                    <div class="sub">
                        과목명
                        <strong>{{ $lecture['name'] }}</strong>
                    </div>
                    <div class="code">
                        입장 코드
                        <strong>{{ $lecture['lecture_code'] }}</strong>
                    </div>
                </div>
                <h3 class="class-info__tit">과목 소개</h3>
                <ul class="class-info__t-list">
                    {{ $lecture['description'] }}
                </ul>
                <h3 class="class-info__tit">학습 목표</h3>
                <ul class="class-info__t-list">
                    {{ $lecture['lecture_goal_desc'] }}

                </ul>
                <h3 class="class-info__tit">닉네임 사용<span class="btn btn-sm @if($lecture->use_nickname) btn-primary @else btn-gray @endif btn-round">@if ($lecture->use_nickname) ON @else OFF @endif</span></h3>
                <h3 class="class-info__tit">주차별 수업안내</h3>
                <ul class="class-info__time-list">
                    @foreach($lecture['classes'] as $key=>$class)
                        <li>
                            <span class="week">{{ $class->title }}</span>
                            {{ $class->desc }}
                        </li>
                    @endforeach
                </ul>
                <h3 class="class-info__tit">평가방법</h3>
                <ul class="class-info__item-list">
                    @foreach($lecture['evaluation'] as $key=>$evaluation)
                        <li>
                            <span class="item">{{ $evaluation->factor }}</span>
                            <strong>{{ $evaluation->ratio }}</strong>%
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection


{{--<body>--}}
{{--    <!-- header -->--}}
{{--    <header class="header">--}}
{{--        <h1 class="header__logo">헤더로고</h1>--}}
{{--        <ul class="h-menu">--}}
{{--            <li class="h-menu__item">서비스소개</li>--}}
{{--            <li class="h-menu__item">내 강의실</li>--}}
{{--            <li class="h-menu__item">게시판</li>--}}
{{--            <li class="h-menu__item">내정보</li>--}}
{{--        </ul>--}}
{{--        <button class="header__right-btn">감나무</button>--}}
{{--    </header>--}}
{{--    <!-- //header -->--}}

{{--    <!-- left menu -->--}}
{{--    <div class="left-menu">--}}
{{--        <ul class="left-menu__list">--}}
{{--            <li class="left-menu__item tit myclass">내 강의실</li>--}}
{{--            <li class="left-menu__item"><a href="myclass_p_lecture.html">디지털 브랜드 마케팅<br><span class="state">3주차 진행 중</span></a></li>--}}
{{--            <li class="left-menu__item"><a href="myclass_p_board1.html">공지사항</a></li>--}}
{{--            <li class="left-menu__item"><a href="myclass_p_board1.html">자료실(서랍)</a></li>--}}
{{--            <li class="left-menu__item new"><a href="myclass_p_board2.html">질문답변</a></li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--    <!-- //left menu -->--}}

{{--    <!-- lecture info -->--}}
{{--    --}}
{{--    <!-- //lecture info -->--}}
{{--    @section('extend')--}}
{{--    @endsection--}}
{{--<script>--}}
{{--    console.log({{ $lecture['use_nickname'] }});--}}

{{--</script>--}}

{{--</body>--}}




{{--기본정보 <a href="{{ route('class.mainView', ['lecture_id' => $lecture->id]) }}">수업</a> <a href="{{ route('lecture.analysisView', ['lecture_id' => $lecture->id]) }}">통계</a><br/>--}}
{{--<p>{{ $lecture['name'] }}</p> 과목명--}}
{{--<p>{{ $lecture['lecture_code'] }}</p> 과목코드--}}
{{--<p>{{ $lecture['description'] }}</p> 과목 소개--}}
{{--<p>{{ $lecture['lecture_goal_desc'] }}</p> 학습목표--}}
{{--<p>{{ $lecture['use_nickname'] }}</p>--}}
{{--<p>{{ $lecture['classes'][0]->title }}</p>--}}
{{--<p>{{ $lecture['evaluation'][0]->factor }}</p>--}}
