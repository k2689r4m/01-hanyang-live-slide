@extends('backup.layouts.app')

@section('content')
    <div class='slide-container'>
        <div class='slide-pagination'>
            <div class='slides'>
            </div>
            <button type='button' class='btn btn-primary new-slide-btn'>+ 새 슬라이드</button>
        </div>
        <div class='slide-content'>
            <div class='renderer'></div>
            <div class='handle-bar'>
                <i class="fas fa-arrow-left open-studio"></i>
                <i class="fas fa-arrow-right fold-studio"></i>
            </div>
        </div>
        <div class='slide-studio empty'>
            <h2>슬라이드를 선택해주세요</h2>
        </div>
        <div class='slide-studio tools'>
            <div class='section-header type-section-title'>타입</div>
            <div class='section-types'>
                <div class='types'>
                    <h3>Quiz</h3>
                    <div class='list'>
                        <div class='type-card' data-contents-type='multiple_choice'>객관식</div>
                        <div class='type-card' data-contents-type='short_answer'>주관식</div>
                    </div>
                </div>
                <div class='types'>
                    <h3>Content Slide</h3>
                    <div class='list'>
                        <div class='type-card' data-contents-type='text'>텍스트</div>
                        <div class='type-card' data-contents-type='image'>이미지</div>
                        <div class='type-card' data-contents-type='text_image'>텍스트 + 이미지</div>
                    </div>
                </div>
            </div>
            <div class='section-header contents-section-title'>내용</div>
            <div class='section-contents multiple_choice'>
                <div class='img-modal'>
                    <button type='button' class='btn btn-danger del-img'>삭제</button>
                    <button type='button' class='btn btn-primary edit-img'>수정</button>
                </div>
                <div class='part top-btns'>
                    <button type='button' class='btn btn-primary save-slide-data-btn'>슬라이드 반영</button>
                </div>
                <div class='part'>
                    <span>질문</span>
                    <div class='part-content'>
                        <input type='text' class='input-box question' />
                    </div>
                </div>
                <div class='part'>
                    <span>보기</span>
                    <div class='part-content'>
                        <div class='view-table'>
                            <!-- 밑 view-row는 예시입니다. 스크립트에 의해 삭제됩니다. -->
                            <div class='view-row'>
                                <div class='view-column move-draggable'>
                                    이동
                                </div>
                                <div class='view-column view-text'>
                                    <input type='text' class='answer' />
                                </div>
                                <div class='view-column img'>
                                    <img src='https://search.pstatic.net/sunny/?src=https%3A%2F%2Fwallpapershome.com%2Fimages%2Fpages%2Fpic_h%2F322.jpg&type=b400' />
                                </div>
                                <div class='view-column del-btn'>
                                    <i class='fas fa-times'></i>
                                </div>
                                <div class='view-column check-box'>
                                    <input type='checkbox' class='is-right-answer' />
                                </div>
                            </div>
                        </div>
                        <div class='view-table-btns'>
                            <button type='button' class='btn btn-success'>+ 보기 추가</button>
                        </div>
                    </div>
                </div>
                <div class='part'>
                    <span>대답 제한시간</span>
                    <div class='part-content'>
                        <input type='number' class='timeout' value='15' /> 초
                    </div>
                </div>
                <div class='part'>
                    <span>점수</span>
                    <div class='part-content'>
                        <input type='number' class='score' value='0' /> 포인트
                    </div>
                </div>
                <div class='part'>
                    <span>결과 레이아웃</span>
                    <div class='part-content result-layout-list'>
                        <div class='result-layout' data-layout-type='line_graph' >막대그래프</div>
                        <div class='result-layout' data-layout-type='donut_chart'>도넛</div>
                        <div class='result-layout' data-layout-type='pie_chart'>파이차트</div>
                    </div>
                </div>
            </div>
            <div class='section-contents short_answer'>
                <div class='part top-btns'>
                    <button type='button' class='btn btn-primary save-slide-data-btn'>슬라이드 반영</button>
                </div>
                <div class='part'>
                    <span>질문</span>
                    <div class='part-content'>
                        <input type='text' class='input-box question' />
                    </div>
                </div>
                <div class='part'>
                    <span>정답</span>
                    <div class='part-content'>
                        <input type='text' class='input-box answer' />
                    </div>
                </div>
                <div class='part'>
                    <span>대답 제한시간</span>
                    <div class='part-content'>
                        <input type='number' class='timeout' value='15' /> 초
                    </div>
                </div>
                <div class='part'>
                    <div class='part top-btns'>
                        <button type='button' class='btn btn-primary save-slide-data-btn'>슬라이드 반영</button>
                    </div>
                    <span>결과 레이아웃</span>
                    <div class='part-content result-layout-list'>
                        <div class='result-layout' data-layout-type='line_graph' >막대그래프</div>
                        <div class='result-layout' data-layout-type='donut_chart'>도넛</div>
                        <div class='result-layout' data-layout-type='pie_chart'>파이차트</div>
                        <div class='result-layout' data-layout-type='word_cloud'>워드클라우드</div>
                    </div>
                </div>
            </div>
            <div class='section-contents text'>
                <div class='part top-btns'>
                    <button type='button' class='btn btn-primary save-slide-data-btn'>슬라이드 반영</button>
                </div>
                <div class='part'>
                    <span>제목</span>
                    <div class='part-content'>
                        <input type='text' class='input-box title' />
                    </div>
                </div>
                <div class='part'>
                    <span>내용</span>
                    <div class='part-content'>
                        <input type='text' class='input-box text' />
                    </div>
                </div>
            </div>
            <div class='section-contents image'>
                <div class='part top-btns'>
                    <button type='button' class='btn btn-primary save-slide-data-btn'>슬라이드 반영</button>
                </div>
                <div class='part'>
                    <span>이미지</span>
                    <div class='part-content'>
                        <input type='file' accept='image/*' class='image-file' />
                    </div>
                </div>
            </div>
            <div class='section-contents text_image'>
                <div class='part top-btns'>
                    <button type='button' class='btn btn-primary save-slide-data-btn'>슬라이드 반영</button>
                </div>
                <div class='part'>
                    <span>이미지</span>
                    <div class='part-content'>
                        <input type='file' accept='image/*' class='image-file' />
                    </div>
                </div>
                <div class='part'>
                    <span>내용</span>
                    <div class='part-content'>
                        <input type='text' class='input-box text' />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <style>
    /* 너비와 높이를 100% 모두 사용하기 위해 사용함. */
    html, body, #app, main {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: auto;
    }
    /* main태그의 패딩 값을 강제로 없애기 위해 사용함. */
    .py-4 {
        padding: 0 !important;
    }
    </style>
    <script>


        window.onload = () =>{
            const slides = document.querySelector('.slides');
            const slideContent = document.querySelector('.slide-content');
            const renderer = document.querySelector('.slide-content .renderer');
            const typeSectionHeader = document.querySelector('.type-section-title');
            const typeSectionContent = document.querySelector('.section-types');
            const contentsSectionHeader = document.querySelector('.contents-section-title');
            const contentsSection = document.querySelector('.section-contents');
            const openStudioBtn = document.querySelector('.open-studio');
            const foldStudioBtn = document.querySelector('.fold-studio');
            const studio = document.querySelector('.slide-studio');
            const multipleChoiceStudio = document.querySelector('.slide-studio .multiple_choice');
            const newSlideBtn = document.querySelector('.new-slide-btn');
            const typeCards = document.getElementsByClassName('type-card');
            const resultLayouts = document.getElementsByClassName('result-layout');
            const slideStudioEmpty = document.querySelector('.slide-studio.empty');
            const slideStudioTools = document.querySelector('.slide-studio.tools');
            const saveDataBtns = document.getElementsByClassName('save-slide-data-btn');
            const appendAnswerBtn = document.querySelector('.slide-studio .multiple_choice .view-table-btns button');
            const multipleChoiceImgModal = document.querySelector('.slide-studio .multiple_choice .img-modal');
            let currentSlideIdx = -1; // -1은 선택된 슬라이드가 없을 때

            let _slideUniqueId = 0;
            let slidesData = [];

            function slideUniqueId() {
                return (_slideUniqueId++).toString();
            }

            // 갱신 원하는 데이터를 본 함수를 이용해 unique_id를 업데이트 시키면
            // 렌더링 함수에서 아이디가 변지됬음을 감지하고 다시 그릴 것 임.
            function updateUniqueId(uniqueId) {
                if (uniqueId.indexOf('_____') >= 0) {
                    return uniqueId.substring(4);
                }
                return `_${uniqueId}`;
            }

            function showMultipleChoiceImgModal() {
                const imgModal = document.querySelector('.slide-studio .multiple_choice .img-modal');

                imgModal.style.display = 'flex';
            }

            function hideMultipleChoiceImgModal() {
                const imgModal = multipleChoiceStudio.querySelector('.img-modal');

                if (imgModal.style.display !== 'none') {
                    imgModal.style.display = 'none';
                }
            }

            function createSlide(slideData) {
                const slideDiv = document.createElement('div');
                slideDiv.className = 'slide';
                slideDiv.innerText = slideData.type;
                slideDiv.setAttribute('unique-id', slideData.id);

                // 슬라이드 선택 이벤트
                slideDiv.addEventListener('click', () => {
                    const _slides = document.getElementsByClassName('slide');
                    let thisSlideIdx = -1;

                    for (let i = 0; i < _slides.length; i++) {
                        if (_slides[i].getAttribute('unique-id') === slideDiv.getAttribute('unique-id') ) {
                            thisSlideIdx = i;
                            break;
                        }
                    }

                    if (thisSlideIdx === -1 || thisSlideIdx === currentSlideIdx) return;

                    if (currentSlideIdx !== -1 && _slides[currentSlideIdx]) {
                        _slides[currentSlideIdx].classList.remove('active');
                    }

                    clearContentsAllInput();
                    currentSlideIdx = thisSlideIdx;
                    slideDiv.classList.add('active');
                    updateStudio();
                    updateContent();
                });

                // 슬라이드 삭제버튼
                const deleteBtn = document.createElement('i');
                deleteBtn.className = 'fas fa-times delete-btn';
                deleteBtn.addEventListener('click', (e) => {
                    e.stopPropagation(); // 슬라이드 클릭 방지
                    const _slides = document.getElementsByClassName('slide');
                    let thisSlideIdx = -1;

                    for (let i = 0; i < _slides.length; i++) {
                        if (_slides[i].getAttribute('unique-id') === slideDiv.getAttribute('unique-id') ) {
                            thisSlideIdx = i;
                            break;
                        }
                    }

                    // 선택된 슬라이드가 삭제되면 currentSlideIdx 값을 초기화합니다.
                    if (currentSlideIdx === thisSlideIdx) {
                        currentSlideIdx = -1;
                        updateStudio();
                        updateContent();
                    }
                    // 삭제될 슬라이드가 선택된 슬라이드보다 위에 있으면 idx를 하나 감소시켜 위로 미룹니다.
                    if (currentSlideIdx > thisSlideIdx) {
                        currentSlideIdx--;
                        updateSlides();
                    }

                    slideDiv.remove();
                    slidesData = slidesData.filter((data) => data.id !== slideData.id);
                    updateSlides();
                });

                slideDiv.appendChild(deleteBtn);

                return slideDiv;
            }

            // 빈 Answer data를 반환합니다.
            function createAnswerData() {
                return {
                        answer: '',
                        isRightAnswer: false,
                        imgUrl: '',
                        file: null
                };
            }

            // answerData를 건네지 않으면 아무 데이터도 갖지않는 rowdiv를 만듭니다.
            function createViewRow(answerData) {
                const rowDiv = document.createElement('div');
                rowDiv.className = 'view-row';

                const moveColumn = document.createElement('div');
                moveColumn.className = 'view-column move-draggable';
                moveColumn.innerText = '이동';

                let clone = null;
                let moveable = false;

                moveColumn.addEventListener('mousedown', (e) => {
                    clone = rowDiv.cloneNode(true);
                    clone.classList.add('clone');
                    clone.style.width = `${rowDiv.getBoundingClientRect().width}px`;
                    clone.style.left = `${e.clientX}px`;
                    clone.style.top = `${e.clientY-20}px`; // 20은 자연스러운 위치를 위한 조정값입니다.
                    moveable = true;

                    rowDiv.style.border = '1px solid red';
                    rowDiv.parentNode.appendChild(clone);
                });

                window.addEventListener('mousemove', (e) => {
                    if (!moveable || !clone) return;
                    clone.style.top = `${e.clientY-20}px`; // 20은 자연스러운 위치를 위한 조정값입니다.
                    const { clientX: mouseX, clientY: mouseY } = e;
                    const rows = multipleChoiceStudio.getElementsByClassName('view-row');
                    let selectedRowIdx = -1;
                    let moveTargetRowIdx = -1;

                    for (let i = 0; i < rows.length; i++) {
                        if (rows[i].classList.contains('clone')) continue; // 복제 리뷰 제외
                        const rowRect = rows[i].getBoundingClientRect();

                        if (
                            (mouseY >= rowRect.top && mouseY <= (rowRect.top + rowRect.height))
                        ) {
                            selectedRowIdx = i;
                        }
                        if (rows[i] === rowDiv) {
                            moveTargetRowIdx = i;
                        }
                    }

                    // 움직임 타겟 대상이 아닐 때
                    if (selectedRowIdx !== -1 && rows[selectedRowIdx] !== rowDiv) {
                        // 밑으로 내릴땐 타겟의 다음으로 위로 올릴땐 타겟의 이전으로 이동시킨다.
                        if (selectedRowIdx > moveTargetRowIdx) {
                            console.log('seletecRowIdx', selectedRowIdx);
                            rows[selectedRowIdx].parentNode.insertBefore(rowDiv, rows[selectedRowIdx+1]);
                        } else {
                            rows[selectedRowIdx].parentNode.insertBefore(rowDiv, rows[selectedRowIdx]);
                        }
                    }

                    const rowToInsert = rowDiv
                });

                window.addEventListener('mouseup', (e) => {
                    if (!moveable || !clone) return;
                    moveable = false;
                    clone.remove();
                    clone = null;
                    rowDiv.style.border = '';
                });

                const textColumn = document.createElement('div');
                textColumn.className = 'view-column view-text';
                const answerInputBox = document.createElement('input');
                answerInputBox.className='answer';
                answerInputBox.type = 'text';
                textColumn.appendChild(answerInputBox);

                const imgColumn = document.createElement('div');
                imgColumn.className = 'view-column img';
                const img = document.createElement('img');
                imgColumn.appendChild(img);
                img.src = '';
                img.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const imgModal = document.querySelector('.slide-studio .multiple_choice .img-modal');
                    const imgColumnRect = imgColumn.getBoundingClientRect();
                    const imgModalParentRect = imgModal.parentNode.getBoundingClientRect();
                    const imgModalRect = imgModal.getBoundingClientRect();

                    const top = imgColumnRect.top - imgModalParentRect.top;
                    const left = imgColumnRect.left - imgModalParentRect.left - imgModalRect.width;

                    showMultipleChoiceImgModal();

                    imgModal.style.left = `${left}px`;
                    imgModal.style.top = `${top}px`;
                    // 모달의 Attribute를 이용해몇 번째 row가 선택했는지 찾아 전달합니다.
                    const viewRows = document.getElementsByClassName('view-row');
                    let selectedRowIdx = -1;

                    for (let i =0 ; i < viewRows.length; i++) {
                        if (viewRows[i] === rowDiv) {
                            selectedRowIdx = i;
                            break;
                        }
                    }

                    imgModal.setAttribute('selected-row-idx', selectedRowIdx);
                });

                const inputFile = document.createElement('input');
                inputFile.type = 'file';
                inputFile.accept = 'image/*';
                inputFile.style.display = 'none';
                inputFile.addEventListener('change', (e) => {
                    if (e.target.files.length === 0) {
                        alert('파일을 선택해주세요.');
                        return;
                    }

                    const file = e.target.files[0];

                    // FileReader support
                    if (FileReader && file) {
                        var fr = new FileReader();
                        fr.onload = function () {
                            img.src = fr.result;
                        }
                        fr.readAsDataURL(file);
                    } else {
                        alert('파일 업로드 기능을 지원하지 않는 브라우저 입니다. 다른 브라우저로 접속해주세요.');
                    }
                });

                const delBtnColumn = document.createElement('div');
                delBtnColumn.className = 'view-column del-btn';
                const delBtn = document.createElement('i');
                delBtn.className='fas fa-times';
                // 행삭제 버튼
                delBtnColumn.addEventListener('click', () => {
                    if (document.getElementsByClassName('view-row').length <= 2) {
                        alert('보기는 최소 2개 이상입니다.');
                        return;
                    }
                    rowDiv.remove();
                });
                delBtnColumn.appendChild(delBtn);

                const checkboxColumn = document.createElement('div');
                checkboxColumn.className = 'view-column check-box';
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'is-right-answer';
                checkboxColumn.appendChild(checkbox);

                if (answerData) {
                    answerInputBox.value = answerData.answer;
                    img.src = answerData.imgUrl;
                    checkbox.checked = answerData.isRightAnswer;
                }

                rowDiv.appendChild(moveColumn);
                rowDiv.appendChild(textColumn);
                rowDiv.appendChild(imgColumn);
                rowDiv.appendChild(inputFile);
                rowDiv.appendChild(delBtnColumn);
                rowDiv.appendChild(checkboxColumn);

                return rowDiv;
            }


            /**
                type = 'multiple_choice', 'short_answer', 'text', 'image', 'text_image'
                위의 타입이 아니거나 오류나면 null 반환.
            */
            function createEmptySlideData(type) {
                let dft = {
                    id: slideUniqueId(),
                };
                switch(type) {
                    case 'multiple_choice':
                    return {
                        ...dft,
                        type,
                        question: '',
                        answers: [
                            createAnswerData(),
                            createAnswerData()
                        ],
                        timeout: 0,
                        score: 0,
                        resultLayout: 'line_graph'
                    };
                    case 'short_answer':
                    return {
                        ...dft,
                        type,
                        question: '',
                        answer: '',
                        timeout: 0,
                        resultLayout: 'line_graph'
                    };
                    case 'text':
                    return {
                        ...dft,
                        type,
                        title: '',
                        text: ''
                    };
                    case 'image':
                    return {
                        ...dft,
                        type,
                        file: null
                    };
                    case 'text_image':
                    return {
                        ...dft,
                        imgUrl: '',
                        text: ''
                    }
                    default:
                    return null;
                }
            }

            function updateSlides() {
                const existSlides = document.getElementsByClassName('slide');
                if (existSlides.length <= slidesData.length) {
                    for (let i = 0; i < slidesData.length; i++) {
                        if (i < existSlides.length) {
                            if (existSlides[i].getAttribute('unique-id') !== slidesData[i].id) {
                                slidesData[i].id = updateUniqueId(slidesData[i].id);
                                const newSlide = createSlide(slidesData[i]);

                                if (i === currentSlideIdx) {
                                    newSlide.classList.add('active');
                                }
                                existSlides[i].parentNode.replaceChild(newSlide, existSlides[i]);
                            }
                        } else {
                            slides.appendChild(createSlide(slidesData[i]));
                        }
                    }
                } else {
                    for (let i = slidesData.length; i < existSlides.length; i++) {
                        existSlides[i].remove();
                    }
                }
            }

            // Validation 실패 또는 선택된 슬라이드 없을 시 false 반환.
            function saveContentToCurrentSlide() {
                if (currentSlideIdx === -1) return false;

                const selectedTypeElmt = document.querySelector(`.type-card.active`);
                if (!selectedTypeElmt) return false;

                const newData = {};
                const selectedType = selectedTypeElmt.getAttribute('data-contents-type');

                newData.type = selectedType;
                const slideStudio = document.querySelector(`.slide-studio .${newData.type}`);

                switch(selectedType)
                {
                    case 'multiple_choice':
                    newData.question = slideStudio.querySelector('.question').value;
                    newData.timeout = slideStudio.querySelector('.timeout').value;
                    newData.score = slideStudio.querySelector('.score').value;

                    const viewRows = slideStudio.getElementsByClassName('view-row');
                    newData.answers = [];

                    for (let i = 0; i < viewRows.length; i++) {
                        const newAnswer = {};
                        newAnswer.answer = viewRows[i].querySelector('.answer').value;
                        newAnswer.isRightAnswer = viewRows[i].querySelector('.is-right-answer').checked;
                        newAnswer.imgUrl = viewRows[i].querySelector('.img img').src;
                        const files =  viewRows[i].querySelector('input[type=file]').files;
                        if (newAnswer.imgUrl === '') return false; // 이미지 업로드 하지 않았을 시
                        // 이미지를 수정 하지 않았다면 files는 없을 것임.
                        // request처리할 때 수정하지 않은 이미지에 대해서는
                        // 기본 값을 그대로 사용해야함.
                        if ( files.length !== 0) newAnswer.file = files[0];
                        newData.answers.push(newAnswer);
                    }
                    const _mselectedLayout = slideStudio.querySelector('.result-layout.active');
                    if (!_mselectedLayout) return false;
                    newData.resultLayout = _mselectedLayout.getAttribute('data-layout-type');
                    break;
                    case 'short_answer':
                    newData.question = slideStudio.querySelector('.question').value;
                    newData.answer = slideStudio.querySelector('.answer').value;
                    newData.timeout = slideStudio.querySelector('.timeout').value;
                    const _sselectedLayout = slideStudio.querySelector('.result-layout.active');
                    if (!_sselectedLayout) return false;
                    newData.resultLayout = _sselectedLayout.getAttribute('data-layout-type');
                    break;
                    case 'text':
                    newData.title = slideStudio.querySelector('.title').value;
                    newData.text = slideStudio.querySelector('.text').value;
                    break;
                    case 'image':
                    const imgFile = slideStudio.querySelector('.image-file');
                    if (imgFile.files.length === 0) return false;
                    newData.file = imgFile.files[0];
                    break;
                    case 'text_image':
                    const textImgFile = slideStudio.querySelector('.image-file');
                    if (textImgFile.files.length > 0) newData.file = textImgFile.files[0];
                    else if (!slidesData[currentSlideIdx].file) return false;
                    else newData.file = slidesData[currentSlideIdx].file;
                    newData.text = slideStudio.querySelector('.text').value;
                    break;
                    default:
                    return false;
                }



                newData.id = updateUniqueId(slidesData[currentSlideIdx].id);
                slidesData[currentSlideIdx] = newData;

                updateSlides();
                updateContent();
                return true;
            }

            function updateStudio() {
                if (currentSlideIdx === -1) {
                    slideStudioTools.style.display = 'none';
                    slideStudioEmpty.style.display = 'flex';
                    return;
                } else {
                    slideStudioTools.style.display = 'flex';
                    slideStudioEmpty.style.display = 'none';
                }

                const slideData = slidesData[currentSlideIdx];
                let typeCardIdx = -1;
                const sectionContentsList = slideStudioTools.getElementsByClassName('section-contents');
                const studioElmt = document.querySelector(`.slide-studio .${slideData.type}`);
                for (let j = 0; j < typeCards.length; j++) typeCards[j].classList.remove('active');
                for (let j = 0; j < resultLayouts.length; j++) resultLayouts[j].classList.remove('active');
                for (let j = 0; j < sectionContentsList.length; j++) sectionContentsList[j].style.display = 'none';
                studioElmt.style.display = 'block';

                switch(slideData.type) {
                    case 'multiple_choice':
                        typeCardIdx = 0;

                        studioElmt.querySelector(`.result-layout[data-layout-type=${slideData.resultLayout}]`).classList.add('active');
                        studioElmt.querySelector('.question').value = slideData.question;
                        studioElmt.querySelector('.timeout').value = slideData.timeout;
                        studioElmt.querySelector('.score').value = slideData.score;
                        const viewTable = studioElmt.querySelector('.view-table');
                        const oldRows = viewTable.getElementsByClassName('view-row');
                        const oldRowsLength = oldRows.length;

                        for (let i = 0; i < oldRowsLength; i++) {
                            oldRows[0].remove();
                        }

                        for (let i = 0; i < slideData.answers.length; i++) {
                            viewTable.appendChild(createViewRow(slideData.answers[i]));
                        }
                        break;
                    case 'short_answer':
                        typeCardIdx = 1;

                        studioElmt.querySelector(`.result-layout[data-layout-type=${slideData.resultLayout}]`).classList.add('active');
                        studioElmt.querySelector('.question').value = slideData.question;
                        studioElmt.querySelector('.answer').value = slideData.answer;
                        studioElmt.querySelector('.timeout').value = slideData.timeout;
                        break;
                    case 'text':
                        typeCardIdx = 2;

                        studioElmt.querySelector('.title').value = slideData.title;
                        studioElmt.querySelector('.text').value = slideData.text;
                        break;
                    case 'image':
                        typeCardIdx = 3;
                        break;
                    case 'text_image':
                        typeCardIdx = 4;
                        studioElmt.querySelector('.text').value = slideData.text;
                        break;
                    default:
                        currentSlideIdx = -1;
                        updateStudio();
                        return;
                }
                typeCards[typeCardIdx].classList.add('active');

            }

            function clearContentsAllInput() {
                const inputTags = document.querySelector('.slide-studio.tools').getElementsByTagName('input');

                for (let i = 0; i < inputTags.length; i++) {
                    inputTags[i].value = '';
                }

                const imgs = document.querySelector('.slide-studio.tools').getElementsByTagName('img');
                for (let i = 0; i < imgs.length; i++) {
                    imgs[i].value = '';
                }
            }

            function updateContent() {
                if (currentSlideIdx === -1) return;

                renderer.innerHTML = JSON.stringify(slidesData[currentSlideIdx]);
            }

            // 모든 레이아웃 비활성화 후 선택된 레이아웃 활성화
            for (let i = 0; i < resultLayouts.length; i++) {
                resultLayouts[i].addEventListener('click', () => {
                    if (resultLayouts[i].classList.contains('active')) return;

                    for (let j = 0; j < resultLayouts.length; j++) resultLayouts[j].classList.remove('active');
                    resultLayouts[i].classList.add('active');
                });
            }

            // 모든 타입카드 비활성화 후 선택된 카드 활성화
            for (let i = 0; i < typeCards.length; i++) {
                typeCards[i].addEventListener('click', () => {
                    if (typeCards[i].classList.contains('active')) return;

                    for (let j = 0; j < typeCards.length; j++) typeCards[j].classList.remove('active');
                    typeCards[i].classList.add('active');
                    const sectionContentsList = slideStudioTools.getElementsByClassName('section-contents');
                    for (let j = 0; j < sectionContentsList.length; j++) sectionContentsList[j].style.display = 'none';
                    const studioElmt = document.querySelector(`.section-contents.${typeCards[i].getAttribute('data-contents-type')}`);
                    studioElmt.style.display = 'block';
                });
            }

            for (let i = 0; i < saveDataBtns.length; i++) {
                saveDataBtns[i].addEventListener('click', () => {
                    if (!saveContentToCurrentSlide()) {
                        alert('입력값을 다시 확인해주세요.');
                    }
                });
            }

            appendAnswerBtn.addEventListener('click', () => {
                const newViewRow = createViewRow();
                multipleChoiceStudio.querySelector('.view-table').appendChild(newViewRow);
            });

            newSlideBtn.addEventListener('click', () => {
                slidesData.push(createEmptySlideData('multiple_choice'));
                updateSlides();
            });

            multipleChoiceStudio.addEventListener('click', () => {
                hideMultipleChoiceImgModal();
            });

            openStudioBtn.addEventListener('click', () => {
                if (slideStudioEmpty.classList.contains('folded')) {
                    slideStudioEmpty.classList.remove('folded');
                }
                if (slideStudioTools.classList.contains('folded')) {
                    slideStudioTools.classList.remove('folded');
                }
            });

            foldStudioBtn.addEventListener('click', () => {
                if (!slideStudioEmpty.classList.contains('folded')) {
                    slideStudioEmpty.classList.add('folded');
                }
                if (!slideStudioTools.classList.contains('folded')) {
                    slideStudioTools.classList.add('folded');
                }
            });

            typeSectionHeader.addEventListener('click', () => {
                if (typeSectionContent.classList.contains('folded')) {
                    typeSectionContent.classList.remove('folded');
                } else {
                    typeSectionContent.classList.add('folded');
                }
            });

            contentsSectionHeader.addEventListener('click', () => {
                if (contentsSection.classList.contains('folded')) {
                    contentsSection.classList.remove('folded');
                } else {
                    contentsSection.classList.add('folded');
                }
            });

            multipleChoiceImgModal.querySelector('.del-img').addEventListener('click', (e) => {
                e.stopPropagation();
                const selectedRowIdx = Number(multipleChoiceImgModal.getAttribute('selected-row-idx'));
                const rows = multipleChoiceStudio.getElementsByClassName('view-row');
                rows[selectedRowIdx].querySelector('input[type=file]').value = '';
                rows[selectedRowIdx].querySelector('img').src = '';
                hideMultipleChoiceImgModal();
            });

            multipleChoiceImgModal.querySelector('.edit-img').addEventListener('click', (e) => {
                e.stopPropagation();
                const selectedRowIdx = Number(multipleChoiceImgModal.getAttribute('selected-row-idx'));
                const rows = multipleChoiceStudio.getElementsByClassName('view-row');
                rows[selectedRowIdx].querySelector('input[type=file]').click();
                hideMultipleChoiceImgModal();
            });
        };
    </script>
@endsection
