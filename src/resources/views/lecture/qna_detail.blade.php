@extends('layout.sidebar_layout')

@section('title')
    질문답변
@endsection

@section('content')
    <div class="dim dn" id="alert_dim">
        <div class="alert">
            <div class="alert__con" id="alert_content">
                생활 속의 화학 DSE34A11를<br />삭제하시겠습니까?
            </div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn gray" onclick="event.target.parentNode.parentNode.parentNode.parentNode.classList.add('dn')">
                        취소
                    </button>
                </div>
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary" id="alert_confirm">
                        확인
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture_id]) }}'"></li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture_id]) }}'">내 강의실</li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.qnaView', ['lecture_id' => $lecture_id]) }} '">질문답변</li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.qna.detailView', ['lecture_id' => $lecture_id, 'qna_id' => $qna['id'] ]) }}'">질문답변 상세</li>
        </ul>
    </div>
    <!-- professor board -->
    <div class="content__wrap exist-nav exist-leftmenu round">
        <div class="content analysis__wrap">
            <h2 class="content__tit board-tit">질문답변</h2>
            <div class="board-detail">
                <div class="board-detail__tit">
                    <h3 class="tit">{{ $qna['title'] }}</h3>
                    <span class="date">{{ date('Y.m.d', strtotime($qna ['created_at'])) }}</span>
                    @if ($qna['user_id'] === request()->get('user')['id'])
                        <button class="modi" onclick="location.href='{{ route('lecture.qna.editView', ['lecture_id' => $lecture_id, 'qna_id' => $qna['id']]) }}'">수정</button><br/>
                    @endif
                </div>

                <div class="board-detail__con">
                    <p class="con">
                        {{ $qna['content'] }}
                    </p>

                    @foreach($qna['file'] as $file)
                        <div class="download"><a href="{{ route('lecture.qna.download', ['lecture_id' => $lecture_id, 'qna_id' => $qna['id'], 'file_name' => $file->fileName, 'download_name' => $file->fileRealName]) }}">{{ $file->fileRealName }}</a></div>
                    @endforeach
                </div>



            </div>
            <div class="a-center p-30">
                <button class="btn-gray btn-line btn-normal btn-round btn-back" onclick="location.href='{{ route('lecture.qnaView', ['lecture_id' => $lecture_id]) }} '">목록으로</button>
            </div>

            {{-- 댓 글  --}}
            <div class="board-coment">
                <form class="coment" method="post" action="{{ route('lecture.qna.comment.write', ['lecture_id' => $lecture_id, 'qna_id' => $qna['id']]) }}">
{{--                    <div class="a-center p-30 label" method="post" action="{{ route('lecture.qna.comment.write', ['lecture_id' => $lecture_id, 'qna_id' => $qna['id']]) }}">--}}
                    @csrf
                <label class="label">댓글 등록</label>
                    <input type="hidden" name="comment_id" value="-1" />
                    <textarea class="txt" tpye="text" placeholder="comments" name="content" rows="3" cols="50" ></textarea>
                    <button class="btn" type="button" onclick="
                        document.getElementById('alert_content').innerText = '등록하시겠습니까?';
                        document.getElementById('alert_confirm').onclick = () => {
                            document.getElementById('submit').click();
                        }
                        document.getElementById('alert_dim').classList.remove('dn');
                    ">등록</button>
                    <button id="submit" class="dn"></button>
                    <label class="radio">
                        <input type="radio" name="lock" value="0" checked/>공개
                    </label>
                    <label class="radio">
                        <input type="radio" name="lock" value="1"/>비공개
                    </label>
                </form>

                <h4 class="count">댓글<span class="t-primary"> {{$comments -> count()}}</span></h4>
                <ul class="list">
                    <!-- 댓글 없을 시 -->
                    <!-- <li class="item no-coment">댓글이 없습니다.</li> -->
{{--                    <li class="item">--}}
{{--                        <span class="name">홍길동</span>--}}
{{--                        <span class="date">2020.12.01</span>--}}
{{--                        <span class="time">15:21</span>--}}
{{--                        <p class="con">--}}
{{--                            www.asdf.co.kr/board/134 에 들어가서 다운 가능하십니다.--}}
{{--                        </p>--}}
{{--                    </li>--}}

                    @foreach($comments as $comment)
                        <li class="item">
                            <span class="name">{{$lecture->use_nickname ? $comment->user()->first()->nickname : $comment->user()->first()->name}}</span>
                            <span class="date">{{ date('Y.m.d h:i', strtotime($comment->created_at)) }}</span>
                            @if ($comment->user_id === auth()->id() || request()->get('isOwn'))
                                <button class="delete" type="button" onclick="
                                    document.getElementById('alert_content').innerText = '삭제하시겠습니까?';
                                    document.getElementById('alert_confirm').onclick = () => {
                                        location.href=`{{ route('lecture.qna.comment.delete', ['lecture_id' => $lecture_id, 'qna_id' => $qna->id, 'comment_id' => $comment->id]) }}`;
                                    }
                                    document.getElementById('alert_dim').classList.remove('dn');
                                ">삭제</button>
                            @endif
{{--                            <span class="time"></span>--}}<br>
                            @if ($comment->lock && $comment->user_id != auth()->id() && auth()->id() != $comment->qna()->first()->user_id && !request()->get('isOwn'))
                                <p class="con secret">
                                    비공개 댓글입니다.
                                </p>
                            @else
                                <p class="con" type="text" placeholder="comments" name="content" rows="2" cols="30">
                                    {{ $comment->content }}
                                </p>
                            @endif
{{--                            <button>작성</button> 대댓글 기능 비활성화로 주석처리--}}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection




