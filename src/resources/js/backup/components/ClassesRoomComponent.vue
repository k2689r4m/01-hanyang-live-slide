<template>
    <div class="h-100 w-100">
        <div v-bind:class="{'slide-container': !pptLoading, 'slide-container-loading': pptLoading}">
            <div class="back-btn" title="작업 완료">
                <i class="fas fa-arrow-alt-circle-down"></i>
            </div>

            <div class="ppt-btn" title="PPT 업로드">
                <i class="far fa-file-powerpoint">
                    <input type="file" @change="upPPT" />
                </i>
            </div>

            <div class='slide-pagination'>
                <div class='slides'>

                </div>
                <button type='button' class='btn btn-primary new-slide-btn'>+ 새 슬라이드</button>
            </div>
            <div class='slide-content'>
                <div class='renderer h-100'>
                    <classes_view  :isSlide="this.isSlide"></classes_view>
                </div>
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
                            <div class='view-table'></div>
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

        <div v-if="pptLoading">
            로딩중 페이지
        </div>
    </div>



</template>

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
export default {
    props:['user', 'roomId'],
    data() {
        return {
            users:[],
            slides: [],
            sIndex: 0,
            testt: 0,
            oneSlide: [],
            fetchSlideCallback: () => {},
            getSlideIdxCallback: () => 0,
            uploadPPTImagesCallback: () => undefined,
            isSlide: [],
            pptLoading: false,
        }
    },
    created() {
        /** Javascrript */
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
            const imageStudio = document.querySelector('.slide-studio .image');
            const textImageStudio = document.querySelector('.slide-studio .text_image');
            const newSlideBtn = document.querySelector('.new-slide-btn');
            const typeCards = document.getElementsByClassName('type-card');
            const resultLayouts = document.getElementsByClassName('result-layout');
            const slideStudioEmpty = document.querySelector('.slide-studio.empty');
            const slideStudioTools = document.querySelector('.slide-studio.tools');
            const saveDataBtns = document.getElementsByClassName('save-slide-data-btn');
            const appendAnswerBtn = document.querySelector('.slide-studio .multiple_choice .view-table-btns button');
            const multipleChoiceImgModal = document.querySelector('.slide-studio .multiple_choice .img-modal');
            const that = this;
            let currentSlideIdx = -1; // -1은 선택된 슬라이드가 없을 때
            let _slideUniqueId = 0;
            let slidesData = [];

            var upTimer = null;
            var downTimer = null;
            var scrollPosition = null;
            var scrollTimer = null;

            function slideUniqueId() {
                return uuid.v4() + (_slideUniqueId++).toString();
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
                slideDiv.classList.add('relative');
                slideDiv.innerText = slideData.type;
                slideDiv.setAttribute('unique-id', slideData.id);

                slideDiv.addEventListener('mousedown', (e) => {
                    if (!(e.target.classList.contains('down'))) {
                        e.target.classList.add('down');
                    }
                });

                slides.addEventListener('wheel', (e) => {
                    slides.scrollTo({top: slides.scrollTop + e.deltaY * 3, left: 0, behavior: 'smooth'});
                })

                const handleDrag = (e) => {
                    if (e.target.classList.contains('down')) {
                        scrollPosition = e.target.parentNode.scrollTop;
                        if (e.clientY < e.target.parentNode.offsetTop && e.clientX < e.target.parentNode.clientWidth) {
                            if (downTimer) {
                                clearInterval(downTimer);
                                downTimer = null;
                            }
                            if (!upTimer) {
                                upTimer = setInterval(() => {
                                    scrollPosition = scrollPosition - 100;
                                }, 100);
                            }
                        }
                        else if (e.clientY > e.target.parentNode.clientHeight && e.clientX < e.target.parentNode.clientWidth) {
                            if (upTimer) {
                                clearInterval(upTimer);
                                upTimer = null;
                            }
                            if (!downTimer) {
                                downTimer = setInterval(() => {
                                    scrollPosition = scrollPosition + 100;
                                }, 100);
                            }
                        }
                        else {
                            if (upTimer) {
                                clearInterval(upTimer);
                                upTimer = null;
                            }
                            if (downTimer) {
                                clearInterval(downTimer);
                                downTimer = null;
                            }
                            if (scrollTimer) {
                                clearInterval(scrollTimer);
                                scrollTimer = null;
                            }
                        }
                        if (upTimer || downTimer) {
                            if (!scrollTimer) {
                                scrollTimer = setInterval(() => {
                                    e.target.parentNode.scrollTo({top: scrollPosition, left: 0, behavior:'smooth'});
                                }, 100);
                            }
                        }
                        else {
                            if (scrollTimer) {
                                clearInterval(scrollTimer);
                                scrollTimer = null;
                            }
                        }

                        if (!document.getElementById('temporaryDiv')) {
                            const temporaryDiv = document.createElement('div');
                            temporaryDiv.style.width = '160px';
                            temporaryDiv.style.height = '160px';
                            temporaryDiv.style.marginBottom = '10px';
                            temporaryDiv.id = 'temporaryDiv';
                            const subDiv = document.createElement('div');
                            subDiv.style.width = '160px';
                            subDiv.style.height = '160px';
                            subDiv.style.marginBottom = '10px';
                            subDiv.id = 'subDiv';
                            temporaryDiv.appendChild(subDiv);

                            e.target.parentNode.insertBefore(temporaryDiv, e.target.nextSibling);
                        }

                        if (e.clientX < e.target.parentNode.offsetWidth) {
                            const _highlight = document.getElementById('highlight');
                            if (!_highlight) {
                                const highlight = document.createElement('div');
                                highlight.style.width = `${e.target.offsetWidth}px`;
                                highlight.style.height = '170px';
                                highlight.style.position = 'absolute';
                                // highlight.style.position = 'fixed';
                                highlight.style.left = `${document.getElementById('temporaryDiv').offsetLeft}px`;
                                highlight.style.backgroundColor = '#f6d6ad';
                                highlight.id = 'highlight';
                                highlight.style.zIndex = '1';
                                highlight.style.opacity = '0.4';

                                e.target.parentNode.appendChild(highlight);
                                // document.body.appendChild(highlight);
                            }

                            const children = e.target.parentNode.children;
                            const top = e.target.parentNode.scrollTop;

                            const childrenKeys = Object.keys(children);
                            if (e.clientX < e.target.parentNode.offsetWidth) {
                                try {
                                    childrenKeys.forEach(key => {
                                        if (children[key].offsetTop + 80 > e.clientY + top && children[key] !== e.target) {
                                            highlight.style.top = `${children[key].offsetTop - 90}px`;
                                            throw 'break';
                                        }
                                    });

                                    let lastChild = e.target.parentNode.lastChild;
                                    if (lastChild.id === 'highlight') {
                                        lastChild = lastChild.previousSibling;
                                    }

                                    if (lastChild.id === 'temporaryDiv') {
                                        highlight.style.top = `${lastChild.offsetTop - 90}px`;
                                    }
                                    else {
                                        highlight.style.top = `${lastChild.offsetTop + 80}px`;
                                    }
                                } catch(exception) {
                                }
                            }

                            if (!(e.target.classList.contains('move'))) {
                                e.target.classList.add('move');
                            }
                            if (e.target.classList.contains('range-out')) {
                                e.target.classList.remove('range-out');
                            }
                        }
                        else {
                            const highlight = document.getElementById('highlight');
                            if (highlight) {
                                highlight.remove();
                            }
                            if (!(e.target.classList.contains('range-out'))) {
                                e.target.classList.add('range-out');
                            }
                            if (e.target.classList.contains('move')) {
                                e.target.classList.remove('move');
                            }
                        }

                        if (e.target.classList.contains('relative')) {
                            e.target.classList.remove('relative');
                        }

                        e.target.style.opacity = '0.7';
                        e.target.style.zIndex = '3';

                        e.target.style.left = `${e.clientX - 80}px`;
                        e.target.style.top = `${e.clientY - 80}px`;
                    }
                }

                slideDiv.addEventListener('mousemove', (e) => {
                    handleDrag(e);
                })

                const handleDragEnd = (e) => {
                    if (upTimer) {
                        clearInterval(upTimer);
                        upTimer = null;
                    }
                    if (downTimer) {
                        clearInterval(downTimer);
                        downTimer = null;
                    }
                    if (scrollTimer) {
                        clearInterval(scrollTimer);
                        scrollTimer = null;
                    }
                    const children = e.target.parentNode.children;
                    const top = e.target.parentNode.scrollTop;

                    const childrenKeys = Object.keys(children);
                    let result = {};
                    if (e.clientX < e.target.parentNode.offsetWidth) {
                        childrenKeys.forEach(key => {
                            if (children[key].offsetTop + 80 > e.clientY + top) {
                                if (!result.hasOwnProperty('key')) {
                                    result = { ...result, key, child: children[key], length: childrenKeys.length};
                                }
                            }
                            if (children[key] === e.target) {
                                result = { ...result, targetKey: key};
                            }
                            if (children[key].id === 'temporaryDiv') {
                                result = { ...result, tempKey: key};
                            }
                        });
                    }
                    else
                    {
                        if (e.target.children.length > 0) e.target.children[0].click();
                    }

                    if (result.hasOwnProperty('key') && result.hasOwnProperty('targetKey') && result.hasOwnProperty('tempKey')) {
                        result.key = typeof result.key === 'string' ? result.key * 1 : result.key;
                        result.targetKey = typeof result.targetKey === 'string' ? result.targetKey * 1 : result.targetKey;
                        result.tempKey = typeof result.tempKey === 'string' ? result.tempKey * 1 : result.tempKey;

                        if (result.key > result.tempKey) {
                            result.key = result.key - 1;
                        }
                        if (result.targetKey > result.tempKey) {
                            result.targetKey = result.targetKey - 1;
                        }
                        if (result.targetKey < result.key) {
                            result.key = result.key - 1;
                        }
                        const target = slidesData[result.targetKey];

                        currentSlideIdx = result.key;
                        slidesData.splice(result.targetKey, 1);
                        slidesData.splice(result.key, 0, target);
                        that.switchSlidePos(result.key, result.targetKey, 1, slidesData);
                    }
                    else if (result.hasOwnProperty('targetKey') && result.hasOwnProperty('tempKey')) {
                        result.targetKey = typeof result.targetKey === 'string' ? result.targetKey * 1 : result.targetKey;
                        result.tempKey = typeof result.tempKey === 'string' ? result.tempKey * 1 : result.tempKey;

                        const target = slidesData[result.targetKey];

                        currentSlideIdx = slidesData.length - 1;
                        slidesData.splice(result.targetKey, 1);
                        slidesData.push(target);
                        that.switchSlidePos(result.key, result.targetKey, 2, slidesData);

                        currentSlideIdx = result.targetKey;

                    }


                    e.target.style.opacity = '1';
                    e.target.style.zIndex = '1';

                    e.target.style.left = 0;
                    e.target.style.top = 0;

                    const temporaryDiv = document.getElementById('temporaryDiv');
                    if (temporaryDiv) {
                        temporaryDiv.remove();
                    }
                    const highlight = document.getElementById('highlight');
                    if (highlight) {
                        highlight.remove();
                    }
                    if (e.target.classList.contains('down')) {
                        e.target.classList.remove('down');
                    }
                    if (e.target.classList.contains('move')) {
                        e.target.classList.remove('move');
                    }
                    if (e.target.classList.contains('range-out')) {
                        e.target.classList.remove('range-out');
                    }
                    if (!(e.target.classList.contains('relative'))) {
                        e.target.classList.add('relative');
                    }

                    updateSlides();
                    updateStudio();
                    updateContent();
                }

                slideDiv.addEventListener('mouseup', (e) => {
                    if (e.target.classList.contains('down')) {
                        handleDragEnd(e);
                    }
                });

                slideDiv.addEventListener('mouseleave', (e) => {
                    // handleDrag(e);
                    if (e.target.classList.contains('down')) {
                        handleDragEnd(e);
                    }
                });

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

                    console.log(thisSlideIdx);
                    that.slideDelete(thisSlideIdx);
                    if (currentSlideIdx === thisSlideIdx) {
                        if (slidesData.length === 1) {
                            currentSlideIdx = -1;
                        } else if (currentSlideIdx > 0){
                            currentSlideIdx--;
                        }
                    } else if (thisSlideIdx < currentSlideIdx) {
                        currentSlideIdx--;
                    }


                    slideDiv.remove();
                    slidesData = slidesData.filter((data) => data.id !== slideData.id);

                    updateStudio();
                    updateContent();
                    updateSlides();
                });
                // Prevent to call parent's events
                deleteBtn.addEventListener('mousedown', (e) => e.stopPropagation());
                deleteBtn.addEventListener('mouseup', (e) => e.stopPropagation());

                slideDiv.appendChild(deleteBtn);

                return slideDiv;
            }

            // 빈 Answer data를 반환합니다.
            function createAnswerData() {
                return {
                    answer: '',
                    isRightAnswer: false,
                    imgUrl: ''
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
                        return;
                    }

                    const file = e.target.files[0];

                    that.uploadImage(file).then((imgUrl) => {
                        img.src = imgUrl;
                    }).catch(() => {
                        alert('파일 업로드 기능을 지원하지 않는 브라우저 입니다. 다른 브라우저로 접속해주세요.');
                    }).finally(() => {
                        e.target.value = '';
                    });
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
                            imgUrl: ''
                        };
                    case 'text_image':
                        return {
                            ...dft,
                            type,
                            imgUrl: '',
                            text: '',
                        }
                    default:
                        return null;
                }
            }

            function updateSlides() {
                const existSlides = document.getElementsByClassName('slide');
                if (existSlides.length <= slidesData.length) {
                    for (let i = 0; i < slidesData.length; i++) {
                        let slide = existSlides[i];

                        if (i < existSlides.length) {
                            if (existSlides[i].getAttribute('unique-id') !== slidesData[i].id) {
                                slidesData[i].id = updateUniqueId(slidesData[i].id);
                                const newSlide = createSlide(slidesData[i]);

                                slide = newSlide;
                                existSlides[i].parentNode.replaceChild(newSlide, existSlides[i]);
                            }
                        } else {
                            const _newSlide = createSlide(slidesData[i]);
                            slide = _newSlide;
                            slides.appendChild(_newSlide);
                        }

                        if (i === currentSlideIdx && !slide.classList.contains('active')) {
                            slide.classList.add('active');
                        } else if (i !== currentSlideIdx && slide.classList.contains('active')) {
                            slide.classList.remove('active');
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
                            newAnswer.imgUrl = viewRows[i].querySelector('.img img').getAttribute('src');
                            const files =  viewRows[i].querySelector('input[type=file]').files;
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
                        newData.imgUrl = slidesData[currentSlideIdx].imgUrl;
                        break;
                    case 'text_image':
                        newData.imgUrl = slidesData[currentSlideIdx].imgUrl;
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

                //선우 수정할곳
                //JSON.stringify(slidesData[currentSlideIdx]);
            //<classes_room :room-id=JSON.stringify(slidesData[currentSlideIdx]></classes_room>

                that.viewSlide(slidesData[currentSlideIdx]);

                //renderer.innerHTML = '<classes_view></classes_view>';
                //renderer.innerHTML = '<input type="text" name="name" />';



            //<classes_room :user="{{ auth()->user() }}" :room-id="{{ $classes['id'] }}"></classes_room>
            }

            function uploadPPTImages(imgUrlList) {
                for (const imgUrl of imgUrlList) {
                    const emptySlideData = createEmptySlideData('image');
                    emptySlideData.imgUrl = imgUrl;
                    slidesData.push(emptySlideData);
                    this.sendSlide(emptySlideData);
                }

                updateSlides();
            };

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
                    if (currentSlideIdx !== -1) slidesData[currentSlideIdx].imgUrl = '';

                    if (
                        typeCards[i].getAttribute('data-contents-type') === 'multiple_choice' &&
                        slidesData[currentSlideIdx].type !== 'multiple_choice') {
                        const viewTable = studioElmt.querySelector('.view-table');
                        const rowCnt = viewTable.getElementsByTagName('div').length;
                        if (rowCnt < 2) {
                            for (let i = 0; i < 2 - rowCnt; i++) {
                                viewTable.appendChild(createViewRow(createAnswerData()));
                            }
                        }
                    }
                });
            }

            for (let i = 0; i < saveDataBtns.length; i++) {
                saveDataBtns[i].addEventListener('click', () => {
                    if (!saveContentToCurrentSlide()) {
                        alert('입력값을 다시 확인해주세요.');
                    } else {
                        this.updateSlide(currentSlideIdx, slidesData[currentSlideIdx]);
                    }
                });
            }

            appendAnswerBtn.addEventListener('click', () => {
                const newViewRow = createViewRow();
                multipleChoiceStudio.querySelector('.view-table').appendChild(newViewRow);
            });

            newSlideBtn.addEventListener('click', () => {
                slidesData.push(createEmptySlideData('multiple_choice'));

                this.sendSlide(slidesData[slidesData.length-1]);
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
            imageStudio.querySelector('.image-file').addEventListener('change', (e) => {
                if (e.target.files.length === 0 || currentSlideIdx === -1) {
                    return;
                }

                const file = e.target.files[0];
                that.uploadImage(file).then((imgUrl) => {
                    slidesData[currentSlideIdx].imgUrl = imgUrl;
                }).catch(() => {
                    alert('파일 업로드 기능을 지원하지 않는 브라우저 입니다. 다른 브라우저로 접속해주세요.');
                }).finally(() => {
                    e.target.value = '';
                });
            });
            textImageStudio.querySelector('.image-file').addEventListener('change', (e) => {
                if (e.target.files.length === 0 || currentSlideIdx === -1) {
                    return;
                }

                const file = e.target.files[0];
                that.uploadImage(file).then((imgUrl) => {
                    slidesData[currentSlideIdx].imgUrl = imgUrl;
                }).catch(() => {
                    alert('파일 업로드 기능을 지원하지 않는 브라우저 입니다. 다른 브라우저로 접속해주세요.');
                }).finally(() => {
                    e.target.value = '';
                });
            })
            document.querySelector('.back-btn').addEventListener('click', () => {
                that.navBack();
            });

            this.applyFetchSlideCallback((slides) => {
                const newSlides = [];

                for (const slide of slides.slides) {
                    const { slide_content } = slide;
                    newSlides.push({listId: slide.id, ...JSON.parse(slide_content)});
                }

                //정렬
                slidesData = [];

                const { slides_num } = slides;

                if (slides_num) {
                    this.slides.slides_num = slides_num;
                    this.slides.slides_num.forEach((e) => {
                        for (let i = 0; i < newSlides.length;i++) {
                            if (e === newSlides[i].listId) {
                                slidesData.push(newSlides[i]);
                                newSlides.splice(i, 1);
                                break;
                            }
                        }
                    });
                }
                else {
                    this.slides.slides_num = [];
                }
                //

                // slidesData = newSlides;
                updateSlides();
            });
            this.applyGetSlideIdxCallback(() => {
                return currentSlideIdx;
            });

            this.applyUploadPPTImagesCallback(uploadPPTImages);

            /* Vue Init */
            this.init();
        };
        /** ----------------- */
        // 해야할꺼
        // 중간에 들어왔을때 init 처리
        // 소켓 연결이 중간에 팅겼을때 처리
        // 슬라이드 저장 api 추가
    },



    methods: {
        init(){
            this.fetchSlide();
        },
        fetchSlide(){
            axios.get(window.location.pathname + '/api/fetch_slides').then(response => {
                this.slides = response.data;
                this.fetchSlideCallback(this.slides);
            })
        },
        applyFetchSlideCallback(callback) {
            this.fetchSlideCallback = callback;
        },
        applyGetSlideIdxCallback(callback) {
            this.getSlideIdxCallback = callback;
        },
        applyUploadPPTImagesCallback(callback) {
            this.uploadPPTImagesCallback = callback;
        },
        sendSlide(oneSlide){
            oneSlide={
                type: oneSlide.type,
                slide_content: JSON.stringify(oneSlide),
                available: 0,
                class_id: 1
            }


            axios.post(window.location.pathname + '/api/send_slides', {slides: oneSlide, room_id: this.$props.roomId }).then(re =>{
                console.log(this.slides);

                this.slides.slides.push({...oneSlide, id:re.data.data.id});
                this.slides.slides_num.push(re.data.data.id);
            });
        },
        updateSlide(slideIdx, oneSlideContent){
            axios.post(window.location.pathname + `/api/update_slides/${this.slides.slides_num[slideIdx]}`, {type: oneSlideContent.type,slide_content: JSON.stringify(oneSlideContent), room_id: this.$props.roomId });
        },
        slideClick(idx){
            this.sIndex = idx;
        },
        slideDelete(idx){
            let realIdx = null;
            const id = this.slides.slides_num[idx];

            console.log('slides.slides_num', this.slides.slides_num[idx]);
            console.log('slides.slides', this.slides.slides);

            for (let i = 0;i < this.slides.slides.length;i++) {
                if (this.slides.slides[i].id === id) {
                    realIdx = i;
                    break;
                }
            }

            if (realIdx !== null) {
                // console.log(this.slidesNum[idx])
                // const id = this.slides[idx].id;
                this.slides.slides.splice(realIdx, 1);
                this.slides.slides_num.splice(idx, 1);
                // this.slidesNum.splice(idx, 1);

                axios.post(window.location.pathname + '/api/delete_slides', {idx: id, room_id: this.$props.roomId });
            }
        },
        async switchSlidePos(key, targetKey, type, slidesData) {
            const slides_num = this.slides.slides_num;

            const sTarget = this.slides.slides[targetKey];

            const target = slides_num[targetKey];
            if (type === 1) {
                slides_num.splice(targetKey, 1);
                slides_num.splice(key, 0, target);

                this.slides.slides.splice(targetKey, 1);
                this.slides.slides.splice(key, 0, sTarget);
            } else {
                slides_num.splice(targetKey, 1);
                slides_num.push(target);

                this.slides.slides.splice(targetKey, 1);
                this.slides.slides.push(sTarget);
            }

            // const data = [];

            // for (let i = 0; i < this.slides.length; i++) {
            //     data.push(
            //         //JSON.stringify(slidesData[i])
            //         JSON.stringify(slides_num)
            //     );
            // }

            axios.post(window.location.pathname + '/api/update_all', {slides_num: slides_num, room_id: this.$props.roomId }).then((apiRes) => {
                // const [_, ids] = apiRes.data;

                // for (let i = 0; i < ids.length; i++) {
                //     this.slides[i].id = ids[i];
                // }
                const { slides_num } = apiRes.data[1];
                this.slides.slides_num = JSON.parse(slides_num);
            });
        },
        async uploadImage(file) {
            return new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append('file', file);
                axios.post(window.location.pathname + '/api/file_upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((apiRst) => {
                    const {imgUrl} = apiRst.data;
                    resolve(imgUrl);
                }).catch((err) => {
                    console.error(err);
                    reject();
                })
            }) ;

        },
        navBack() {
            location.href = location.href.substring(0, location.href.lastIndexOf(('/create')))
        },
        viewSlide(isSlide){
            this.isSlide = isSlide;
        },
        async uploadPPT(file) {
            console.log('업로드 시작');
            this.pptLoading = true;
            return new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append('file', file);
                axios.post(window.location.pathname + '/api/ppt_upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((apiRst) => {
                    const imgUrl = apiRst.data;
                    resolve(imgUrl);
                }).catch((err) => {
                    console.error(err);
                    reject();
                })
            }) ;
        },
        upPPT(event){
            this.uploadPPT(event.target.files[0]).then((imgUrlList) => {
                this.uploadPPTImagesCallback(imgUrlList);
                this.pptLoading = false;
                console.log('업로드 끝');
            }).catch(() => {
                alert('파일 업로드 기능을 지원하지 않는 브라우저 입니다. 다른 브라우저로 접속해주세요.');
            }).finally(() => {
            });
        }
    }
}
</script>
