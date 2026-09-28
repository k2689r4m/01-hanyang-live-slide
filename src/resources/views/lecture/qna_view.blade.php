{{--QNA MAIN @if(!request()->get('isOwn')) <a href="{{ route('lecture.qna.writeView', ['lecture_id' => $lecture_id]) }}">등록</a> @endif--}}
@extends('layout.sidebar_layout')

@section('title')
    질문답변
@endsection
@section('content')
    <div class="dim dn" id="alert_cc_dim">
        <div class="alert" id="alert_cc">
            <div class="alert__con">
                삭제하시겠습니까?
            </div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn gray" onclick="event.target.parentNode.parentNode.parentNode.parentNode.classList.add('dn')">취소</button>
                </div>
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary" id="alert_cc_confirm">확인</button>
                </div>
            </div>
        </div>
    </div>
    @if (Session::has('success'))
        <div class="dim">
            <div id="delete_complete" class="alert">
                <div class="alert__con">
                    삭제되었습니다.
                </div>
                <div class="alert__bottom">
                    <div class="alert__btn-wrap">
                        <button class="alert__btn primary" onclick="event.target.parentNode.parentNode.parentNode.parentNode.classList.add('dn')">확인</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture_id]) }}'"></li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.lectureView', ['lecture_id' => $lecture_id]) }}'">내 강의실</li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.qnaView', ['lecture_id' => $lecture_id]) }}'">질문답변</li>
        </ul>
    </div>
<!-- professor board -->
<div class="content__wrap exist-nav exist-leftmenu round">
        <div class="content analysis__wrap">
            <h2 class="content__tit board-tit">질문답변
                @if(!request()->get('isOwn'))
                    <a href="{{ route('lecture.qna.writeView', ['lecture_id' => $lecture_id]) }}" class="btn btn-red btn-line btn-normal btn-round">등록</a>
                @endif
            </h2>
            <table class="board-table  @if (!request()->get('isOwn')) txt-only @endif">
                <colgroup>
                    @if (request()->get('isOwn'))
                        <col width="8%" />
                        <col width="12%" />
                        <col width="50%" />
                        <col width="15%" />
                        <col width="15%" />
                    @else
                        <col width="8%" />
                        <col width="12%" />
                        <col width="65%" />
                        <col width="15%" />
                    @endif
                </colgroup>
                <tr>
                    <th>번호</th>
                    <th>작성자</th>
                    <th class="left">제목</th>
                    <th>작성일</th>
                    @if (request()->get('isOwn'))
                        <th></th>
                    @endif
                </tr>

                @foreach ($data as $qna)
                    <tr>
                        <td>{{ $qna['index'] }}</td>
                        <td>{{ $qna['qna']->lecture->use_nickname ? $qna['qna']->user->nickname : $qna['qna']->user->name }}</td>
                        <td class="left @if ($qna['qna']->lock) secret @endif">
                            <a href="{{ route('lecture.qna.detailView', ['lecture_id' => $lecture_id, 'qna_id' => $qna['qna']->id]) }}">{{ $qna['qna']->title }}</a> ({{ $qna['qna']->comment()->count() }})
                        </td>
                        {{--                    <td class="left @if ($qna->lock) secret @endif"><a href="{{ route('lecture.qna.detailView', ['lecture_id' => $lecture_id, 'qna_id' => $qna->id]) }}"> {{ $qna->title }}</a></td>--}}
                        <td>{{ date('Y.m.d', strtotime($qna['qna']->created_at)) }}</td>
                        @if(request()->get('isOwn'))
                            <td>
                                <button class="btn-normal btn-round btn-gray btn-line" onclick="
                                    document.getElementById('alert_cc_confirm').onclick = () => {
                                        location.href=`{{ route('lecture.qna.delete', ['lecture_id' => $lecture_id, 'qna_id' => $qna['qna']->id]) }}`;
                                    }
                                    document.getElementById('alert_cc_dim').classList.remove('dn');
                                ">삭제</button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </table>
{{--            <ul class="pagination">--}}
{{--                <li class="pagination__item left disabled">&nbsp;</li>--}}
{{--                <li class="pagination__item active">1</li>--}}
{{--                <li class="pagination__item">2</li>--}}
{{--                <li class="pagination__item">3</li>--}}
{{--                <li class="pagination__item right">&nbsp;</li>--}}
{{--            </ul>--}}
            {{ $data->links('vendor.pagination.roc') }}
        </div>

    </div>
@endsection