{{--QNA DETAIL--}}
{{--<p>{{ $qna['title'] }}</p>--}}
{{--<p>{{ $qna ['created_at'] }}</p>--}}
{{--@if ($qna['user_id'] === request()->get('user')['id'])--}}
{{--    <a href="{{ route('lecture.qna.editView', ['lecture_id' => $lecture_id, 'qna_id' => $qna['id']]) }}">수정</a><br/>--}}
{{--@endif--}}


{{--<p>{{ $qna['content'] }}</p>--}}
{{--<hr/>--}}

{{--@foreach($qna['file'] as $file)--}}
{{--    <a href="{{ route('lecture.qna.download', ['lecture_id' => $lecture_id, 'qna_id' => $qna['id'], 'file_name' => $file->fileName, 'download_name' => $file->fileRealName]) }}">{{ $file->fileRealName }}</a><br/>--}}
{{--@endforeach--}}
{{--<hr/>--}}

{{--<form method="post" action="{{ route('lecture.qna.comment.write', ['lecture_id' => $lecture_id, 'qna_id' => $qna['id']]) }}">--}}
{{--    @csrf--}}
{{--    <input type="hidden" name="comment_id" value="-1" />--}}
{{--    <textarea tpye="text" placeholder="comments" name="content" rows="3" cols="50" ></textarea>--}}
{{--    <input type="radio" name="lock" value="0" checked/>공개--}}
{{--    <input type="radio" name="lock" value="1"/>비공개--}}
{{--    <button>작성</button>--}}
{{--</form>--}}
{{--<p>comments list</p>--}}
{{--@foreach($comments as $comment)--}}
{{--    <div @if ($comment->depth === 1) style="margin-left: 50px;" @endif>--}}
{{--        @if ($comment->lock === 1 && $comment->qna()->first()->user_id != request()->get('user')->id && $comment->user_id != request()->get('user')->id && !request()->get('isOwn'))--}}
{{--            @if ($use_nickname === 1)--}}
{{--                nickname : {{ $comment->user()->first()->nickname }}--}}
{{--            @else--}}
{{--                name : {{ $comment->user()->first()->name }}--}}
{{--            @endif--}}
{{--            <br/>--}}
{{--            comment : 비공개 댓글입니다.<br/>--}}
{{--            date : {{ explode(' ', $comment->created_at)[0] }}<br/><br/>--}}
{{--        @else--}}
{{--            @if ($use_nickname === 1)--}}
{{--                nickname : {{ $comment->user()->first()->nickname }}--}}
{{--            @else--}}
{{--                name : {{ $comment->user()->first()->name }}--}}
{{--            @endif--}}
{{--            <br/>--}}
{{--            comment--}}
{{--                @if($comment->lock)--}}
{{--                    (비밀댓글)--}}
{{--                @endif--}}
{{--                : {{ $comment->content }}<br/>--}}
{{--            date : {{ explode(' ', $comment->created_at)[0] }}<br/>--}}
{{--            @if ($comment->depth === 0)--}}
{{--                <strong>test comment input</strong>--}}
{{--                <form method="post" action="{{ route('lecture.qna.comment.write', ['lecture_id' => $lecture_id, 'qna_id' => $qna['id']]) }}">--}}
{{--                    @csrf--}}
{{--                    <input type="hidden" name="comment_id" value="{{ $comment->id }}" />--}}
{{--                    <textarea tpye="text" placeholder="comments" name="content" rows="2" cols="30" ></textarea>--}}
{{--                    <input type="radio" name="lock" value="0" checked/>공개--}}
{{--                    <input type="radio" name="lock" value="1"/>비공개--}}
{{--                    <button>작성</button>--}}
{{--                </form>--}}
{{--            @else--}}
{{--                <br/>--}}
{{--            @endif--}}
{{--        @endif--}}
{{--    </div>--}}
{{--@endforeach--}}
{{--<a href="{{ route('lecture.qnaView', ['lecture_id' => $lecture_id]) }}">목록으로</a>--}}


