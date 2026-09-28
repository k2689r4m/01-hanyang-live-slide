@extends('layout.layout')

@section("title")
    과목 수정
@endsection

@section('content')
    <!-- myclass new -->
    <div class="dim dn"  id="lectureEditAlert">
        <div class="alert">
            <div class="alert__con"></div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary ok-btn">확인</button>
                </div>
            </div>
        </div>
    </div>
    <div class="dim dn"  id="lectureEditConfirm">
        <div class="alert">
            <div class="alert__con"></div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn gray cancel-btn" id="cancel">취소</button>
                </div>
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary ok-btn">확인</button>
                </div>
            </div>
        </div>
    </div>
    <dic class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home"></li>
            <li class="page-nav__item">내 강의실</li>
            <li class="page-nav__item">과목 수정하기</li>
        </ul>
    </dic>
    <div class="content__wrap exist-nav">
        <div class="content">
            <h2 class="content__tit">과목 수정하기</h2>
            <!-- input box -->
            <div class="input-box subject">
                <form method="post" action="{{ route('lecture.edit', ['id' => $lecture['id']] ) }}" id="frmLectureEdit">
                    @csrf
                    <div class="input-box__input col col-8">
                        <label class="input-box__label required">과목명 </label>
                        <input type="text" placeholder="과목명을 입력해주세요." name="name" value="{{ !old("name") && !$errors->has('name') ? $lecture['name'] : old("name") }}" maxlength="50" />
                        <span class="input-box__count num-of-name-letters">0/50</span>
                    </div>
                    <div class="input-box__input col col-4">
                        <label class="input-box__label">입장 코드 </label>
                        <input class="a-center lecture-code" type="text" value="{{ $lecture_code ?? $lecture['lecture_code'] }}" name="lecture_code" readonly />
                        <button type="button" class="btn-normal btn-primary btn-line mr-0 refresh-code-btn">새로고침</button>
                    </div>
                    <div class="input-box__input">
                        <label class="input-box__label required">과목 소개 </label>
                        <textarea name="description" rows="6" placeholder="과목 소개를 입력해주세요." maxlength="200">{{ !old("description") && !$errors->has('description') ? $lecture['description'] : old('description') }}</textarea>
                        <span class="input-box__count num-of-desc-letters">0/200</span>
                    </div>
                    <div class="input-box__input">
                        <label class="input-box__label required">학습 목표 </label>
                        <textarea name="lecture_goal_desc" rows="6" placeholder="학습 목표를 입력해주세요." maxlength="200">{{ !old("lecture_goal_desc") && !$errors->has('lecture_goal_desc') ? $lecture['lecture_goal_desc'] : old("lecture_goal_desc") }}</textarea>
                        <span class="input-box__count num-of-goaldesc-letters">0/200</span>
                    </div>
                    <div class="input-box__input">
                        <label class="input-box__label required">수강기간 </label>
                        <label class="datepicker__label">
                            <input type="text" class="datepicker" placeholder="선택" readonly name="lecture_start_date" value="{{!old("lecture_start_date") && !$errors->has('lecture_start_date') ? $lecture['lecture_start_date'] : old("lecture_start_date")}}" />
                        &nbsp;&nbsp;~&nbsp;&nbsp;
                        <label class="datepicker__label">
                            <input type="text" class="datepicker" placeholder="선택" readonly name="lecture_end_date" value="{{ !old("lecture_end_date") && !$errors->has('lecture_end_date') ? $lecture['lecture_end_date'] : old("lecture_end_date")}}" />
                        </label>
                    </div>
                    <div class="input-box__input pt-10">
                        <label class="input-box__label">추가 설정(선택) </label>
                        <br>
                        <label class="checkbox">
                            <input type="checkbox" name="use_nickname" value="1" @if ($lecture['use_nickname'] || old('use_nickname')) checked @endif" />닉네임 사용
                        </label>
                        <br><br><br>
                        <label class="checkbox">
                            <input type="checkbox" name="use_classes" value="1" @if ($lecture['use_classes'] || old('use_classes')) checked @endif" />주차별 수업안내
                        </label>
                        <ul class="week-list">
                            <li class="week-list__item dn">
                                <input class="week" type="text" placeholder="1주차" />
                                <input class="explanation" type="text" placeholder="주차별 수업 설명을 입력해주세요."  />
                                <button type="button" class="btn-delete"></button>
                            </li>
                            <li class="week-list__item">
                                <input class="week" type="text" name="class_title[]" placeholder="1주차" />
                                <input class="explanation" type="text" name="class_desc[]" placeholder="주차별 수업 설명을 입력해주세요."  />
                                <button type="button" class="btn-plus"></button>
                            </li>
                        </ul>
                        <label class="checkbox">
                            <input type="checkbox" name="use_evaluation" value="1" @if (old('use_evaluation') || $lecture['use_evaluation']) checked @endif" />평가방법
                        </label>
                        <ul class="method-list">
                            <li class="method-list__item dn">
                                <input class="item" type="text" placeholder="항목" />
                                <input class="percent" type="text" placeholder="0" maxlength="2" />
                                <span class="method-list__percent">%</span>
                                <button type="button" class="btn-delete"></button>
                            </li>
                            <li class="method-list__item">
                                <input class="item" type="text" name="eval_factor[]" placeholder="항목" />
                                <input class="percent" type="text" name="eval_ratio[]" placeholder="0" maxlength="2" />
                                <span class="method-list__percent">%</span>
                                <button type="button" class="btn-plus"></button>
                            </li>
                        </ul>
                    </div>
                    <div class="a-center">
                        <button type="reset" class="btn-gray btn-line btn-round btn-normal col2" id="cancelLectureEdit">취소</button>
                        <button type="submit" class="btn-primary btn-round btn-normal col2">수정</button>
                    </div>
                </form>
            </div>
            <!-- //input box -->
        </div>
    </div>
