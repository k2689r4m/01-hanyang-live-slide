@extends('layout.sidebar_layout')

@section('title')
    통계
@endsection

@section('lecture.analysis.detail.script')

@endsection

<script>
    const handleAnalysis = (data, type, rType) => {
        if (rType === 'rating') {
            document.getElementById('alert_h1').innerText = '순위';
            document.getElementById('alert_h3').innerText = '점수';
        }
        else {
            document.getElementById('alert_h1').innerText = '번호';
            document.getElementById('alert_h3').innerText = '답변';
        }
        document.getElementById('alert_h2').innerText = @if (!$lecture->use_nickname) '이름' @else '닉네임' @endif;

        const alert_analysis = document.getElementById('alert_analysis');

        const table = document.getElementById('alert_analysis_tbody');

        while(table.hasChildNodes()) table.removeChild(table.firstChild);

        data.forEach((d, index) => {
            const element = document.createElement('tr');

            if (rType === 'rating') {
                element.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${d.user.hasOwnProperty('name') ? d.user.name : d.user.nickname}</td>
                    <td>${d.score}</td>
                `;
            }
            else {
                element.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${d.user.hasOwnProperty('name') ? d.user.name : d.user.nickname}</td>
                    <td>${type === 'multiple_choice' ? d.answer_data * 1 + 1 : d.answer_data}</td>
                `;
            }

            table.appendChild(element);
        })

        alert_analysis.classList.remove('dn');
    }
</script>

@section('content')
    <div class="dim dn" id="alert_analysis">
        <div class="alert alert-md scroll">
            <div class="alert__con alert__scroll pt-0 pb-0">
                <table id="alert_analysis_table" class="even-bg">
                    <colgroup>
                        <col width="20%" />
                        <col width="60%" />
                        <col width="20%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th id="alert_h1" class="pt-0">번호</th>
                            <th id="alert_h2" class="pt-0">이름</th>
                            <th id="alert_h3" class="pt-0">답변</th>
                        </tr>
                    </thead>
                    <tbody id="alert_analysis_tbody">
                    </tbody>
                </table>
            </div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary" onclick="this.parentNode.parentNode.parentNode.parentNode.classList.add('dn')">확인</button>
                </div>
            </div>
        </div>
    </div>

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
            <ul class="tab-menu2">
                <li class="tab-menu2__item"><a href="{{ route('lecture.analysis.graph.detailView', ['lecture_id' => $lecture_id, 'class_id' => $class_id]) }}">그래프</a></li>
                <li class="tab-menu2__item active"><a href="{{ route('lecture.analysis.list.detailView', ['lecture_id' => $lecture_id, 'class_id' => $class_id]) }}">목록</a></li>
            </ul>
            <table class="mt-20">
                <colgroup>
                    <col width="10%" />
                    <col width="50%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                </colgroup>
                <tr>
                    <th>슬라이드 번호</th>
                    <th>슬라이드 타입</th>
                    <th>참여율</th>
                    <th>정답률</th>
                    <th>순위</th>
                    <th>답변내용</th>
                </tr>
                @foreach($pagination as $page)
                    <tr>
                        <td>{{ $page['index'] }}</td>
                        <td>
                            @switch($page['slide_type'])
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
                            @endswitch
                        </td>
                        <td>{{ $page['attempt_rate'] }}</td>
                        @if ($page['slide_type'] == 'multiple_choice' || $page['slide_type'] == 'short_answer')
                            <td>
                                @isset($page['correct_rate'])
                                    {{ $page['correct_rate'] }}
                                @endisset
                            </td>
                            <td>
                                @isset($page['ratings'])
                                    <button class="btn-normal btn-round btn-gray btn-line" onclick='
                                    handleAnalysis({!! json_encode($page['ratings']) !!}, `{{ $page['slide_type'] }}`, `rating`);
                                '>확인</button>
                                @endisset
                            </td>
                            <td><button class="btn-normal btn-round btn-gray btn-line" onclick='
                                handleAnalysis({!! json_encode($page['answers']) !!}, `{{ $page['slide_type'] }}`, `answer`);
                            '>확인</button></td>
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif

                    </tr>
                @endforeach
            </table>
            {{ $pagination->links('vendor.pagination.roc') }}
            <div class="a-center p-30">
                <button class="btn-line btn-gray btn-normal btn-round btn-back" onclick="location.href=`{{ route('lecture.analysisView', ['lecture_id' => $lecture_id, 'class_id' => $class_id]) }}`">목록으로</button>
            </div>
        </div>
    </div>
@endsection