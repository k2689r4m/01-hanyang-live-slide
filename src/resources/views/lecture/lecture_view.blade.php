@extends('layout.sidebar_layout')
@section('title')
    lecture main
@endsection

@section('script')
@endsection

@section('content')
{{--    <style>--}}
{{--        .dashboard-top {--}}
{{--            display: flex;--}}
{{--        }--}}

{{--        .dashboard-top .list-type1 {--}}
{{--            height: calc(100% - 30px);--}}
{{--            box-sizing: border-box;--}}
{{--        }--}}

{{--        .btn-link {--}}
{{--            white-space: nowrap;--}}
{{--        }--}}
{{--    </style>--}}
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

    <div class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture->id]) }}'"></li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.lectureView', ['lecture_id' => $lecture->id]) }}'">내 강의실</li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.lectureView', ['lecture_id' => $lecture->id]) }}'">과목홈</li>
        </ul>
    </div>
    <!-- dashboard -->
    <div class="content__wrap exist-nav exist-leftmenu dashboard">
        <div class="content">
            <!-- top -->
            <div class="row dashboard-top">
                <div class="col col-4">
                    <h3 class="dashboard__sub">
                        <a href="{{ route('lecture.noticeView', ['lecture_id' => $lecture->id]) }}">공지사항</a>
                    </h3>
                    <ul class="list-type1">
                        @foreach($notices as $notice)
                        <li class="list-type1__item">
                            <a href="{{ route('lecture.notice.detailView', ['lecture_id' => $lecture->id, 'notice_id' => $notice->id]) }}">
                                @if($notice->new)
                                    <span class="list-type1__tit bold new">{{ $notice->title }}</span>
                                @else
                                    <span class="list-type1__tit">{{ $notice->title }}</span>
                                @endif
                                <span class="list-type1__date">{{ explode(' ', $notice->created_at)[0] }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col col-4">
                    <h3 class="dashboard__sub">
                        <a href="{{ route('lecture.archiveView', ['lecture_id' => $lecture->id]) }}">자료실(서랍)</a>
                    </h3>
                    <ul class="list-type1">
                        @foreach($archives as $archive)
                        <li class="list-type1__item">
                            <a href="{{ route('lecture.archive.detailView', ['lecture_id' => $lecture->id, 'archive_id' => $archive->id]) }}">
                                @if($archive->new)
                                    <span class="list-type1__tit bold new">{{ $archive->title }}</span>
                                @else
                                    <span class="list-type1__tit">{{ $archive->title }}</span>
                                @endif
                                <span class="list-type1__date">{{ explode(' ', $archive->created_at)[0] }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col col-4">
                    <h3 class="dashboard__sub">
                        <a href="{{ route('lecture.qnaView', ['lecture_id' => $lecture->id]) }}">질문답변</a>
                    </h3>
                    <ul class="list-type1">
                        @foreach($qnas as $qna)
                            <li class="list-type1__item">
                                <a href="{{ route('lecture.qna.detailView', ['lecture_id' => $lecture->id, 'qna_id' => $qna->id]) }}">
                                    @if($qna->new)
                                        <span class="list-type1__tit bold new">{{ $qna->title }}</span>
                                    @else
                                        <span class="list-type1__tit">{{ $qna->title }}</span>
                                    @endif
                                    <span class="list-type1__date">{{ explode(' ', $qna->created_at)[0] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- //top -->
            <!-- bottom -->
            <div class="col col-12">
                <div class="class-table__wrap">
                    <div class="class-table__top">
                        <h2 class="class-table__tit">수업</h2>
                        @if (!request()->get('isOwn'))
                            <span class="t-gray ml-10">
							    총<strong>{{ $classes_count }}개</strong>의 참여 중인 수업이 있습니다.
						    </span>
                        @else
                            <button onclick="location.href=`{{ route('class.writeView', ['lecture_id' => $lecture->id]) }}`" class="btn-normal btn-round btn-red pl-30 pr-30"> 수업 개설 </button>
                        @endif
                    </div>
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
                                <col width="35%" />
                                <col width="13%" />
                                <col width="13%" />
                                <col width="8%" />
                                <col width="10%" />
                                <col width="21%" />
                            @endif
                        </colgroup>
                        <tr>
                            @if (request()->get('isOwn'))
                                <th class="left">수업명</th>
                                <th>참여자 수</th>
                                <th>수업 링크 복사</th>
                                <th>다시보기 링크 복사</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            @else
                                <th class="left">수업명</th>
                                <th>수업 링크 복사</th>
                                <th>다시보기 링크 복사</th>
                                <th>수업 참여</th>
                                <th>다시보기 참여</th>
                                <th></th>
                            @endif
                        </tr>
                        @if (request()->get('isOwn'))
                            @foreach($classes as $class)
                                <tr>
                                    <td class="left"><strong><a href="{{ route('study.enter', ['user_url' => $class->user_url]) }}">{{ $class->name }}</a></strong> {{$class->slides()->count()}}</td>
                                    <td>
                                        @if ($class->active_member_count == 0)
                                            0/{{$member_count}}
                                        @else
                                            {{$class->active_member_count-1}}/{{$member_count}}
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn-link @if (strtotime($class->active_end_date) < strtotime(now())) disable @endif"
                                                id="class_active_date_{{$class->id}}"
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

                                            const targetBtn = document.getElementById('class_active_date_'+{{$class->id}});

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
                                                id="class_record_date_{{$class->id}}"
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

                                                    const targetBtn = document.getElementById('class_record_date_'+{{$class->id}});

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
                                    <td>
{{--                                        {{$class->slides()->count()}}--}}
                                        <button class="btn-normal btn-round btn-red btn-line @if (strtotime($class->active_end_date) < strtotime(now()) || $class->slides()->count() <= 0) btn-disable @endif"
                                                onclick="location.href=`{{ route('study.enter', ['user_url' => $class->user_url]) }}`">
                                            시작하기
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn-normal btn-round btn-gray btn-line @if (strtotime($class->active_end_date) < strtotime(now())) btn-disable @endif"
                                                onclick="location.href=`{{ route('slide.writeView', ['lecture_id' => $lecture->id, 'class_id' => $class->id]) }}`">
                                            설정
                                        </button>
                                    </td>
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
                                </tr>
                            @endforeach
                        @else
                            @foreach($classes as $class)
                                <tr>
                                    <td class="left"><strong><a href="{{ route('study.enter', ['user_url' => $class->user_url]) }}">{{ $class->name }}</a></strong> {{$class->slides()->count()}}</td>
                                    <td>
                                        <button class="btn-link @if (strtotime($class->active_end_date) < strtotime(now())) disable @endif"
                                                id="class_active_date_{{$class->id}}"
                                                onclick="
                                                @if (strtotime($class->active_end_date) >= strtotime(now()))
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

                                                    const targetBtn = document.getElementById('class_active_date_'+{{$class->id}});

                                                    targetBtn.classList.remove('tooltip');
                                                    targetBtn.classList.add('tooltip');
                                                @endif
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
                                                id="class_record_date_{{$class->id}}"
                                                onclick="
                                                @if (strtotime($class->record_end_date) >= strtotime(now()))
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

                                                    const targetBtn = document.getElementById('class_record_date_'+{{$class->id}});

                                                    targetBtn.classList.remove('tooltip');
                                                    targetBtn.classList.add('tooltip');
                                                @endif
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
                                    <td>
                                        <span class="state-o"></span>
                                    </td>
                                    <td>
                                        <span class="state-x"></span>
                                    </td>
                                    <td>
                                        <button class="btn-normal btn-round btn-red btn-line @if (strtotime($class->active_end_date) < strtotime(now()) || $class->slides()->count() <= 0) btn-disable @endif"
                                                onclick="location.href=`{{ route('study.enter', ['user_url' => $class->user_url]) }}`">
                                            입장하기
                                        </button>
{{--                                        btn-disable--}}
                                        <button class="btn-normal btn-round btn-primary btn-line btn-disable @if (strtotime($class->record_end_date) < strtotime(now())) btn-disable @endif"
                                        onclick="@if (strtotime($class->record_end_date) < strtotime(now())) /** js code here */ @endif"
                                        >다시보기</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
            <!-- //bottom -->
        </div>
    </div>
    <!-- //dashboard -->
@endsection
<!-- dashboard -->
<!-- //dashboard -->


{{--<p>수업~</p>--}}
{{--@if (!request()->get('isOwn'))--}}
{{--    <p>총 {{ $classes_count }}개의 참여중인 수업이 있습니다.</p>--}}
{{--@else--}}
{{--    <a href="{{ route('class.writeView', ['lecture_id' => $lecture->id]) }}">수업 개설</a>--}}
{{--@endif--}}

{{--    <table>--}}
{{--        <thead>--}}
{{--            <tr>--}}
{{--                <td>수업명</td>--}}
{{--                <td>참여자 수</td>--}}
{{--                <td>수업 링크 복사</td>--}}
{{--                <td>다시보기 링크 복사</td>--}}
{{--                <td></td>--}}
{{--            </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach($classes as $class)--}}
{{--            <tr>--}}
{{--                <td>--}}
{{--                    <a href="{{ route('study.enter', ['user_url' => $class->user_url]) }}">{{ $class->name }}</a>--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    참여자 수 x/{{ $member_count }}--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    {{ explode(' ', $class->active_start_date)[0] }} ~ {{ explode(' ', $class->active_end_date)[0] }}--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    {{ explode(' ', $class->record_start_date)[0] }} ~ {{ explode(' ', $class->record_end_date)[0] }}--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    @if (request()->get('isOwn'))--}}
{{--                        수업하기--}}
{{--                        <a href="{{ route('slide.writeView', ['lecture_id' => $lecture->id, 'class_id' => $class->id]) }}">수정</a>--}}
{{--                        <a href="{{ route('class.delete', ['lecture_id' => $lecture->id, 'class_id' => $class->id]) }}">삭제</a>--}}
{{--                    @else--}}
{{--                        입장하기 다시보기--}}
{{--                    @endif--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}

