@extends('layout.layout')
@section('title')
    내 강의실
@endsection

@section('script')
{{--    window.axios = require('axios');--}}
$( function() {
    $( "select" ).selectmenu();
} );
@endsection

@section('content')
<form method="post" action="{{ route('lecture.join') }}">
    @csrf
    <div class="dim dn" id="lecture_code_modal">
        <div class="alert">
            <div class="alert__con">
                입장코드를 입력하세요.
                <input type="text" name="lecture_code" class="mt-10 a-center t-bold" id="lecture_code" />
            </div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn gray" type="button" onclick="
                    document.getElementById('lecture_code').value = '';
                    document.getElementById('lecture_code_modal').classList.add('dn')">
                        취소
                    </button>
                </div>
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary">확인</button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="dim dn" id="lecture_delete_modal">
    <div class="alert">
        <div class="alert__con" id="lecture_delete_modal_title">
            생활 속의 화학 DSE34A11를<br>삭제하시겠습니까?
        </div>
        <div class="alert__bottom">
            <div class="alert__btn-wrap">
                <button class="alert__btn gray" onclick="document.getElementById('lecture_delete_modal').classList.add('dn')">취소</button>
            </div>
            <div class="alert__btn-wrap">
                <button class="alert__btn primary" id="lecture_delete_modal_confirm">확인</button>
            </div>
        </div>
    </div>
</div>

