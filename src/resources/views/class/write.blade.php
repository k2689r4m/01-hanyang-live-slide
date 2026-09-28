@extends('layout.layout')

@section('title')
    New Class
@endsection

{{--@section('sctipt')--}}
{{--        $( function() {--}}
{{--            $( ".datepicker" ).datepicker({dateFormat: 'yy.mm.dd'});--}}
{{--            $( "select" ).selectmenu();--}}
{{--        } );--}}
{{--@endsection--}}
@section('class.write.script')
    $( function() {
    $( ".datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
    });


    @if($errors->any())
        const confirmModal = document.getElementById("confirm-modal");
        confirmModal.classList.remove("dn");
        const confirmModalOk = document.getElementById("confirm-modal-ok");
        confirmModalOk.addEventListener("click", () => {
        confirmModal.classList.add("dn");
        })
    @endif

    var period_count = document.getElementsByName('active_always').length;
    for (var i=0;i < period_count;i++){
    console.log('asdfasf');
        if(document.getElementsByName("active_always")[i].checked){
            if(i==0){
                document.getElementById('period_datepicker1').classList.remove('active')
                document.getElementById('period_datepicker2').classList.remove('active')
            }
            else if(i==1){
                document.getElementById('period_datepicker1').classList.remove('active')
                document.getElementById('period_datepicker2').classList.remove('active')
                document.getElementById('period_datepicker1').classList.add('active')
                document.getElementById('period_datepicker2').classList.add('active')
            }
            else if(i==2){
                document.getElementById('period_datepicker1').classList.remove('active')
                document.getElementById('period_datepicker2').classList.remove('active')
            }
        }
    }

    var replay_count = document.getElementsByName('record_always').length;

    for (var i=0;i < replay_count;i++){
        if(document.getElementsByName("record_always")[i].checked){
            if(i==0){
                document.getElementById('replay_datepicker1').classList.remove('active')
                document.getElementById('replay_datepicker2').classList.remove('active')
            }
            else if(i==1){
                document.getElementById('replay_datepicker1').classList.remove('active')
                document.getElementById('replay_datepicker2').classList.remove('active')
                document.getElementById('replay_datepicker1').classList.add('active')
                document.getElementById('replay_datepicker2').classList.add('active')
            }
            else if(i==2){
                document.getElementById('replay_datepicker1').classList.remove('active')
                document.getElementById('replay_datepicker2').classList.remove('active')
            }
        }
    }
@endsection

@section('script')
    function period_check(){
    var period_count = document.getElementsByName('active_always').length;

    for (var i=0;i < period_count;i++){
    if(document.getElementsByName("active_always")[i].checked){
    if(i==0){
    document.getElementById('period_datepicker1').classList.remove('active')
    document.getElementById('period_datepicker2').classList.remove('active')
    }
    else if(i==1){
    document.getElementById('period_datepicker1').classList.remove('active')
    document.getElementById('period_datepicker2').classList.remove('active')
    document.getElementById('period_datepicker1').classList.add('active')
    document.getElementById('period_datepicker2').classList.add('active')
    }
    else if(i==2){
    document.getElementById('period_datepicker1').classList.remove('active')
    document.getElementById('period_datepicker2').classList.remove('active')
    }
    }
    }
    }

    function replay_check(){
    var replay_count = document.getElementsByName('record_always').length;

    for (var i=0;i < replay_count;i++){
    if(document.getElementsByName("record_always")[i].checked){
    if(i==0){
    document.getElementById('replay_datepicker1').classList.remove('active')
    document.getElementById('replay_datepicker2').classList.remove('active')
    }
    else if(i==1){
    document.getElementById('replay_datepicker1').classList.remove('active')
    document.getElementById('replay_datepicker2').classList.remove('active')
    document.getElementById('replay_datepicker1').classList.add('active')
    document.getElementById('replay_datepicker2').classList.add('active')
    }
    else if(i==2){
    document.getElementById('replay_datepicker1').classList.remove('active')
    document.getElementById('replay_datepicker2').classList.remove('active')
    }
    }
    }
    }
@endsection

@section('content')
    <div class="dim dn" id="confirm-modal">
        <div class="alert pf">
            <div class="alert__con">
                @if($errors->any())
                    {!! nl2br($errors->first()) !!}
                @endif
            </div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary" id="confirm-modal-ok">확인</button>
                </div>
            </div>
        </div>
    </div>

    <header class="comp-header">
        <h1 class="comp-header__logo">로고</h1>
    </header>
    <!-- //compact header -->

    <!-- new class -->
    <div class="content__wrap exist-nav type2">
        <div class="page-nav-warp">
            <ul class="page-nav gray">
                <li class="page-nav__item home cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture_id]) }}'"></li>
                <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.lectureView', ['lecture_id' => $lecture_id]) }}'">내 강의실</li>
                <li class="page-nav__item cp">수업 개설하기</li>
            </ul>
        </div>
        <div class="content">
            <h2 class="content__tit">수업 개설하기</h2>
            <div class="input-box subject new-class">
                <form method="post" action="{{ route('class.write',['lecture_id' => $lecture_id]) }}">
                    @csrf
                    <div class="input-box__input">
                        <label class="input-box__label">수업명 </label>
                        <input type="text" placeholder="수업명을 입력하세요" value="{{ old("class_name") }}" name="class_name" />
                    </div>
                    <div class="input-box__input mb-50">
                        <label class="input-box__label">수업 URL </label>
                        <input type="text" name="user_url" placeholder="수업 URL" value="{{ old("user_url") }}" />
                    </div>

                    <div class="input-box__input">
                        <label class="input-box__label">수업 입장기간을 설정하세요.</label>
                        <label class="radio">
                            <input type="radio" name="active_always" onclick="period_check()" value="0"
                                {{ old('active_always') == '0' ? 'checked' : '' }}/> 항상 활성화
                        </label>
                        <label class="radio">
                            <input type="radio" name="active_always" onclick="period_check()" value="1"
                                {{ old('active_always') == '1' ? 'checked' : '' }}/> 제한
                        </label>
                        <label class="radio">
                            <input type="radio" name="active_always" onclick="period_check()" value="2"
                                {{ old('active_always') == '2' ? 'checked' : '' }}/> 비활성화
                        </label>
                        <div class="datepicker-wrap" id="period_datepicker1">
                            <label class="label">시작</label>
                            <label class="datepicker__label">
                                <input type="text"
                                       class="datepicker"
                                       placeholder="선택"
                                       value="{{ old("active_start_date") ?? date('Y-m-d') }}"
                                       readonly name="active_start_date"
                                />
                            </label>
                            <select name="period_start_hours">
                                @for($i = 0;$i < 24;$i++)
                                    <option value={{$i}}>{{ sprintf("%'02d", $i) }}</option>
                                @endfor
                            </select>
                            시&nbsp;&nbsp;&nbsp;
                            <select name="period_start_minutes">
                                @for($i = 0;$i < 60;$i++)
                                    <option value={{$i}}>{{ sprintf("%'02d", $i) }}</option>
                                @endfor
                            </select>
                            분
                        </div>
                        <div class="datepicker-wrap mb-50" id="period_datepicker2">
                            <label class="label">종료</label>
                            <label class="datepicker__label">
                                <input type="text"
                                       class="datepicker"
                                       placeholder="선택"
                                       value="{{ old("active_end_date") ?? date('Y-m-d', strtotime('+1 day')) }}"
                                       readonly name="active_end_date"
                                />
                            </label>
                            <select name="period_end_hours">
                                @for($i = 0;$i < 24;$i++)
                                    <option value={{$i}}>{{ sprintf("%'02d", $i) }}</option>
                                @endfor
                            </select>
                            시&nbsp;&nbsp;&nbsp;
                            <select name="period_end_minutes">
                                @for($i = 0;$i < 60;$i++)
                                    <option value={{$i}}>{{ sprintf("%'02d", $i) }}</option>
                                @endfor
                            </select>
                            분
                        </div>
                    </div>
                    <div class="input-box__input">
                        <label class="input-box__label">수업 다시보기 기간을 설정하세요.</label>
                        <label class="radio">
                            <input type="radio" name="record_always" onclick="replay_check()" value="0"
                                {{ old('record_always') == '0' ? 'checked' : '' }}/> 항상 활성화
                        </label>
                        <label class="radio">
                            <input type="radio" name="record_always" onclick="replay_check()" value="1"
                                {{ old('record_always') == '1' ? 'checked' : '' }}/> 제한
                        </label>
                        <label class="radio">
                            <input type="radio" name="record_always" onclick="replay_check()" value="2"
                                {{ old('record_always') == '2' ? 'checked' : '' }}/> 비활성화
                        </label>
                        <div class="datepicker-wrap" id="replay_datepicker1">
                            <label class="label">시작</label>
                            <label class="datepicker__label">
                                <input type="text"
                                       class="datepicker"
                                       placeholder="선택"
                                       value="{{ old("active_start_date") ?? date('Y-m-d', strtotime('+2 day')) }}"
                                       name="record_start_date"
                                />
                            </label>
                            <select name="record_start_hours">
                                @for($i = 0;$i < 24;$i++)
                                    <option value={{$i}}>{{ sprintf("%'02d", $i) }}</option>
                                @endfor
                            </select>
                            시&nbsp;&nbsp;&nbsp;
                            <select name="record_start_minutes">
                                @for($i = 0;$i < 60;$i++)
                                    <option value={{$i}}>{{ sprintf("%'02d", $i) }}</option>
                                @endfor
                            </select>
                            분
                        </div>
                        <div class="datepicker-wrap mb-50" id="replay_datepicker2">
                            <label class="label">종료</label>
                            <label class="datepicker__label">
                                <input type="text"
                                       class="datepicker"
                                       placeholder="선택"
                                       value="{{ old("active_end_date") ?? date('Y-m-d', strtotime('+3 day')) }}"
                                       name="record_end_date"
                                />
                            </label>
                            <select name="record_end_hours">
                                @for($i = 0;$i < 24;$i++)
                                    <option value={{$i}}>{{ sprintf("%'02d", $i) }}</option>
                                @endfor
                            </select>
                            시&nbsp;&nbsp;&nbsp;
                            <select name="record_end_minutes">
                                @for($i = 0;$i < 60;$i++)
                                    <option value={{$i}}>{{ sprintf("%'02d", $i) }}</option>
                                @endfor
                            </select>
                            분
                        </div>
                    </div>
                    <div class="a-center">
                        <input type="reset" class="btn btn-normal col2 btn-round btn-gray btn-line mr-20" value="취소" onclick="history.back()" />
                        <input type="submit" class="btn btn-normal col2 btn-round btn-primary" value="시작" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- //new class -->
@endsection



{{--<form method="post" action="{{ route('class.write',['lecture_id' => $lecture_id]) }}">--}}
{{--    @csrf--}}
{{--    Class Write<br/>--}}
{{--    <input type="text" name="name" placeholder="수업명" value="{{ old("name") }}" /><br/>--}}
{{--    <input type="text" name="user_url" placeholder="수업 URL" value="{{ old("user_url") }}" /><br/>--}}

{{--    <input type="radio" name="active_always" value="0" checked/>--}}
{{--    <input type="radio" name="active_always" value="1" />--}}
{{--    <input type="radio" name="active_always" value="2" /><br>--}}
{{--    <input type="text" name="active_start_date" placeholder="active_start_date" value="{{ old("active_start_date") ?? date('Y-m-d H:i:s') }}" /><br>--}}
{{--    <input type="text" name="active_end_date" placeholder="active_end_date" value="{{ old("active_end_date") ?? date('Y-m-d H:i:s', strtotime('+1 day')) }}" /><br>--}}

{{--    <input type="radio" name="record_always" value="0" checked/>--}}
{{--    <input type="radio" name="record_always" value="1" />--}}
{{--    <input type="radio" name="record_always" value="2" /><br>--}}
{{--    <input type="text" name="record_start_date" placeholder="active_start_date" value="{{ old("active_start_date") ?? date('Y-m-d H:i:s', strtotime('+2 day')) }}" /><br>--}}
{{--    <input type="text" name="record_end_date" placeholder="active_end_date" value="{{ old("active_end_date") ?? date('Y-m-d H:i:s', strtotime('+3 day')) }}" /><br>--}}

{{--    <button type="button" onclick="history.back()">취소</button>--}}
{{--    <button type="submit">시작</button>--}}
{{--</form>--}}
