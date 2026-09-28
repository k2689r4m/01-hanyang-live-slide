@extends('layout.sidebar_layout')
@section('title')
    공지사항
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
            {{--        OnClick이벤트로 스크립트 추가해야됨--}}
            <li class="page-nav__item home cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture_id]) }}'"></li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.lectureView', ['lecture_id' => $lecture_id]) }}'">내 강의실</li>
            <li class="page-nav__item cp" >공지사항</li>
        </ul>
    </div>
    <div class="content__wrap exist-nav exist-leftmenu round">
        <div class="content analysis__wrap">
            <h2 class="content__tit board-tit">
                공지사항
                @if(request()->get('isOwn'))
                    <a href="{{ route('lecture.notice.writeView', ['lecture_id' => $lecture_id]) }}" class="btn btn-red btn-line btn-normal btn-round">등록</a>
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
                @foreach ($data as $notice)
                    <tr>
                        <td>{{ $notice['index'] }}</td>
                        <td class="left"><a href="{{ route('lecture.notice.detailView', ['lecture_id' => $lecture_id,'notice_id' => $notice['id']]) }}">{{ $notice['title']}}</a></td>
                        <td>{{ $notice['created'] }}</td>
                        @if(request()->get('isOwn'))
                            <td>
                                <button class="btn-normal btn-round btn-gray btn-line" onclick="
                                        document.getElementById('alert_cc_dim').classList.remove('dn');
                                        document.getElementById('alert_cc_confirm').onclick = () => {
                                        location.href=`{{ route('lecture.notice.delete', ['lecture_id' => $lecture_id, 'notice_id' => $notice['id']]) }}`
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