<div class="dim dn"  id="lecture_copy_modal">
    <div class="alert">
        <div class="alert__con">
            기존에 만든 과목 복사<br />
            <select id='lectureToCopy' class="alert__select">
                <option value="">새로 생성</option>
                @foreach ($my_lectures as $my_lecture)
                    <option value="{{$my_lecture['id']}}">{{$my_lecture['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class="alert__bottom">
            <div class="alert__btn-wrap">
                <button class="alert__btn gray" onclick="document.getElementById('lecture_copy_modal').classList.add('dn')">취소</button>
            </div>
            <div class="alert__btn-wrap">
                <button class="alert__btn primary ok-btn">확인</button>
            </div>
        </div>
    </div>
</div>

<div class="dim @if(!$errors->has('lecture_code')) dn @endif" id="lecture_code_wrong_modal">
    <div class="alert" >
        <div class="alert__con">
            @if($errors->has('lecture_code')){{ $errors->first('lecture_code') }}@endif
        </div>
        <div class="alert__bottom">
            <div class="alert__btn-wrap">
                <button class="alert__btn primary" onclick="event.target.parentNode.parentNode.parentNode.parentNode.classList.add('dn')">확인</button>
            </div>
        </div>
    </div>
</div>


<div id="lecture_info_modal" class="alert alert-lg scroll dn">
    <div class="alert__con">
        <div class="alert__scroll">
            <h3 class="alert__tit">과목 상세 정보</h3>
            <div class="alert__txt-box">
                <h4 class="alert__sub">과목명</h4>
                <p class="alert__txt"><strong id="lecture_name"></strong></p>
                <h4 class="alert__sub">과목 소개</h4>
                <p class="alert__txt" id="lecture_description"></p>
                <h4 class="alert__sub">학습 목표</h4>
                <ul class="alert__txt list" id="lecture_goal_desc">
                </ul>
                <h4 class="alert__sub">주차별 수업안내</h4>
                <p class="alert__txt" id="lecture_classes">
                </p>
                <h4 class="alert__sub">평가 방법</h4>
                <div class="alert__txt">
                    <table id="lecture_evaluation">
                        <colgroup>
                            <col width="15%" />
                            <col width="85%" />
                        </colgroup>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="alert__bottom">
        <div class="alert__btn-wrap">
            <button class="alert__btn primary" onclick="document.getElementById('lecture_info_modal').classList.add('dn')">확인</button>
        </div>
    </div>
</div>

<div class="content__wrap">
    <!-- myclass top -->
    <div class="myclass-top">
        <ul class="page-nav">
            <li class="page-nav__item home cp" onclick="location.href=`{{ route('lecture.mainView') }}`"></li>
            <li class="page-nav__item cp" onclick="location.href=`{{ route('lecture.mainView') }}`">내 강의실</li>
        </ul>
        <h2 class="myclass-top__tit">내 강의실</h2>
        <p class="myclass-top__notify">총 {{ $lecture_count }}개의 운영 중인 강의실이 있습니다.</p>
        <button class="btn-md btn-round btn-white create-lecture-btn">개설하기</button>
        <button class="btn-md btn-round btn-white"
                onclick="document.getElementById('lecture_code_modal').classList.remove('dn')">참여하기</button>
    </div>
    <!-- //myclass top -->

    <!-- myclass list -->
    <table class="myclass-table">
        <colgroup>
            <col width="5%" />
            <col width="12%" />
            <col width="32%" />
            <col width="7%" />
            <col width="7%" />
            <col width="10%" />
            <col width="12%" />
            <col width="15%" />
        </colgroup>
        <tr>
            <th>No</th>
            <th>입장코드</th>
            <th class="left">과목명</th>
            <th>수업 수</th>
            <th>정원</th>
            <th>수강기간</th>
            <th>권한</th>
            <th></th>
        </tr>
        @foreach ($lectures as $lecture)
        <tr>
            <td>{{ $lecture['index'] }}</td>
            <td>{{ $lecture['lecture']->lecture_code }}</td>
            <td class="left"><a class="cp" href="{{ route('lecture.lectureView', ['lecture_id' => $lecture['lecture']->id]) }}">{{ $lecture['lecture']->name }}</a></td>
            <td>{{ $lecture['lecture']->classes()->count()}}개</td>
            <td>{{ $lecture['lecture']->members()->count() - 1 }}명</td>
            <td>{{ date('Y.m.d', strtotime($lecture['lecture']->lecture_start_date)) }}</td>
            @if($lecture['lecture']->user_id === auth()->id())
                <td>
                    <button class="btn-normal btn-round btn-pro cd">교수자</button>
                </td>
                <td>
                    <button class="btn-normal btn-round btn-gray btn-line" onclick="window.location='{{ route('lecture.editView', [ 'id' => $lecture['lecture']->id ]) }}'">
                        수정
                    </button>
{{--                        생활 속의 화학 DSE34A11를<br>삭제하시겠습니까?--}}
                    <button class="btn-normal btn-round btn-gray btn-line" onclick="
                        document.getElementById('lecture_delete_modal_title').innerHTML =
                        `{{ $lecture['lecture']->name }} {{ $lecture['lecture']->lecture_code }}를<br>삭제하시겠습니까?`;

                        document.getElementById('lecture_delete_modal').classList.remove('dn');

                        document.getElementById('lecture_delete_modal_confirm').addEventListener('click', () => {
                                location.href='{{ route('lecture.delete', [ 'id' => $lecture['lecture']->id ]) }}'
                            })
                    ">
                        삭제
                    </button>
                </td>
            @else
                <td><button class="btn-normal btn-round btn-stu cd">학습자</button></td>
                <td>
                    <button class="btn-normal col2 btn-round btn-gray btn-line" id="{{$lecture['lecture']->id}}_lecture_info" onclick="
                    const modal = document.getElementById('lecture_info_modal');
                    modal.classList.remove('dn');
                    document.getElementById('lecture_name').innerHTML = '{{ $lecture['lecture']->name }}';
                    document.getElementById('lecture_description').innerHTML = '{{ $lecture['lecture']->description }}';
                    document.getElementById('lecture_goal_desc').innerText = '{{ $lecture['lecture']->lecture_goal_desc }}';

                    document.getElementById('lecture_classes').innerHTML =`
                        @foreach($lecture['lecture']->classes as $class)
                             <strong>{{ $class->title }} : </strong>{{ $class->desc }}<br>
                        @endforeach
                    `;

                    document.getElementById('lecture_evaluation').innerHTML = `
                        <colgroup>
                            <col width='15%' />
                            <col width='85%' />
                        </colgroup>
                        @foreach($lecture['lecture']->evaluation as $evaluation)
                            <tr>
                                <th>{{ $evaluation->factor }}</th>
                                <td>{{ $evaluation->ratio }}%</td>
                            </tr>
                        @endforeach
                    `;
                ">과목정보</button>
                </td>
            @endif
        </tr>
        @endforeach
    </table>

    {{ $lectures->links('vendor.pagination.roc') }}
</div>
@endsection
@section('lecture.main.script')
    const createLectureBtn = document.querySelector('.create-lecture-btn');
    const lectureCopyModal = document.querySelector('#lecture_copy_modal');
    const myLectureList =  lectureCopyModal.querySelector('#lectureToCopy');

    lectureCopyModal.querySelector('.ok-btn').addEventListener('click', () => {
        const selectedLecture = myLectureList.options[myLectureList.selectedIndex];

        if (selectedLecture.value === '') window.location=`{{ route('lecture.writeView') }}`;
        else window.location=`{{ route('lecture.writeView') }}?id=${selectedLecture.value}`;
    });

    createLectureBtn.addEventListener('click', () => {
        @if (count($my_lectures) > 0)
            lectureCopyModal.classList.remove('dn');
            myLectureList.selectedIndex = 0;
        @else
            window.location='{{ route('lecture.writeView') }}';
        @endif
    });
@endsection



{{--<form method="post" action="{{ route('lecture.join') }}">--}}
{{--    @csrf--}}
{{--    <input type="text" placeholder="lecture_code" name="lecture_code" />--}}
{{--    <button>join lecture</button>--}}
{{--</form>--}}

{{--<table>--}}
{{--    <thead>--}}
{{--        <tr>--}}
{{--            <td>No</td>--}}
{{--            <td>입장코드</td>--}}
{{--            <td>과목명</td>--}}
{{--            <td>수업 수</td>--}}
{{--            <td>정원</td>--}}
{{--            <td>수업기간</td>--}}
{{--            <td>권한</td>--}}
{{--            <td>-</td>--}}
{{--        </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}
{{--@foreach ($lectures as $lecture)--}}
{{--    <tr>--}}
{{--        <td>{{ $lecture->id }}</td>--}}
{{--        <td>{{ $lecture->lecture_code }}</td>--}}
{{--        <td><a href="{{ route('lecture.lectureView', ['lecture_id' => $lecture->id]) }}">{{ $lecture->name }}</a></td>--}}
{{--        <td>0</td>--}}
{{--        <td>0</td>--}}
{{--        <td>{{ $lecture->num_of_classes }}</td>--}}
{{--        <td>{{ $lecture->num_of_members }}</td>--}}
{{--            <td></td>--}}
{{--            <td></td>--}}
{{--        <td>{{ $lecture->lecture_start_date }}</td>--}}
{{--        @if ($lecture->user_id - request()->get('user')->id === 0)--}}
{{--            <td>교수</td>--}}
{{--            <td>--}}
{{--                <a href="{{ route('lecture.editView', [ 'id' => $lecture->id ]) }}">수정</a>--}}
{{--                <a href="{{ route('lecture.delete', [ 'id' => $lecture->id ]) }}">삭제</a>--}}
{{--            </td>--}}
{{--        @else--}}
{{--            <td>학습자</td>--}}
{{--            <td>--}}
{{--                <a href="#">과목정보</a>--}}
{{--            </td>--}}
{{--        @endif--}}
{{--    </tr>--}}
{{--@endforeach--}}
{{--    </tbody>--}}
{{--</table>--}}



{{--@foreach ($items as $lecture)--}}
{{--    {{ $lecture }}--}}
{{--@endforeach--}}
{{--{{ $items->links() }}--}}

{{--{{ $lectures->links() }}--}}

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
