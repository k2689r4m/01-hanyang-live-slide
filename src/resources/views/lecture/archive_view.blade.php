@extends('layout.sidebar_layout')
@section('title')
    자료실
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
                <button class="alert__btn primary cp" onclick="event.target.parentNode.parentNode.parentNode.parentNode.classList.add('dn')">확인</button>
            </div>
        </div>
    </div>
</div>
@endif
<div class="page-nav-wrap">
    <ul class="page-nav gray">
        {{--        OnClick이벤트로 스크립트 추가해야됨--}}
        <li class="page-nav__item home cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture_id]) }}'"></li>
        <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.lectureView', ['lecture_id' => $lecture_id]) }}'">내 강의실</li>
        <li class="page-nav__item">자료실</li>
    </ul>
</div>
<div class="content__wrap exist-nav exist-leftmenu round">
    <div class="content analysis__wrap">
        <h2 class="content__tit board-tit">
            자료실
            @if(request()->get('isOwn'))
                <a href="{{ route('lecture.archive.writeView', ['lecture_id' => $lecture_id]) }}" class="btn btn-red btn-line btn-normal btn-round">등록</a>
            @endif
        </h2>
        <table class="board-table @if (!request()->get('isOwn')) txt-only @endif">
            <colgroup>
                <col width="10%" />
                <col width="60%" />
                <col width="15%" />
                @if(request()->get('isOwn'))
                    <col width="15%" />
                @endif
            </colgroup>
            <tr>
                <th>번호</th>
                <th class="left">제목</th>
                <th>작성일</th>
                @if(request()->get('isOwn'))
                    <th></th>
                @endif
            </tr>
            @foreach ($data as $archive)
                <tr>
                <td>{{ $archive['index'] }}</td>
                <td class="left"><a href="{{ route('lecture.archive.detailView', ['lecture_id' => $lecture_id,'archive_id' => $archive['id']]) }}">{{ $archive['title']}}</a></td>
                <td>{{ $archive['created'] }}</td>
                @if(request()->get('isOwn'))
                    <td>
                        <button class="btn-normal btn-round btn-gray btn-line" onclick="
                            document.getElementById('alert_cc_dim').classList.remove('dn');
                            document.getElementById('alert_cc_confirm').onclick = () => {
                                location.href=`{{ route('lecture.archive.delete', ['lecture_id' => $lecture_id, 'archive_id' => $archive['id']]) }}`
                            }
                        ">삭제</button>
                    </td>
                @endif
                </tr>
            @endforeach
        </table>
        {{ $data->links('vendor.pagination.roc') }}
    </div>
</div>

@endsection

{{--{{ route('lecture.archive.writeView', ['lecture_id' => $lecture_id]) }}--}}


{{--백업--}}
{{--ARCHIVE MAIN @if(request()->get('isOwn')) <a href="{{ route('lecture.archive.writeView', ['lecture_id' => $lecture_id]) }}">등록</a> @endif--}}
{{--<table>--}}
{{--    <thead>--}}
{{--        <tr>--}}
{{--            <td>No</td>--}}
{{--            <td>제목</td>--}}
{{--            <td>작성일</td>--}}
{{--            @if(request()->get('isOwn'))--}}
{{--                <td>-</td>--}}
{{--            @endif--}}
{{--        </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}
{{--@foreach ($archives as $archive)--}}
{{--    <tr>--}}
{{--    <td>{{ $archive->id }}</td>--}}
{{--    <td>{{ $archive->lecture->use_nickname ? request()->get('user')->nickname : request()->get('user')->name }}</td>--}}
{{--    <td><a href="{{ route('lecture.archive.detailView', ['lecture_id' => $lecture_id, 'archive_id' => $archive->id]) }}">{{ $archive->title }}</a></td>--}}
{{--    <td>{{ $archive->created_at }}</td>--}}
{{--    @if(request()->get('isOwn'))--}}
{{--        <td>--}}
{{--            <a--}}
{{--                href="{{ route('lecture.archive.delete', ['lecture_id' => $lecture_id, 'archive_id' => $archive->id]) }}"--}}
{{--            >--}}
{{--                삭제--}}
{{--            </a>--}}
{{--        </td>--}}
{{--    @endif--}}
{{--    </tr>--}}
{{--@endforeach--}}
{{--    </tbody>--}}
{{--</table>--}}
{{--{{ $archives->links() }}--}}

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