{{--@foreach ($qnas as $qna)--}}
{{--    <tr>--}}
{{--        <td>{{ $qna->id }}</td>--}}
{{--        <td>{{ $qna->lecture->use_nickname ? $qna->user->nickname : $qna->user->name }}</td>--}}
{{--        <td>{{ $qna->lock ? '(비밀글)' : '' }}<a href="{{ route('lecture.qna.detailView', ['lecture_id' => $lecture_id, 'qna_id' => $qna->id]) }}"> {{ $qna->title }}</a></td>--}}
{{--        <td>{{ $qna->created_at }}</td>--}}
{{--        @if(request()->get('isOwn'))--}}
{{--            <td>--}}
{{--                <a--}}
{{--                        href="{{ route('lecture.qna.delete', ['lecture_id' => $lecture_id, 'qna_id' => $qna->id]) }}"--}}
{{--                >--}}
{{--                    삭제--}}
{{--                </a>--}}
{{--            </td>--}}
{{--        @endif--}}
{{--    </tr>--}}
{{--@endforeach--}}

{{--{{ $qnas->links() }}--}}






{{-- 나중에 pagination 따로 커스텀 할 예정 --}}
{{--@php--}}
{{--    $currentPage = request()->input('page') ? request()->input('page') : 1;--}}
{{--    $startPage = floor(($currentPage-1) / 10) * 10 + 1;--}}
{{--    $endPage =  ($startPage + 9);--}}
{{--@endphp--}}
{{--@if ($startPage > 1)--}}
{{--    <a href="{{ route('lecture.mainView', ['page' => $startPage-1]) }}">이전 페이지</a>--}}
{{--@endif--}}
{{--@for ($page = $startPage; $page <= $endPage && $page <= $lectures->lastPage(); $page++)--}}
{{--    @if ($p|| $page == $lectures->lastPage())--}}
{{--        ... <a href="{{ route('lecture.mainView', ['page' => $page]) }}">{{ $page }}</a>--}}
{{--    @elseif ($page >= $startPage + 3)--}}
{{--        @continue--}}
{{--    @else--}}
{{--        <a href="{{ route('lecture.mainView', ['page' => $page]) }}">{{ $page === $currentPage ? 'X' : $page }}</a>--}}
{{--    @endif--}}
{{--@endfor--}}
{{--@if ($lectures->lastPage() > @endPage)--}}
{{--    <a href="{{ route('lecture.mainView', ['page' => $endPage+1]) }}">다음 페이지</a>--}}
{{--@endif--}}

{{--{{ request()->input('page') }}--}}





