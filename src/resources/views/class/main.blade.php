@extends('layout.sidebar_layout')
@section('title')
    수업
@endsection

@section('content')

    <ul class="tab-menu">
        {{--<a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a> 수1업 <a href="{{ route('lecture.analysisView', ['lecture_id' => $lecture_id]) }}">통계</a>--}}
        <li class="tab-menu__item"><a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a></li>
        <li class="tab-menu__item active"><a>수업</a></li>
        <li class="tab-menu__item"><a href="{{ route('lecture.analysisView', ['lecture_id' => $lecture_id]) }}">통계</a></li>
    </ul>
    <style>
        .btn-link {
            white-space: nowrap;
        }
    </style>
    @if (Session::has('error_message'))
        <div class="dim">
            <div id="delete_complete" class="alert">
                <div class="alert__con">
                    {{ Session::get('error_message') }}
                </div>
                <div class="alert__bottom">
                    <div class="alert__btn-wrap">
                        <button class="alert__btn primary" onclick="event.target.parentNode.parentNode.parentNode.parentNode.classList.add('dn'); location.href=`{{ url()->current() }}`">확인</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="dim dn" id="lecture_view_delete_modal">
        <div class="alert">
            <div class="alert__con" id="lecture_view_delete_modal_title">
                생활 속의 화학 DSE34A11를<br>삭제하시겠습니까?
            </div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn gray" onclick="document.getElementById('lecture_view_delete_modal').classList.add('dn')">취소</button>
                </div>
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary" id="lecture_view_delete_modal_confirm">확인</button>
                </div>
            </div>
        </div>
    </div>

