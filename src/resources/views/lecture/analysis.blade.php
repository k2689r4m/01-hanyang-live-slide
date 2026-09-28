@extends('layout.sidebar_layout')
@section('title')
    통계
@endsection

@section('content')
    <ul class="tab-menu">
        {{--        <a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a> <a href="{{ route('class.mainView', ['lecture_id' => $lecture_id]) }}">수업</a> 통계<br/>--}}
        <li class="tab-menu__item"><a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a></li>
        <li class="tab-menu__item"><a href="{{ route('class.mainView', ['lecture_id' => $lecture_id]) }}">수업</a></li>
        <li class="tab-menu__item active"><a>통계</a></li>
    </ul>
    <div class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture_id]) }}'"></li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.lectureView', ['lecture_id' => $lecture_id]) }}'">내 강의실</li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.analysisView', ['lecture_id' => $lecture_id]) }}'">통계</li>
        </ul>
    </div>
    <div class="content__wrap exist-nav exist-leftmenu round">
        <div class="content exist-tab analysis__wrap">
            <table class="txt-only">
                <colgroup>
                    <col width="7%" />
                    @if (request()->get('isOwn'))
                        <col width="45%" />
                        <col width="10%" />
                        <col width="18%" />
                        <col width="10%" />
                    @else
                        <col width="53%" />
                        <col width="10%" />
                        <col width="20%" />
                    @endif
                </colgroup>
                <tr>
                    <th>번호</th>
                    <th class="left">수업명</th>
                    @if(request()->get('isOwn'))
                        <th>생성일</th>
                    @else
                        <th>참여일</th>
                    @endif
                    <th>슬라이드수 (질문, 퀴즈, 일반)</th>
                    @if(request()->get('isOwn'))
                        <th>참여자수</th>
                    @endif
                </tr>
                @foreach($classes as $class)
                    <tr>
                        <td>
                            {{ $class['index'] }}
                        </td>
                        <td class="left">
                            @if (request()->get('isOwn'))
                                <a href="{{ route('lecture.analysis.graph.detailView', ['lecture_id' => $lecture_id, 'class_id' => $class['id']]) }}">{{ $class['name'] }}</a>
                            @else
                                <a href="{{ route('lecture.analysis.student.detailView', ['lecture_id' => $lecture_id, 'class_id' => $class['id']]) }}">{{ $class['name'] }}</a>
                            @endif
                        </td>
                        <td>
                            {{ $class['created'] }}
                        </td>
                        <td>
                            {{ $class['slides'] }}
                        </td>
                        @if (request()->get('isOwn'))
                            <td>
                                x
                            </td>
                        @endif
                    </tr>
                @endforeach
            </table>

            {{ $classes->links('vendor.pagination.roc') }}
{{--            <ul class="pagination">--}}
{{--                <li class="pagination__item left disabled">&nbsp;</li>--}}
{{--                <li class="pagination__item active">1</li>--}}
{{--                <li class="pagination__item">2</li>--}}
{{--                <li class="pagination__item">3</li>--}}
{{--                <li class="pagination__item right">&nbsp;</li>--}}
{{--            </ul>--}}
        </div>
    </div>
@endsection

{{--<body>--}}
{{--<!-- header -->--}}
{{--<header class="header">--}}
{{--    <!-- <h1 class="header__logo">헤더로고</h1>--}}
{{--    <ul class="h-menu">--}}
{{--        <li class="h-menu__item">서비스소개</li>--}}
{{--        <li class="h-menu__item">내 강의실</li>--}}
{{--        <li class="h-menu__item">게시판</li>--}}
{{--        <li class="h-menu__item">내정보</li>--}}
{{--    </ul>--}}
{{--    <button class="header__right-btn">감나무</button> -->--}}
{{--</header>--}}
{{--<!-- //header -->--}}

{{--<!-- left menu -->--}}
{{--<div class="left-menu">--}}
{{--    <ul class="left-menu__list">--}}
{{--        <li class="left-menu__item tit myclass">내 강의실</li>--}}
{{--        <li class="left-menu__item"><a href="myclass_p_lecture.html">디지털 브랜드 마케팅<br><span class="state">3주차 진행 중</span></a></li>--}}
{{--        <li class="left-menu__item"><a href="myclass_p_board1.html">공지사항</a></li>--}}
{{--        <li class="left-menu__item"><a href="myclass_p_board1.html">자료실(서랍)</a></li>--}}
{{--        <li class="left-menu__item new"><a href="myclass_p_board2.html">질문답변</a></li>--}}
{{--    </ul>--}}
{{--</div>--}}
{{--<!-- //left menu -->--}}

{{--<!-- lecture analysis -->--}}

{{--<!-- //lecture analysis -->--}}
{{--</body>--}}


{{--<a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a> <a href="{{ route('class.mainView', ['lecture_id' => $lecture_id]) }}">수업</a> 통계<br/>--}}

{{--<table>--}}
{{--    <thead>--}}
{{--    <tr>--}}
{{--        <td>번호</td>--}}
{{--        <td>수업명</td>--}}
{{--        <td>생성일</td>--}}
{{--        <td>슬라이드수 (질문,퀴즈,일반)</td>--}}
{{--        <td>참여자수</td>--}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}
{{--    @foreach($classes as $class)--}}
{{--        <tr>--}}
{{--            <td>--}}
{{--                {{ $class->id }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                <a href="#">{{ $class->name }}</a>--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                {{ explode(' ', $class->created_at)[0] }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                x--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                x--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--    </tbody>--}}
{{--</table>--}}

{{--{{ $classes->links() }}--}}













{{--<a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a> <a href="{{ route('class.mainView', ['lecture_id' => $lecture_id]) }}">수업</a> 통계<br/>--}}

{{--<table>--}}
{{--    <thead>--}}
{{--    <tr>--}}
{{--        <td>번호</td>--}}
{{--        <td>수업명</td>--}}
{{--        <td>생성일</td>--}}
{{--        <td>슬라이드수 (질문,퀴즈,일반)</td>--}}
{{--        <td>참여자수</td>--}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}
{{--    @foreach($classes as $class)--}}
{{--        <tr>--}}
{{--            <td>--}}
{{--                {{ $class->id }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                <a href="#">{{ $class->name }}</a>--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                {{ explode(' ', $class->created_at)[0] }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                x--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                x--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--    </tbody>--}}
{{--</table>--}}

{{--{{ $classes->links() }}--}}
