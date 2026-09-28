@extends('layout.sidebar_layout')

@section('title')
    통계
@endsection

@section('lecture.analysis.detail.script')

@endsection

@section('content')
    <ul class="tab-menu">
        <li class="tab-menu__item"><a href="{{ route('lecture.infoView', ['lecture_id' => $lecture_id]) }}">기본정보</a></li>
        <li class="tab-menu__item"><a href="{{ route('class.mainView', ['lecture_id' => $lecture_id, 'class_id' => $class_id]) }}">수업</a></li>
        <li class="tab-menu__item active"><a href="{{ route('lecture.analysisView', ['lecture_id' => $lecture_id]) }}">통계</a></li>
    </ul>
    <div class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home"></li>
            <li class="page-nav__item">내 강의실</li>
            <li class="page-nav__item">수업</li>
        </ul>
    </div>
    <div class="content__wrap exist-nav exist-leftmenu round">
        <div class="content exist-tab analysis__wrap">
            <h3 class="analysis__tit">{{ $class->name }}</h3>
            <table class="mt-20 txt-only">
                <colgroup>
                    <col width="10%" />
                    <col width="40%" />
                    <col width="8%" />
                    <col width="8%" />
                    <col width="8%" />
                    <col width="18%" />
                    <col width="8%" />
                </colgroup>
                <tr>
                    <th>슬라이드 번호</th>
                    <th>슬라이드 타입</th>
                    <th>침여여부</th>
                    <th>정답률</th>
                    <th>순위</th>
                    <th>답변내용</th>
                    <th>정답여부</th>
                </tr>
                @foreach($data as $d)
                    <tr>
                        <td>{{ $d['index'] }}</td>
                        <td>
                            @switch($d['type'])
                                @case('multiple_choice')
                                    Quiz_객관식
                                    @break
                                @case('short_answer')
                                    Quiz_주관식
                                    @break
                                @case('text')
                                    Content_텍스트
                                    @break
                                @case('image')
                                    Content_이미지
                                    @break
                                @case('text_image')
                                    Content_텍스트+이미지
                                    @break
                                @default
                                    none
                                    @break
                            @endswitch
                        </td>
                        <td>
                            @if (!!$d['attempt'])
                                <span class="state-o"></span>
                            @else
                                <span class="state-x"></span>
                            @endif

                        </td>
                        <td>{{ $d['correct_rate'] }}</td>
                        <td>{{ $d['rank'] }}</td>
                        <td>{{ $d['answer'] }}</td>
                        <td>
                            @if (!$d['attempt'])
                            @elseif (!!$d['is_answer'])
                                <span class="state-o"></span>
                            @else
                                <span class="state-x"></span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="a-center p-30">
                <button class="btn-line btn-gray btn-normal btn-round btn-back" onclick="location.href=`{{ route('lecture.analysisView', ['lecture_id' => $lecture_id, 'class_id' => $class_id]) }}`">목록으로</button>
            </div>
        </div>
    </div>
@endsection