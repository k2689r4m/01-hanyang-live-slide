@extends('backup.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">내 강의실</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{--                    {{ __('You are logged in!') }}--}}

                        <div class="lecture-content-top">
                            <div class="lecture-content-top-right">
                                @if (Route::has('lecture.create'))
                                    <a href="{{ route('lecture.create') }}">개설하기</a>
                                @endif
                                {{--                                <button type="submit" onClick="modal_up({{$cls['id']}})" class="btn btn-secondary generalDonation" data-toggle="modal" data-keyboard="false" data-target="#myModalHorizontal">삭제</button>--}}
                                <button type="submit" class="btn btn-secondary generalDonation" data-toggle="modal" data-keyboard="false" data-target="#myModalHorizontal">참여하기</button>
                            </div>
                        </div>

                        <hr>

                        @foreach ($host as $h)
                            <div style="display: flex; align-items: center">
                                <div style="width: 68%;">
                                    <a href="/classes/{{ $h['id'] }}" >{{ $h['name'] }}</a>
                                </div>
                                <div style="border-left: #ccc 1px solid;height: 30px;width: 1%;"></div>
                                <div style="width: 10%; display: flex;justify-content: center;">
                                    <strong>교수자</strong>
                                </div>
                                <div style="border-left: #ccc 1px solid;height: 30px;width: 1%;"></div>
                                <div style="width: 20%; display: flex; justify-content: space-between;">
                                    <button style="width: 45%;" type="button" onclick="handleLectureEdit({{ $h['id'] }})">수정</button>
                                    <button style="width: 45%;" type="button" onclick="handleLectureDelete({{ $h['id'] }})">삭제</button>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                        @foreach ($guest as $g)
                            <div style="display: flex; align-items: center">
                                <div style="width: 68%;">
                                    <a href="/classes/{{ $g->lecture['id'] }}" >{{ $g->lecture['name'] }}</a>
                                </div>
                                <div style="border-left: #ccc 1px solid;height: 30px;width: 1%;"></div>
                                <div style="width: 10%; display: flex;justify-content: center;">
                                    <strong>참여자</strong>
                                </div>
                                <div style="border-left: #ccc 1px solid;height: 30px;width: 1%;"></div>
                                <div style="width: 20%; display: flex; justify-content: space-between;">
                                    <button type="button" class="btn btn-secondary generalDonation" data-toggle="modal" data-keyboard="false" data-target="#myModalDetail" onclick="modal_up(`{{ $g->lecture['name'] }}`, `{{ $g->lecture['description'] }}`, `{{ $g->lecture['lecture_goal_desc'] }}`, {{ $g->lecture['classes'] }}, {{ $g->lecture['evaluation'] }})">과목정보</button>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>







    {{--<button type="submit" class="btn btn-secondary generalDonation" data-toggle="modal" data-keyboard="false" data-target="#myModalHorizontal">참여하기</button>--}}
    {{--강의 참여하기 모달--}}
    <div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <!-- Modal Header -->
            {{--                    <div class="modal-header" style="background: #ff0000">--}}
            {{--                    </div>            --}}
            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <form method="POST" action="{{ route('home.participation') }}" style="width: 100%;height: 100%;">
                            @csrf
                            <div class="col-sm-12" style="padding-bottom: 10px">
                                <input style="width: 100%;" type="text" placeholder="강의 코드..." name="lecture_code" />
                            </div>
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-secondary">확인</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--과목 정보 모달--}}
    <div class="modal fade" id="myModalDetail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <!-- Modal Header -->
            {{--                    <div class="modal-header" style="background: #ff0000">--}}
            {{--                    </div>            --}}
            <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            과목 상세 정보
                        </div>
                        <div class="col-sm-12 row" style="margin-top: 10px;">
                            <span class="col-sm-4 h6 small h-100 d-flex align-items-center">과목명</span><input class="col-sm-8" id="modal_name" type="text" readonly />
                        </div>
                        <div class="col-sm-12 row" style="margin-top: 10px;">
                            <span class="col-sm-4 h6 small h-100 d-flex align-items-center">과목 소개</span><textarea class="col-sm-8" id="modal_description" readonly></textarea>
                        </div>
                        <div class="col-sm-12 row" style="margin-top: 10px;">
                            <span class="col-sm-4 h6 small h-100 d-flex align-items-center">학습 목표</span><textarea class="col-sm-8" id="modal_lecture_goal_desc" readonly></textarea>
                        </div>
                        <div class="col-sm-12 row" style="margin-top: 20px;">
                            <span class="col-sm-12 h6 small">주차별 수업안내</span>
                            <textarea class="col-sm-12" id="modal_classes" readonly></textarea>
                        </div>
                        <div class="col-sm-12 row" style="margin-top: 10px;">
                            <span class="col-sm-12 h6 small">평가방법</span>
                            <textarea class="col-sm-12" id="modal_evaluation" readonly></textarea>
                        </div>
                        {{--                    <div class="col-sm-12" style="padding-bottom: 10px">--}}
                        {{--                        <input id="lecture_code1" style="width: 100%;" type="text" placeholder="강의 코드..." name="lecture_code" />--}}
                        {{--                    </div>--}}
                        <div class="col-sm-12 text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">확인</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{--<script type="text/javascript">--}}

    {{--</script>--}}



@endsection

@section('script')
    <script>




        function modal_up(name, description, lecture_goal_desc, classes, evaluation) {
            document.getElementById('modal_name').value = name;
            document.getElementById('modal_description').value = description;
            document.getElementById('modal_lecture_goal_desc').value = lecture_goal_desc;

            let classesHTML = '';

            classes.forEach(element => {
                const _element = JSON.parse(element);

                if (classesHTML !== ``) {
                    classesHTML = classesHTML + `\n`;
                }

                classesHTML = classesHTML + `${ _element.title } : ${ _element.desc }`;
            });

            document.getElementById('modal_classes').innerHTML = classesHTML;

            let evaluationHTML = '';

            evaluation.forEach(element => {
                const _element = JSON.parse(element);

                if (evaluationHTML !== ``) {
                    evaluationHTML = evaluationHTML + `
                    `;
                }

                evaluationHTML = evaluationHTML + `${ _element.factor } : ${ _element.ratio }`;
            });

            document.getElementById('modal_evaluation').innerHTML = evaluationHTML;
        }

        function handleLectureEdit(id) {
            location.href = `lecture`;
        }

        function handleLectureDelete(id) {
            const result = confirm('선택한 강의를 정말로 지우시겠습니까?');

            if (result) location.href = `lecture`;
        }
    </script>
@endsection
