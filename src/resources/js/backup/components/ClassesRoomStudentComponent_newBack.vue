<template>
    <div class='slide-student-container'>
        <div v-if=true>
            <div class="card">
                퀴즈 준지중
            </div>
        </div>
        <div v-else class="slide-student-content" v-html="data" id="slide_content">

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

class SlideRenderer {
    /**
     @param divId string svg가 만들어질 div id.
     @param width svg width.
     */

    constructor(vueObj, divId) {
        this.PAINT_WIDTH = 1000;
        this.divId = divId;
        this.vueObj = vueObj;
        this.slideData = undefined;
        this.paint = undefined; // 실제 tag들이 그려지는 div
        this.__init();
    }

    __init() {
        const newPaint = document.createElement('div');
        newPaint.style.height = 'auto';

        const cover = document.getElementById(this.divId);
        cover.appendChild(newPaint);
        this.paint = newPaint;
        this.paint.className = 'slide-renderer';

        const resizeObserver = new ResizeObserver(_ => {
            this.__resize();
        });

        resizeObserver.observe(cover);
    }

    __clearSvg() {
        this.paint.innerHTML = '';
    }

    // 커버의 width에 맞추어 scale값을 변경합니다.
    __resize() {
        const cover = document.getElementById(this.divId);
        const { width, height } = cover.getBoundingClientRect();
        const paintWidth = this.paint.scrollWidth;
        let paintHeight = this.paint.scrollHeight;

        const distanceX = (width - this.PAINT_WIDTH) / 2;

        const xR = width / paintWidth;
        const yR = height / paintHeight;

        this.paint.style.transform = yR < xR ?
            `scale(${yR}) translate(${distanceX}px, ${(height - paintHeight * yR) / 2}px)`
            : `scale(${xR}) translate(${distanceX}px, ${(height - paintHeight * xR) / 2}px)`;

    }

    /**
     slideData를 그리고, 내부 slideData에 정보값을 저장한다.
     slideData의 id값이 해당 인스턴스가 가지고 있는 slideData의
     id 다른 경우에만 다시 그린다.
     */
    renderSlideData(slideData) {
        if (this.slideData && slideData.id === this.slideData.id) return;
        this.slideData = slideData;
        this.__clearSvg();

        switch(slideData.type) {
            case 'multiple_choice':
                this.__renderMultipleChoiceData();
                break;
            case 'short_answer':
                this.__renderShortAnswerData();
                break;
            case 'text':
                this.__renderTextData();
                break;
            case 'image':
                this.__renderImageData();
                break;
            case 'text_image':
                this.__renderTextImageData();
                break;
            default:
                return;
        }

        this.__resize();
    }

    __renderMultipleChoiceData() {
        const { question, answers, timeout, score } = this.slideData;

        const questionText = this.__createElem('h1', 'absolute', '200px', '0px', '100%', 'auto');
        questionText.innerText = question;
        this.paint.appendChild(questionText);

        const table = this.__createElem('div', 'absolute', '300px', '300px', 'fit-content');
        table.className = 'answer-table';

        if (answers.length > 0) {
            for (let i = 0; i < answers.length; i++) {
                if (answers[i].answer.trim().length === 0) continue;
                const row = this.__createElem('div');
                row.className ='row';
                const firstColumn = this.__createElem('div');
                firstColumn.className = 'center-content';
                firstColumn.style.width = '100px';
                const secondColumn = this.__createElem('div');
                secondColumn.style.width = '350px';
                const radioBtn = this.__createElem('input',null,null);
                radioBtn.style.width = '25px';
                radioBtn.style.height = '25px';
                radioBtn.type = 'radio';
                radioBtn.name = 'answer';

                radioBtn.addEventListener('click', () => {
                    this.vueObj.chooseAnswer(i);
                })

                firstColumn.appendChild(radioBtn);

                const text = this.__createElem('span');
                text.style.display = 'block';
                text.innerText = answers[i].answer;
                secondColumn.appendChild(text);


                // imgUrl이 있을때만 이미지를 삽입합니다.
                // 기본 imgUrl로 로컬호스트 주소가 있어 확장자 검사로
                // 이미지 존재 여부를 확인합니다.
                // 밑에 코드는 실제 서버용
                const splitImgUrl = answers[i].imgUrl.split('/');
                if (splitImgUrl[splitImgUrl.length - 1].indexOf('.') >= 0) {
                // if (answers[i].imgUrl.indexOf('localhost') === -1) {
                    const img = this.__createElem('img');
                    img.src = answers[i].imgUrl;
                    secondColumn.appendChild(img);
                }

                row.appendChild(firstColumn);
                row.appendChild(secondColumn);
                table.appendChild(row);
            }
            this.paint.appendChild(table);
        }

    }

    __renderShortAnswerData() {
        this.__renderTest();
    }

    __renderTextData() {
        this.__renderTest();
    }

    __renderImageData() {
        this.__renderTest();
    }

    __renderTextImageData() {
        this.__renderTest();
    }

    __renderTest() {
        const testTitle = this.__createElem('h1', '200px', '100px', '100%', 'auto');
        testTitle.innerText = 'Test Title';

        this.paint.appendChild(testTitle);
    }



    __createElem(tagName, position, left, top, width, height) {
        const newTag = document.createElement(tagName);
        if (position) newTag.style.position = position;
        if (left) newTag.style.left = left;
        if (top) newTag.style.top = top;
        if (width) newTag.style.width = width;
        if (height) newTag.style.height = height;

        return newTag;
    }

    __getFont(fontSize) {
        return `${fontSize} '맑은 고딕', Arial`;
    }
}


export default {

    props:['user', 'roomId'],
    data() {
        return {
            slide: undefined,
            currentSlideIdx: -1,
            data: null,
            svgRenderer: null,
        }
    },
    mounted() {
        this.init();
    },
    created() {
        Echo.join('classesroom_'+this.$props.roomId)
            .here(user => {
                this.users = user;
            })
            .joining(user => {
                this.users.push(user);
            })
            .leaving(user => {
                this.users = this.users.filter(u => u.email !== user.email);
            })
            .listenForWhisper('slideClick', (idx) =>{
                axios.post(window.location.pathname + '/api/user/fetch_slide', {idx:idx}).then(response => {
                    // this.currentSlideIdx = idx;
                    this.slide = response.data[0];
                    this.slide.slide_content = JSON.parse(this.slide.slide_content);
                    this.renderSlideData();
                })

            })

        // window.onload = () =>{
        //     const slides = document.querySelector('.slides');
        //     let currentSlideIdx = -1; // -1은 선택된 슬라이드가 없을 때
        //     let slidesData = [];
        //
        // };
    },

    methods: {
        init(){
            this.svgRenderer = new SlideRenderer(this,'slide_content');
        },
        fetchSlide(){

        },
        renderSlideData() {
            if (!this.svgRenderer || !this.slide) return;


            this.svgRenderer.renderSlideData(this.slide.slide_content);


        },
        chooseAnswer(idx) {
            console.log(idx);
        }
    }
}
</script>
