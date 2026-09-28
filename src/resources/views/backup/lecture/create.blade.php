@extends('backup.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form id='frmCreate' method="POST" action="{{ route('lecture.create.submit') }}">
                        @csrf
                        <div class="card-header">강의 개설</div>

                        <div class="card-body">
                            {{--                    {{ __('You are logged in!') }}--}}

                            <div class="half-field">
                                <div class="half-field-content">
                                    과목명
                                    <input type="text" name="name"/>
                                </div>
                                <div class="half-field-content">
                                    입장 코드
                                    <input type="text" name="lecture_code" value="{{ $lecture_code }}" readonly />
                                </div>
                            </div>
                            <div>
                                과목 소개
                                <div>
                                    <textarea class="textarea-wrap" name="description" type="text" placeholder="강의 소개를 입력해 주세요." ></textarea>
                                </div>
                            </div>
                            <div>
                                학습 목표
                                <div>
                                    <textarea class="textarea-wrap" name="lecture_goal_desc" type="text" placeholder="학습 목표를 입력해 주세요." ></textarea>
                                </div>
                            </div>
                            <div>
                                수강 기간
                                <div>
                                    시작
                                    <input type="date" name="lecture_start_date"/>
                                    끝
                                    <input type="date" name="lecture_end_date"/>
                                </div>
                            </div>
                            <div>
                                추가 설정 (선택)
                            </div>
                            <div>
                                <input type="checkbox" name="use_nickname" /> 닉네임 사용
                            </div>
                            <div>
                                <input type="checkbox" name="use_classes" checked/> 주차 별 수업 안내
                                <div id="classes">
                                    <div class="class-container">
                                        <input type="text" placeholder="주차 별 타이틀" name="class_title[]" />
                                        <input type="text" name="class_desc[]"  placeholder="설명" />
                                        <button class="pm-button" onclick="handleOnClickPlus(this)" type="button">+</button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <input type="checkbox" name="use_evaluation" checked/> 평가방법
                                <div id="evaluations">
                                    <div class="class-container">
                                        <input type="text" name="eval_factor[]" placeholder="항목" />
                                        <input type="text" name="eval_ratio[]" placeholder="비율(%)"  />
                                        <button class="pm-button" onclick="handleOnClickPlus(this)" type="button">+</button>
                                    </div>
                                </div>
                            </div>

                            <div class="button-group">
                                <button class="button-group-child" type="button" onclick="location.href='/home'">취소</button>
                                <button class="button-group-child" type="submit">등록</button>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const verifyFormValues = () => {
            const nameElmt = document.querySelector('input[name=name]');
            const lectureCodeElmt = document.querySelector('input[name=lecture_code]');
            const descriptionElmt = document.querySelector('textarea[name=description]');
            const lectureGoalDescElmt = document.querySelector('textarea[name=lecture_goal_desc]');
            const lectureStartDateElmt = document.querySelector('input[name=lecture_start_date]');
            const lectureEndDateElmt = document.querySelector('input[name=lecture_end_date]');
            const classTitleElmtList = document.getElementsByName('class_title[]');
            const classDescElmtList = document.getElementsByName('class_desc[]');
            const evalFactorElmtList = document.getElementsByName('eval_factor[]');
            const evalRatioElmtList = document.getElementsByName('eval_ratio[]');

            const classTitleList = [];
            const classDescList = [];
            const evalFactorList = [];
            const evalRatioList = [];

            for (const classTitleElmt of classTitleElmtList) {
                classTitleList.push(classTitleElmt.value);
            }

            for (const classDescElmt of classDescElmtList) {
                classDescList.push(classDescElmt.value);
            }

            for (const evalFactorElmt of evalFactorElmtList) {
                evalFactorList.push(evalFactorElmt.value);
            }

            for (const evalRatioElmt of evalRatioElmtList) {
                 evalRatioList.push(evalRatioElmt.value);
            }

            const name = nameElmt.value.trim();
            const lectureCode = lectureCodeElmt.value.trim();
            const description = descriptionElmt.value;
            const lectureGoalDesc = lectureGoalDescElmt.value;
            const lectureStartDate = lectureStartDateElmt.value;
            const lectureEndDate = lectureEndDateElmt.value;

            try {
                if (name.trim().length === 0) {
                    alert('과목명을 입력해주세요.');
                    throw 'Validation Error';
                } else if (lectureCode.trim().length === 0) {
                    alert('비정상적인 접근입니다.');
                    throw 'Validation Error';
                } else if (description.trim().length === 0) {
                    alert('과목소개를 적어주세요.');
                    throw 'Validation Error';
                } else if (lectureGoalDesc.trim().length === 0) {
                    alert('학습목표를 적어주세요.');
                    throw 'Validation Error';
                } else if (lectureStartDate.length === 0 || lectureEndDate.length === 0) {
                    alert('수강기간을 설정 해주세요.');
                    throw 'Validation Error';
                } else if (Date.parse(lectureStartDate) > Date.parse(lectureEndDate)) {
                    alert('날짜가 잘 못 입력되었습니다.');
                    throw 'Validation Error';
                }

                for (const classTitle of classTitleList) {
                    if (classTitle.trim().length === 0) {
                        alert('주차 별 수업 안내를 입력해주세요.');
                        throw 'Validation Error';
                    }
                }

                for (const classDesc of classDescList) {
                    if (classDesc.trim().length === 0) {
                        alert('주차 별 수업 안내를 입력해주세요.');
                        throw 'Validation Error';
                    }
                }

                for (const evalFactor of evalFactorList) {
                    if (evalFactor.trim().length === 0) {
                        alert('평가방법을 입력해주세요.');
                        throw 'Validation Error';
                    }
                }

                for (const evalRatio of evalRatioList) {
                    if (evalRatio.trim().length === 0) {
                        alert('평가방법을 입력해주세요.');
                        throw 'Validation Error';
                    }
                }
            } catch (err) {
                return false;
            }

            return true;
        }

        const makeNewClassField = () => {
            const newDiv = document.createElement('div');
            const input1 = document.createElement('input');
            input1.type = 'text';
            input1.placeholder = '주차 별 타이틀';
            input1.name = 'class_title[]';
            const input2 = document.createElement('input');
            input2.type = 'text';
            input2.placeholder = '설명';
            input2.name = 'class_desc[]';
            const plusButton = document.createElement('button');
            plusButton.onclick = handleOnClickPlus;
            plusButton.innerHTML = '+';
            plusButton.style.width = '29px';
            plusButton.style.height = '29px';
            plusButton.type = 'button';
            const minusButton = document.createElement('button');
            minusButton.onclick = handleOnClickMinus;
            minusButton.name = 'minus';
            minusButton.innerHTML = '-';
            minusButton.style.width = '29px';
            minusButton.style.height = '29px';
            minusButton.type = 'button';

            newDiv.appendChild(input1);
            newDiv.appendChild(input2);
            newDiv.appendChild(plusButton);
            newDiv.appendChild(minusButton);

            return newDiv;
        }

        const makeNewEvaluationField = () => {
            const newDiv = document.createElement('div');
            const input1 = document.createElement('input');
            input1.type = 'text';
            input1.placeholder = '항목';
            input1.name = 'eval_factor[]';
            const input2 = document.createElement('input');
            input2.type = 'text';
            input2.placeholder = '비율(%)';
            input2.name = 'eval_ratio[]';
            const plusButton = document.createElement('button');
            plusButton.onclick = handleOnClickPlus;
            plusButton.innerHTML = '+';
            plusButton.style.width = '29px';
            plusButton.style.height = '29px';
            plusButton.type = 'button';
            const minusButton = document.createElement('button');
            minusButton.onclick = handleOnClickMinus;
            minusButton.name = 'minus';
            minusButton.innerHTML = '-';
            minusButton.style.width = '29px';
            minusButton.style.height = '29px';
            minusButton.type = 'button';

            newDiv.appendChild(input1);
            newDiv.appendChild(input2);
            newDiv.appendChild(plusButton);
            newDiv.appendChild(minusButton);

            return newDiv;
        }

        const handleOnClickPlus = (e) => {
            if (e) {
                let parent = null;

                if (e.type == 'click') {
                    parent = e.target.parentNode.parentNode;
                }
                else {
                    parent = e.parentNode.parentNode;
                }

                if (parent) {
                    let children = null;
                    if (parent.id === 'classes') {
                        children = makeNewClassField();
                    }
                    else {
                        children = makeNewEvaluationField();
                    }

                    if (children) {
                        parent.appendChild(children);
                    }
                }
            }

            return false;
        }

        const handleOnClickMinus = (e) => {
            e.target.parentNode.remove();
        }

        window.addEventListener('load', () => {
            const submitForm = document.querySelector('#frmCreate');
            submitForm.addEventListener('submit', (e) => {
                e.preventDefault();

                if (verifyFormValues()) {
                    submitForm.submit();
                }
            });
        });
    </script>
@endsection