{{--QNA MAIN @if(!request()->get('isOwn')) <a href="{{ route('lecture.qna.writeView', ['lecture_id' => $lecture_id]) }}">등록</a> @endif--}}
{{--<table>--}}
{{--    <thead>--}}
{{--        <tr>--}}
{{--            <td>No</td>--}}
{{--            <td>작성자</td>--}}
{{--            <td>제목</td>--}}
{{--            <td>작성일z</td>--}}
{{--            @if(request()->get('isOwn'))--}}
{{--                <td>-</td>--}}
{{--            @endif--}}
{{--        </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}
{{--@foreach ($qnas as $qna)--}}
{{--    <tr>--}}
{{--    <td>{{ $qna->id }}</td>--}}
{{--    <td>{{ $qna->lecture->use_nickname ? $qna->user->nickname : $qna->user->name }}</td>--}}
{{--    <td>{{ $qna->lock ? '(비밀글)' : '' }}<a href="{{ route('lecture.qna.detailView', ['lecture_id' => $lecture_id, 'qna_id' => $qna->id]) }}"> {{ $qna->title }}</a></td>--}}
{{--    <td>{{ $qna->created_at }}</td>--}}
{{--    @if(request()->get('isOwn'))--}}
{{--        <td>--}}
{{--            <a--}}
{{--                href="{{ route('lecture.qna.delete', ['lecture_id' => $lecture_id, 'qna_id' => $qna->id]) }}"--}}
{{--            >--}}
{{--                삭제--}}
{{--            </a>--}}
{{--        </td>--}}
{{--    @endif--}}
{{--    </tr>--}}
{{--@endforeach--}}
{{--    </tbody>--}}
{{--</table>--}}
{{--{{ $qnas->links() }}--}}

{{-- 나중에 pagination 따로 커스텀 할 예정--}}
{{--@php--}}
{{--    $currentPage = request()->input('page') ? request()->input('page') : 1;--}}
{{--    $startPage = floor(($currentPage-1) / 10) * 10 + 1;--}}
{{--    $endPage =  ($startPage + 9);--}}
{{--@endphp--}}
{{--@if ($startPage > 1)--}}
{{--    <a href="{{ route('lecture.mainView', ['page' => $startPage-1]) }}">이전 페이지</a>--}}
{{--@endif--}}
{{--@for ($page = $startPage; $page <= $endPage && $page <= $lectures->lastPage(); $page++)--}}
{{--    @if ($p|| $page == $lectures->lastPage())--}}
{{--        ... <a href="{{ route('lecture.mainView', ['page' => $page]) }}">{{ $page }}</a>--}}
{{--    @elseif ($page >= $startPage + 3)--}}
{{--        @continue--}}
{{--    @else--}}
{{--        <a href="{{ route('lecture.mainView', ['page' => $page]) }}">{{ $page === $currentPage ? 'X' : $page }}</a>--}}
{{--    @endif--}}
{{--@endfor--}}
{{--@if ($lectures->lastPage() > @endPage)--}}
{{--    <a href="{{ route('lecture.mainView', ['page' => $endPage+1]) }}">다음 페이지</a>--}}
{{--@endif--}}

{{--{{ request()->input('page') }}--}}





































{{--백업 1119--}}
{{--등록버튼 확인 후 주석 제거--}}
{{--@extends('layout.layout')--}}

{{--@section('title')--}}
{{--    QnA--}}
{{--@endsection--}}

{{--QNA MAIN @if(!request()->get('isOwn')) <a href="{{ route('lecture.qna.writeView', ['lecture_id' => $lecture_id]) }}">등록</a> @endif--}}
{{--<h2 class="content__tit board-tit">--}}
{{--    @if(request()->get('isOwn'))--}}
{{--        공지사항<a href="{{ route('lecture.notice.writeView', ['lecture_id' => $lecture_id]) }}" class="btn btn-red btn-line btn-normal btn-round">--}}
{{--            등록--}}
{{--        </a>--}}
{{--    @endif--}}
{{--    @if(!request()->get('isOwn'))--}}
{{--        공지사항--}}
{{--        <a href="{{ route('lecture.qna.writeView', ['lecture_id' => $lecture_id]) }}">등록</a>--}}
{{--    @endif--}}
{{--</h2>--}}
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

{{--<div class="content__wrap exist-nav exist-leftmenu round">--}}
{{--    <ul class="page-nav gray">--}}
{{--        <li class="page-nav__item home"></li>--}}
{{--        <li class="page-nav__item">내 강의실</li>--}}
{{--        <li class="page-nav__item">질문답변</li>--}}
{{--    </ul>--}}
{{--    <div class="content analysis__wrap">--}}
{{--        <div>--}}
{{--            <h2 class="content__tit board-tit">질문답변1</h2>--}}
{{--            <table class="board-table">--}}
{{--                <colgroup>--}}
{{--                    <col width="8%" />--}}
{{--                    <col width="12%" />--}}
{{--                    <col width="50%" />--}}
{{--                    <col width="15%" />--}}
{{--                    <col width="15%" />--}}
{{--                </colgroup>--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <td>No</td>--}}
{{--                    <td>작성자</td>--}}
{{--                    <td>제목</td>--}}
{{--                    <td>작성일</td>--}}
{{--                    @if(request()->get('isOwn'))--}}
{{--                        <td>-</td>--}}
{{--                    @endif--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                <tr>--}}
{{--                    <td>11</td>--}}
{{--                    <td>홍길동</td>--}}
{{--                    <td class="left"><a href="myclass_p_board_detail_coment.html">샘플 텍스트 시연시에 삭제</a></td>--}}
{{--                    <td>2020.09.19</td>--}}
{{--                    <td><button class="btn-normal btn-round btn-gray btn-line">삭제</button></td>--}}
{{--                </tr>--}}
{{--                @foreach ($qnas as $qna)--}}

{{--                    <tr>--}}
{{--                        <td>{{ $qna->id }}</td>--}}
{{--                        <td>{{ $qna->lecture->use_nickname ? $qna->user->nickname : $qna->user->name }}</td>--}}
{{--                        <td>{{ $qna->lock ? '(비밀글)' : '' }}<a href="{{ route('lecture.qna.detailView', ['lecture_id' => $lecture_id, 'qna_id' => $qna->id]) }}"> {{ $qna->title }}</a></td>--}}
{{--                        <td>{{ $qna->created_at }}</td>--}}
{{--                        @if(request()->get('isOwn'))--}}
{{--                            <td>--}}
{{--                                <a--}}
{{--                                        href="{{ route('lecture.qna.delete', ['lecture_id' => $lecture_id, 'qna_id' => $qna->id]) }}"--}}
{{--                                >--}}
{{--                                    삭제--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                        @endif--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--            <ul class="pagination">--}}
{{--                <li class="pagination__item left disabled">&nbsp;</li>--}}
{{--                <li class="pagination__item active">1</li>--}}
{{--                <li class="pagination__item">2</li>--}}
{{--                <li class="pagination__item">3</li>--}}
{{--                <li class="pagination__item right">&nbsp;</li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@section('footer')--}}
{{--@endsection--}}
{{--{{ $qnas->links() }}--}}