@endsection
@section('script')
    $( function() {
    $( ".datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
    } );
@endsection
@section('lecture.edit.script')
    // https://stackoverflow.com/questions/469357/html-text-input-allow-only-numeric-input
    // Restricts input for the given textbox to the given inputFilter function.
    function setInputFilter(textbox, inputFilter) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        });
    }

    @if (Session::has('success'))
        showAlert('수정되었습니다.', () => {
        location.href="{{ route('lecture.mainView') }}";
        });
    @elseif ($errors->has('lecture_start_date') || $errors->has('lecture_end_date'))
        showAlert('수강기간 날짜를 확인해주세요.');
    @elseif ($errors && count($errors) > 0)
        showAlert('필수입력사항을 모두 입력해주세요.');
    @endif

    const DESC_MAX_LETTERS = 200;
    const NAME_MAX_LETTERS = 50;
    const nameElem = document.querySelector('input[name=name]');
    const descElem = document.querySelector('textarea[name=description]');
    const goalDescElem = document.querySelector('textarea[name=lecture_goal_desc]');
    const classPlusBtn = document.querySelector('.week-list .btn-plus');
    const classListItem = document.querySelector('.week-list__item.dn');
    const evalListItem = document.querySelector('.method-list__item.dn');
    const evalPlusBtn = document.querySelector('.method-list .btn-plus');
    const confirm = document.getElementById('lectureEditConfirm');
    const formElem = document.querySelector('#frmLectureEdit');
    const cancelEditLectureBtn = document.querySelector('#cancelLectureEdit');
    const refreshCodeBtn = document.querySelector('.refresh-code-btn');

    lectureEditConfirm.querySelector('.cancel-btn').addEventListener('click', () => {
        lectureEditConfirm.classList.add('dn');
    });

    function showAlert(content, okCallback) {
        const alert = document.getElementById('lectureEditAlert');
        alert.classList.remove('dn');
        alert.querySelector('.alert__con').innerHTML = content;

        // 기존에 등록된 모달 이벤트를 제거합니다.
        const handleOk = () => {
        if (okCallback) okCallback();
            alert.classList.add('dn');
        };
        alert.querySelector('.ok-btn').removeEventListener('click', this.okCallback);
        this.okCallback = handleOk;
        alert.querySelector('.ok-btn').addEventListener('click', handleOk);
    }

    function showConfirm(content, okCallback) {
        const confirm = document.getElementById('lectureEditConfirm');
        confirm.classList.remove('dn');
        confirm.querySelector('.alert__con').innerHTML = content;
        // 기존에 등록된 모달 이벤트를 제거합니다.
        const handleOk = () => {
            okCallback();
            confirm.classList.add('dn');
        };
        confirm.querySelector('.ok-btn').removeEventListener('click', this.okCallback);
        this.okCallback = handleOk;
        confirm.querySelector('.ok-btn').addEventListener('click', handleOk);
    }

    // 클래스 추가 버튼을 마지막 클래스로 이동합니다.
    function moveClassPlusBtnToLastClassItem() {
        const listItems = document.getElementsByClassName('week-list__item');
        listItems[listItems.length - 1].appendChild(classPlusBtn);
    }

    // 평가 항목 추가 버튼을 마지막 평가 아이템으로 이동합니다.
    function moveEvalPlusBtnToLastEvalItem() {
        const listItems = document.getElementsByClassName('method-list__item');
        listItems[listItems.length - 1].appendChild(evalPlusBtn);
    }

    // 클래스 아이템들의 placeholder를 바꾸어줍니다.
    function updateClassItemsPlaceholder() {
        const listItems = document.getElementsByClassName('week-list__item');

        // 첫 번째는 카피본으로 제외합니다.
        for (let i = 1; i < listItems.length; i++) {
            listItems[i].querySelector('.week').placeholder = `${i}주차`;
        }
    }

    // 숫자만 입력 가능한 인풋 박스로 바꿉니다.
    function makeEvalRatioInputToNumericInput() {
        const listItems = document.getElementsByClassName('method-list__item');

        // 첫 번째는 카피본으로 제외합니다.
        for (let i = 1; i < listItems.length; i++) {
            setInputFilter(listItems[i].querySelector('.percent'), function(value) {
                return /^\d*$/.test(value); // Allow only digits
            });
        }
    }

    function appendClassListItem() {
        const newClassListItem = classListItem.cloneNode(true);
        newClassListItem.classList.remove('dn');
        // 카피 본은 form으로 데이터가 전달 되면 안되므로 name 빼놓았음. 여기서 동적으로 추가.
        newClassListItem.querySelector('.week').name = 'class_title[]';
        newClassListItem.querySelector('.explanation').name = 'class_desc[]';
        newClassListItem.querySelector('.btn-delete').addEventListener('click', (e) => {
            e.target.parentNode.remove();
            moveClassPlusBtnToLastClassItem();
            updateClassItemsPlaceholder();
        });
        classListItem.parentNode.appendChild(newClassListItem);
        moveClassPlusBtnToLastClassItem();
        updateClassItemsPlaceholder();
        return newClassListItem;
    }

    function appendEvalListItem() {
        const newEvalListItem = evalListItem.cloneNode(true);
        newEvalListItem.classList.remove('dn');
        // 카피 본은 form으로 데이터가 전달 되면 안되므로 name 빼놓았음. 여기서 동적으로 추가.
        newEvalListItem.querySelector('.item').name = 'eval_factor[]';
        newEvalListItem.querySelector('.percent').name = 'eval_ratio[]';
        newEvalListItem.querySelector('.btn-delete').addEventListener('click', (e) => {
            e.target.parentNode.remove();
            moveEvalPlusBtnToLastEvalItem();
        });
        makeEvalRatioInputToNumericInput(); // 숫자만 입력되게 만듭니다.
        evalListItem.parentNode.appendChild(newEvalListItem);
        moveEvalPlusBtnToLastEvalItem();
        return newEvalListItem;
    }

    function setClassListItemContent(classListItemElem, classTitle, classDesc) {
        classListItemElem.querySelector('.week').value = classTitle;
        classListItemElem.querySelector('.explanation').value = classDesc;
    }

    function setEvalListItemContent(evalListItemElem, evalFactor, evalRatio) {
        evalListItemElem.querySelector('.item').value = evalFactor;
        evalListItemElem.querySelector('.percent').value = evalRatio;
    }

    formElem.addEventListener('submit', (e) => {
    e.preventDefault();
    @if (!Session::has('success'))
        showConfirm('수정하시겠습니까?', () => {
        formElem.submit();
        });
    @endif
    });

    cancelEditLectureBtn.addEventListener('click', () => {
    @if (!Session::has('success'))
        showConfirm('해당 페이지에서 나가시겠습니까?<br />작성중인 내용은 삭제됩니다.', () => {
        location.href = '{{ route('lecture.mainView') }}';
        });
    @endif
    });

    descElem.addEventListener('keydown', (e) => {
        const desc = e.target.value;
        document.querySelector('.num-of-desc-letters').innerText = `${desc.length}/${DESC_MAX_LETTERS}`;
    });

    goalDescElem.addEventListener('keydown', (e) => {
        const desc = e.target.value;
        document.querySelector('.num-of-goaldesc-letters').innerText = `${desc.length}/${DESC_MAX_LETTERS}`;
    });

    nameElem.addEventListener('keydown', (e) => {
        const name = e.target.value;
        document.querySelector('.num-of-name-letters').innerText = `${name.length}/${NAME_MAX_LETTERS}`;
    });

    classPlusBtn.addEventListener('click', () => {
        appendClassListItem();
    });

    evalPlusBtn.addEventListener('click', () => {
        appendEvalListItem();
    });

    refreshCodeBtn.addEventListener('click', () => {
        fetch('{{route('lecture.createLectureCode')}}')
            .then((res) => res.text())
            .then((code) => {
                document.querySelector('.lecture-code').value = code;
            });
    });

    // 클래스, 평가요소 엘리먼트 동적생성
    @if(old('class_title'))
        @for ($i = 0; $i < count(old('class_title')); $i++)
            @if($i == 0)
                setClassListItemContent(document.querySelector('.week-list__item:nth-child(2)'), '{{old('class_title')[$i]}}', '{{old('class_desc')[$i]}}');
            @else
                setClassListItemContent(appendClassListItem(), '{{old('class_title')[$i]}}', '{{old('class_desc')[$i]}}');
            @endif
        @endfor
    @else
        @for ($i = 0; $i < count($lecture['classes']); $i++)
            @if($i == 0)
                setClassListItemContent(document.querySelector('.week-list__item:nth-child(2)'), '{{$lecture['classes'][$i]->title}}', '{{$lecture->classes[$i]->desc}}');
            @else
                setClassListItemContent(appendClassListItem(), '{{$lecture['classes'][$i]->title}}', '{{$lecture['classes'][$i]->desc}}');
            @endif
        @endfor
    @endif

    @if(old('eval_factor'))
        @for ($i = 0; $i < count(old('eval_factor')); $i++)
            @if($i == 0)
                setEvalListItemContent(document.querySelector('.method-list__item:nth-child(2)'), '{{old('eval_factor')[$i]}}', '{{old('eval_ratio')[$i]}}');
            @else
                setEvalListItemContent(appendEvalListItem(), '{{old('eval_factor')[$i]}}', '{{old('eval_ratio')[$i]}}');
            @endif
        @endfor
    @else
        @for ($i = 0; $i < count($lecture['evaluation']); $i++)
            @if($i == 0)
                setEvalListItemContent(document.querySelector('.method-list__item:nth-child(2)'), '{{$lecture['evaluation'][$i]->factor}}', '{{$lecture['evaluation'][$i]->ratio}}');
            @else
                setEvalListItemContent(appendEvalListItem(), '{{$lecture['evaluation'][$i]->factor}}', '{{$lecture['evaluation'][$i]->ratio}}');
            @endif
        @endfor
    @endif

    descElem.dispatchEvent(new KeyboardEvent('keydown'));
    goalDescElem.dispatchEvent(new KeyboardEvent('keydown'));
    nameElem.dispatchEvent(new KeyboardEvent('keydown'));
    makeEvalRatioInputToNumericInput();

@endsection