{{--    <ul class="tab-menu">--}}
{{--        --}}{{--<a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a> 수1업 <a href="{{ route('lecture.analysisView', ['lecture_id' => $lecture_id]) }}">통계</a>--}}
{{--        <li class="tab-menu__item"><a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a></li>--}}
{{--        <li class="tab-menu__item active"><a>수업</a></li>--}}
{{--        <li class="tab-menu__item"><a href="{{ route('lecture.analysisView', ['lecture_id' => $lecture_id]) }}">통계</a></li>--}}
{{--    </ul>--}}
    <div class="content__wrap exist-nav exist-leftmenu round">
        <ul class="page-nav gray">
            <li class="page-nav__item home" onclick="location.href=`{{ route('lecture.mainView') }}`"></li>
            <li class="page-nav__item" onclick="location.href=`{{ route('lecture.lectureView', ['lecture_id', $lecture_id]) }}`">내 강의실</li>
            <li class="page-nav__item" onclick="location.href=`{{ route('lecture.mainView') }}`">수업</li>
        </ul>
        <div class="content exist-tab">
            <div class="col col-12">
                <div class="class-table__wrap exist-tab">
                    @if (request()->get('isOwn'))
                    <div class="class-table__top">
                        {{--                    하단 href에 링크 추가해야되는데 이건 링크 받아야함--}}
                        {{--                    {{ route('class.writeView', ['lecture_id' => $lecture->id]) }}--}}
                        <button class="btn-normal btn-round btn-red pl-30 pr-30" onclick="location.href=`{{ route('class.writeView', ['lecture_id' => $lecture_id]) }}`"> 수업 개설 </button>
                    </div>
                    @endif
                    <table>
                        <colgroup>
                            @if (request()->get('isOwn'))
                                <col width="38%" />
                                <col width="10%" />
                                <col width="13%" />
                                <col width="13%" />
                                <col width="10%" />
                                <col width="8%" />
                                <col width="8%" />
                            @else
                                <col width="37%" />
                                <col width="12%" />
                                <col width="12%" />
                                <col width="8%" />
                                <col width="10%" />
                                <col width="21%" />
                            @endif
                        </colgroup>
                        <tr>
                            <th class="left">수업명</th>
                        @if (request()->get('isOwn'))
                                <th>참여자 수</th>
                                <th>수업 링크 복사</th>
                                <th>다시보기 링크 복사</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            @else
                                <th>수업 링크 복사</th>
                                <th>다시보기 링크 복사</th>
                                <th>수업 참여</th>
                                <th>다시보기 참여</th>
                                <th></th>
                            @endif
                        </tr>
                        @foreach($classes as $class)
                            <tr>
                                <td class="left">
                                    <a href="{{ route('study.enter', ['user_url' => $class->user_url]) }}">{{ $class->name }}</a>
                                </td>
                                @if (request()->get('isOwn'))
                                <td>
                                    참여자 수 x/{{ $member_count }}
                                </td>
                                @endif
                                <td>
                                    <button class="btn-link @if (strtotime($class->active_end_date) < strtotime(now())) disable @endif"
                                            id="_class_active_date_{{$class->id}}"
                                            onmousedown="this.classList.remove('showhide')"
                                            onclick="
                                        var tempElem = document.createElement('textarea');
                                        const href = window.location.href.split('/');

                                        tempElem.value =
                                        href[0]
                                        + '//'
                                        + href[2]
                                        + '/room/'
                                        + '{{ $class->user_url }}'

                                        document.body.appendChild(tempElem);
                                        tempElem.select();
                                        document.execCommand('copy');
                                        document.body.removeChild(tempElem);

                                        const targetBtn = document.getElementById('_class_active_date_'+{{$class->id}});

                                        targetBtn.classList.remove('tooltip');
                                        targetBtn.classList.add('tooltip');
                                        targetBtn.classList.add('showhide');
                                   ">

                                        @if (date('y.m.d', strtotime($class->active_start_date)) === date('y.m.d', strtotime($class->active_end_date)))
                                            {{ date('y.m.d', strtotime($class->active_start_date)) }}<br>
                                            {{ date('h:i', strtotime($class->active_start_date)) }}~{{ date('h:i', strtotime($class->active_end_date)) }}
                                        @else
                                            {{ date('y.m.d h:i', strtotime($class->active_start_date)) }} ~<br>
                                            {{ date('y.m.d h:i', strtotime($class->active_end_date)) }}
                                        @endif
                                    </button>
                                </td>
                                <td>
                                    <button class="btn-link @if (strtotime($class->record_end_date) < strtotime(now())) disable @endif"
                                            id="_class_record_date_{{$class->id}}"
                                            onmousedown="this.classList.remove('showhide')"
                                            onclick="
                                                var tempElem = document.createElement('textarea');
                                                const href = window.location.href.split('/');

                                                tempElem.value =
                                                href[0]
                                                + '//'
                                                + href[2]
                                                + '/room/'
                                                + '{{ $class->user_url }}'

                                                document.body.appendChild(tempElem);
                                                tempElem.select();
                                                document.execCommand('copy');
                                                document.body.removeChild(tempElem);

                                                const targetBtn = document.getElementById('_class_record_date_'+{{$class->id}});

                                                targetBtn.classList.remove('tooltip');
                                                targetBtn.classList.add('tooltip');
                                                targetBtn.classList.add('showhide');
                                    ">
                                        @if (date('y.m.d', strtotime($class->record_start_date)) === date('y.m.d', strtotime($class->record_end_date)))
                                            {{ date('y.m.d', strtotime($class->record_start_date)) }}<br>
                                            {{ date('h:i', strtotime($class->record_start_date)) }}~{{ date('h:i', strtotime($class->record_end_date)) }}
                                        @else
                                            {{ date('y.m.d h:i', strtotime($class->record_start_date)) }} ~<br>
                                            {{ date('y.m.d h:i', strtotime($class->record_end_date)) }}
                                        @endif
                                    </button>
                                </td>

                                @if (request()->get('isOwn'))
                                    <td><button class="btn-normal btn-round btn-red btn-line @if (strtotime($class->active_end_date) < strtotime(now())) btn-disable @endif" onclick="location.href=`{{ route('study.enter', ['user_url' => $class->user_url]) }}`">시작하기</button></td>
                                    <td><button href="{{ route('class.editView', ['lecture_id' => $lecture_id, 'class_id' => $class->id]) }}" class="btn-normal btn-round btn-gray btn-line @if (strtotime($class->active_end_date) < strtotime(now())) btn-disable @endif" onclick="location.href=`{{ route('slide.writeView', ['lecture_id' => $lecture->id, 'class_id' => $class->id]) }}`">설정 </button></td>
                                    <td>
                                        <button class="btn-normal btn-round btn-gray btn-line" onclick="
                                                document.getElementById('lecture_view_delete_modal_title').innerHTML = `
                                                {{ $class->name }} 강의를<br>삭제하시겠습니까?`;

                                                document.getElementById('lecture_view_delete_modal').classList.remove('dn');

                                                document.getElementById('lecture_view_delete_modal_confirm').addEventListener('click', () => {
                                                location.href='{{ route('class.delete', ['lecture_id' => $lecture->id, 'class_id' => $class->id]) }}'})
                                                ">
                                            삭제
                                        </button>
                                    </td>
                                @else
                                    <td><span class="state-o"></span></td>
                                    <td><span class="state-x"></span></td>
                                    <td>
                                        <button class="btn-normal btn-round btn-red btn-line @if (strtotime($class->active_end_date) < strtotime(now())) btn-disable @endif"
                                                onclick="location.href=`{{ route('study.enter', ['user_url' => $class->user_url]) }}`">
                                            입장하기
                                        </button>
                                        <button class="btn-normal btn-round btn-primary btn-line @if (strtotime($class->record_end_date) < strtotime(now())) btn-disable @endif">다시보기</button>
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                    </table>

                    {{ $classes->links('vendor.pagination.roc') }}
{{--                    <ul class="pagination p-10">--}}
{{--                        <li class="pagination__item left disabled">&nbsp;</li>--}}
{{--                        <li class="pagination__item active">1</li>--}}
{{--                        <li class="pagination__item">2</li>--}}
{{--                        <li class="pagination__item">3</li>--}}
{{--                        <li class="pagination__item right">&nbsp;</li>--}}
{{--                    </ul>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

{{--<body>--}}
<!-- header -->
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
<!-- //header -->

<!-- left menu -->
{{--<div class="left-menu">--}}
{{--    <ul class="left-menu__list">--}}
{{--        <li class="left-menu__item tit myclass">내 강의실</li>--}}
{{--        <li class="left-menu__item"><a href="myclass_p_lecture.html">디지털 브랜드 마케팅<br><span class="state">3주차 진행 중</span></a></li>--}}
{{--        <li class="left-menu__item"><a href="myclass_p_board1.html">공지사항</a></li>--}}
{{--        <li class="left-menu__item"><a href="myclass_p_board1.html">자료실(서랍)</a></li>--}}
{{--        <li class="left-menu__item new"><a href="myclass_p_board2.html">질문답변</a></li>--}}
{{--    </ul>--}}
{{--</div>--}}
<!-- //left menu -->

<!-- lecture list -->

<!-- //lecture list -->

{{--</body>--}}






{{--<a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a> 수1업 <a href="{{ route('lecture.analysisView', ['lecture_id' => $lecture_id]) }}">통계</a>--}}
{{--<p>수업~</p>--}}
{{--@if (!request()->get('isOwn'))--}}
{{--    <p>총 {{ count($classes) }}개의 참여중인 수업이 있습니다.</p>--}}
{{--@else--}}
{{--    <a href="{{ route('class.writeView', ['lecture_id' => $lecture_id]) }}">수업 개설</a>--}}
{{--@endif--}}
{{--<br/>--}}
{{--<hr/>--}}
{{--<table>--}}
{{--    <thead>--}}
{{--    <tr>--}}
{{--        <td>수업명</td>--}}
{{--        <td>참여자 수</td>--}}
{{--        <td>수업 링크 복사</td>--}}
{{--        <td>다시보기 링크 복사</td>--}}
{{--        <td></td>--}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}
{{--    @foreach($classes as $class)--}}
{{--        <tr>--}}
{{--            <td>--}}
{{--                <a href="#">{{ $class->name }}</a>--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                참여자 수 x/{{ $member_count }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                --}}{{--                    clipboard.js 혹은 execCommand 사용해서 링크 복사해야함--}}
{{--                {{ explode(' ', $class->active_start_date)[0] }} ~ {{ explode(' ', $class->active_end_date)[0] }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                --}}{{--                    clipboard.js 혹은 execCommand 사용해서 링크 복사해야함--}}
{{--                {{ explode(' ', $class->record_start_date)[0] }} ~ {{ explode(' ', $class->record_end_date)[0] }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                @if (request()->get('isOwn'))--}}
{{--                    수업하기--}}
{{--                    <a href="{{ route('class.editView', ['lecture_id' => $lecture_id, 'class_id' => $class->id]) }}">수정</a>--}}
{{--                    <a href="{{ route('class.delete', ['lecture_id' => $lecture_id, 'class_id' => $class->id]) }}">삭제</a>--}}
{{--                @else--}}
{{--                    입장하기 다시보기--}}
{{--                @endif--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--    </tbody>--}}
{{--</table>--}}

{{--{{ $classes->links() }}--}}












{{--<a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a> 수1업 <a href="{{ route('lecture.analysisView', ['lecture_id' => $lecture_id]) }}">통계</a>--}}
{{--<p>수업~</p>--}}
{{--@if (!request()->get('isOwn'))--}}
{{--    <p>총 {{ count($classes) }}개의 참여중인 수업이 있습니다.</p>--}}
{{--@else--}}
{{--    <a href="{{ route('class.writeView', ['lecture_id' => $lecture_id]) }}">수업 개설</a>--}}
{{--@endif--}}
{{--<br/>--}}
{{--<hr/>--}}
{{--<table>--}}
{{--    <thead>--}}
{{--    <tr>--}}
{{--        <td>수업명</td>--}}
{{--        <td>참여자 수</td>--}}
{{--        <td>수업 링크 복사</td>--}}
{{--        <td>다시보기 링크 복사</td>--}}
{{--        <td></td>--}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}
{{--    @foreach($classes as $class)--}}
{{--        <tr>--}}
{{--            <td>--}}
{{--                <a href="#">{{ $class->name }}</a>--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                참여자 수 x/{{ $member_count }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                --}}{{--                    clipboard.js 혹은 execCommand 사용해서 링크 복사해야함--}}
{{--                {{ explode(' ', $class->active_start_date)[0] }} ~ {{ explode(' ', $class->active_end_date)[0] }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                --}}{{--                    clipboard.js 혹은 execCommand 사용해서 링크 복사해야함--}}
{{--                {{ explode(' ', $class->record_start_date)[0] }} ~ {{ explode(' ', $class->record_end_date)[0] }}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                @if (request()->get('isOwn'))--}}
{{--                    수업하기--}}
{{--                    <a href="{{ route('class.editView', ['lecture_id' => $lecture_id, 'class_id' => $class->id]) }}">수정</a>--}}
{{--                    <a href="{{ route('class.delete', ['lecture_id' => $lecture_id, 'class_id' => $class->id]) }}">삭제</a>--}}
{{--                @else--}}
{{--                    입장하기 다시보기--}}
{{--                @endif--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--    </tbody>--}}
{{--</table>--}}

{{--{{ $classes->links() }}--}}

