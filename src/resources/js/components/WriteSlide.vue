<style scoped>
  /*.slide-move-down {*/

  /*}*/

  /*.slide-move {*/
  /*  background-color: #C9EEFF;*/
  /*  !*#5D9CEC #E4F5FD*!*/
  /*  opacity: 0.4;*/

  /*}*/

  /*.no-drag {*/
  /*  -ms-user-select: none;*/
  /*  -moz-user-select: none;*/
  /*  -webkit-user-select: none;*/
  /*  -khtml-user-select: none;*/
  /*  user-select:none;*/
  /*}*/

  /*.slide-move-clone{*/
  /*  opacity: 0.6;*/
  /*}*/
</style>

<template>
    <div v-if="pptUpload !== 'SENDING'" style="display: flex; flex-direction: row; width: 100%; height: 100%;" :key="componentKey">
        <div class="new-slide__left">
            <ul class="slide-list" id="slide-container">
                <draggable :list="slides" @change="slideMove">
                    <transition-group name="drag_list">
                        <li v-for="(slide, index) in slides"
                            class="slide-list__item"
                            @click="selectSlide(index)"

                            :key="'slide_key'+slide.id"
                        >
                            <span class="eq">{{index+1}}</span>
                            <div class="slide-list__con" v-bind:class="
                            [
                                {multiple: slide.type === 'multiple_choice'},
                                {subjective: slide.type === 'short_answer'},
                                {text: slide.type === 'text'},
                                {img: slide.type === 'image'},
                                {multi: slide.type === 'text_image'},
                                {undecided: slide.type === 'none'},
                                {active: slide.id === selectedSlide.id}
                            ]">
                                <button class="slide-list__delete" @click="delSlide(index)"></button>
                            </div>
                        </li>
                    </transition-group>
                </draggable>
            </ul>
            <div class="slide-list__bottom">
                <button class="btn-primary btn-round btn-normal col2 mb-10" @click="addSlide">+ 새 슬라이드</button>
                <label class="btn btn-primary btn-round btn-normal col2 mb-10"><input type="file" id="ex_file" v-on:change="pptUploadMethod" />+ ppt 업로드</label>
                <button class="btn-red btn-round btn-normal col2 btn-out" @click="allSendSlides">내보내기 </button>
            </div>
        </div>
        <div class="new-slide__wrap" v-bind:class="{'right-menu-active':sideBtn}">
            <div class="new-slide__con">
                <h2 class="tit">
                    {{_proUrl}}
                </h2>
<!--                <div v-if="selectedSlide.type === 'none'" class="con">질문을 입력하세요.</div>-->
                <div class="con">
                    <slide_content :slide="selectedSlide" :isOwn="true" :isWriting="true" ref="_slide_content"/>
                </div>
            </div>
        </div>
        <div class="new-slide__right" v-bind:class="{'active':sideBtn}">
            <button class="right-active-btn" v-bind:class="{active:!sideBtn}" @click="sideBtnBtnOn"></button>
            <ul class="write-slide">
                <li class="type">
                    <h3 class="write-slide__tit" v-bind:class="{active:activeBtn}" @click="activeBtnOn">타입</h3>
                    <div class="type__con">
                        <h4 class="write-slide__label">Quiz</h4>
                        <div class="radio-wrap">
                            <input type="radio" name="type" id="multiple" checked
                                   @click="selectTypeContent('multiple_choice')"
                                   :checked="selectedSlide.type === 'multiple_choice'"
                            />
                            <label class="radio-type multiple" for="multiple" ></label>

                            <input type="radio" name="type" id="subjective"
                                   @click="selectTypeContent('short_answer')"
                                   :checked="selectedSlide.type === 'short_answer'"
                            />
                            <label class="radio-type subjective" for="subjective"></label>
                        </div>
                        <h4 class="write-slide__label">Content slide</h4>
                        <div class="radio-wrap">
                            <input type="radio" name="type" id="text"
                                   @click="selectTypeContent('text')"
                                   :checked="selectedSlide.type === 'text'"
                            />
                            <label class="radio-type text" for="text"></label>

                            <input type="radio" name="type" id="img"
                                   @click="selectTypeContent('image')"
                                   :checked="selectedSlide.type === 'image'"
                            />
                            <label class="radio-type img" for="img"></label>

                            <input type="radio" name="type" id="multi"
                                   @click="selectTypeContent('text_image')"
                                   :checked="selectedSlide.type === 'text_image'"
                            />
                            <label class="radio-type multi" for="multi"></label>
                        </div>
                    </div>
                </li>
                <li class="con">
                    <h3 class="write-slide__tit" v-bind:class="{active:!activeBtn}" @click="activeBtnOn">내용</h3>
                    <div v-if="selectedSlide.type === 'text' && !activeBtn"
                         v-on:change="changeCheckData"
                         v-on:input="changeCheckData"
                         class="con__con">
                        <button @click="sendSlide" v-bind:class="{'btn-disable':!changeState[currentIndex]}"
                                class="btn-normal col2 btn-round btn-primary btn-check">
                            슬라이드 반영
                        </button>
                        <h4 class="write-slide__label">제목</h4>
                        <div class="input-wrap">
                            <input type="text" placeholder="제목을 입력하세요." v-model="selectedSlide.slide_content.question"/>
                        </div>
                        <h4 class="write-slide__label">내용</h4>
                        <div class="input-wrap">
                            <textarea placeholder="내용을 입력하세요." v-model="selectedSlide.slide_content.answer" rows="6"></textarea>
                        </div>
                    </div>
                    <div v-else-if="selectedSlide.type === 'image' && !activeBtn"
                         v-on:change="changeCheckData"
                         v-on:input="changeCheckData"
                         class="con__con">
                        <button @click="sendSlide" v-bind:class="{'btn-disable':!changeState[currentIndex]}"
                                class="btn-normal col2 btn-round btn-primary btn-check">
                            슬라이드 반영
                        </button>
                        <h4 class="write-slide__label">이미지</h4>
                        <div class="input-wrap">
<!--                            <label class="example-file" v-bind:class="{bg:item.imgUrl}">-->
                            <label class="img-file" v-bind:class="{bg:selectedSlide.slide_content.imgUrl}">
<!--                                <div id="text_image_iasadmg">-->
                                    <input type="file" id='content_image' v-on:change="uploadImage"/>
<!--                                </div>-->
                                <img :id="'image_'+selectedSlide.id"/>
                            </label>
                            <div class="a-right mt-10">
                                <button class="btn-sm btn-round btn-primary">수정</button>
                                <button class="btn-sm btn-round btn-red">삭제</button>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="selectedSlide.type === 'text_image' && !activeBtn"
                         v-on:change="changeCheckData"
                         v-on:input="changeCheckData"
                         class="con__con">
                        <button @click="sendSlide" v-bind:class="{'btn-disable':!changeState[currentIndex]}"
                                class="btn-normal col2 btn-round btn-primary btn-check">
                            슬라이드 반영
                        </button>

                        <h4 class="write-slide__label">이미지 배치</h4>
                        <div class="radio-wrap">
                            <input type="radio" name="type" id="top"
                                   @click="selectSortType(0)"
                                   :checked="selectedSlide.slide_content.sortType === 0"
                            />
                            <label class="radio-range top" for="top" >상단정렬</label>
                            <input type="radio" name="type" id="bottom"
                                   @click="selectSortType(1)"
                                   :checked="selectedSlide.slide_content.sortType === 1"
                            />
                            <label class="radio-range bottom" for="bottom" >하단정렬</label>
                            <input type="radio" name="type" id="left"
                                   @click="selectSortType(2)"
                                   :checked="selectedSlide.slide_content.sortType === 2"
                            />
                            <label class="radio-range left" for="left" >왼쪽정렬</label>
                            <input type="radio" name="type" id="right"
                                   @click="selectSortType(3)"
                                   :checked="selectedSlide.slide_content.sortType === 3"
                            />
                            <label class="radio-range right mr-0" for="right" >오른쪽정렬</label>
                        </div>
                        <h4 class="write-slide__label">이미지</h4>
                        <div class="input-wrap">
                            <label class="img-file mb-10" v-bind:class="{bg:selectedSlide.slide_content.imgUrl}">
                                <input type="file" id='content_text_image' v-on:change="uploadImage"/>

                                <!--                                <div id="text_image_img">-->
                                <img :id="'text_image_'+selectedSlide.id"/>
                                <!--                                </div>-->
                            </label>
                        </div>
                        <h4 class="write-slide__label">내용</h4>
                        <div class="input-wrap">
                            <textarea placeholder="내용을 입력하세요." rows="6" v-model="selectedSlide.slide_content.question"></textarea>
                        </div>
                        <br>
                    </div>
                    <div v-else-if="selectedSlide.type === 'short_answer' && !activeBtn"
                         v-on:change="changeCheckData"
                         v-on:input="changeCheckData"
                         class="con__con">
                        <button @click="sendSlide" v-bind:class="{'btn-disable':!changeState[currentIndex]}"
                                class="btn-normal col2 btn-round btn-primary btn-check">
                            슬라이드 반영
                        </button>

                        <h4 class="write-slide__label">질문</h4>
                        <div class="input-wrap">
                            <input type="text" placeholder="질문을 입력하세요." v-model="selectedSlide.slide_content.question"/>
                        </div>
                        <h4 class="write-slide__label inline">
                            정답
                        </h4>
                        <label class="switch">
                            <input type="checkbox"
                                   name="activationAnswer"
                                   v-model="selectedSlide.activationAnswer"
                                   :checked=selectedSlide.activationAnswer> <br>
                        </label>
                        <div class="input-wrap">
                            <input v-if="selectedSlide.activationAnswer"
                                   type="text"
                                   placeholder="이곳에 의견을 얘기해주세요."
                                   v-model="selectedSlide.slide_content.answer"/>
                        </div>
                        <h4 class="write-slide__label inline">
                            제한시간
                        </h4>
                        <label class="switch">
                            <input type="checkbox"
                                   name="activationTimeLimit"
                                   v-model="selectedSlide.activationTimeLimit"
                                   :checked=selectedSlide.activationTimeLimit
                                   @click="setActivationTime">
                        </label>

                            <div class="input-wrap">
                                <div v-if="selectedSlide.activationTimeLimit">
                                    <input type="number" class="second" placeholder="0" name="timeout"
                                           :min=1
                                           :max=100
                                           v-model="selectedSlide.slide_content.timeout"/> 초 <br>
                                </div>
                            </div>


                        <div v-if="selectedSlide.activationAnswer">
                            <h4 class="write-slide__label inline">
                                점수부여
                            </h4>
                            <label class="switch">
                                <input type="checkbox"
                                       name="activationScore"
                                       v-model="selectedSlide.activationScore"
                                       :checked=selectedSlide.activationScore
                                       :disabled=!(selectedSlide.activationAnswer)>
                            </label>
                        </div>

                        <div v-if="selectedSlide.activationScore && selectedSlide.activationAnswer">
                            <div class="input-wrap">
                                <div v-if="selectedSlide.activationFirstCome" >
                                    최소 <input type="number" class="score" placeholder="0"
                                              :min=1
                                              :max="selectedSlide.slide_content.maxScore"
                                              v-model="selectedSlide.slide_content.minScore"/> 점<span class="mr-20"></span>
                                    최대 <input type="number" class="score" placeholder="0"
                                              :min="selectedSlide.slide_content.minScore"
                                              :max=100
                                              v-model="selectedSlide.slide_content.maxScore"/> 점
                                    <br>
                                </div>
                                <div v-else>
                                    포인트 <input type="number" class="score" placeholder="0"
                                               :min=1
                                               :max=100
                                               v-model="selectedSlide.slide_content.maxScore"/> 점
                                </div>
                                <label v-if="selectedSlide.activationTimeLimit" class="checkbox mb-10">
                                    <input type="checkbox"
                                           name="activationFirstCome"
                                           v-model="selectedSlide.activationFirstCome"
                                           :checked=selectedSlide.activationFirstCome> 선착순 가점 부여
                                </label>
                            </div>

                            <h4 class="write-slide__label inline">
                                리더보드
                            </h4>
                            <label class="switch">
                                <input type="checkbox"
                                       name="activationLayout"
                                       v-model="selectedSlide.activationLayout"
                                       :checked=selectedSlide.activationLayout
                                       :disabled=!(selectedSlide.activationAnswer)>
                            </label>
                            <div v-if="selectedSlide.activationLayout && selectedSlide.activationAnswer">
                                <h4 class="write-slide__label">
                                    결과 레이아웃
                                </h4>
                                <div class="radio-wrap">
                                    <input type="radio" name="layout" id="_stick"
                                           @click="selectLayoutContent('line_graph')"
                                           :checked="selectedSlide.slide_content.resultLayout === 'line_graph'"
                                    >
                                    <label class="radio-type stick" for="_stick"></label>


                                    <input type="radio" name="layout" id="_donut"
                                           @click="selectLayoutContent('donut_chart')"
                                           :checked="selectedSlide.slide_content.resultLayout === 'donut_chart'"
                                    >
                                    <label class="radio-type donut" for="_donut"></label>

                                    <br>

                                    <input type="radio" name="layout" id="_pie"
                                           @click="selectLayoutContent('pie_chart')"
                                           :checked="selectedSlide.slide_content.resultLayout === 'pie_chart'"
                                    >
                                    <label class="radio-type pie" for="_pie"></label>

                                    <input type="radio" name="layout" id="_word"
                                           @click="selectLayoutContent('word_cloud')"
                                           :checked="selectedSlide.slide_content.resultLayout === 'word_cloud'"
                                    >
                                    <label class="radio-type word" for="_word"></label>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div v-else-if="selectedSlide.type === 'multiple_choice' && !activeBtn"
                         v-on:change="changeCheckData"
                         v-on:input="changeCheckData"
                         class="con__con">
                        <button @click="sendSlide" v-bind:class="{'btn-disable':!changeState[currentIndex]}"
                                class="btn-normal col2 btn-round btn-primary btn-check">
                            슬라이드 반영
                        </button>


                        <h4 class="write-slide__label">질문</h4>
                        <div class="input-wrap">
                            <input type="text" placeholder="질문을 입력하세요." v-model="selectedSlide.slide_content.question"/>
                        </div>
                        <h4 class="write-slide__label">
                            보기
                            <label class="switch right">
                                정답
                                <input type="checkbox" name="activationAnswer" v-model="selectedSlide.activationAnswer" :checked=selectedSlide.activationAnswer>
                            </label>
                        </h4>
                        <div class="input-wrap">
                            <draggable :list="selectedSlide.slide_content.answers" @change="answerMove">
                                <div v-for="(item, index) in selectedSlide.slide_content.answers" style="display: flex; flex-direction: row;">
                                    <div class="example">
                                        <div class="btn-move">
                                            <button class="btn-up" @click="swapAnswerItem(index, 0)"></button>
                                            <button class="btn-down" @click="swapAnswerItem(index, 1)"></button>
                                        </div>
                                        <input type="text" placeholder="내용을 입력하세요." v-model="item.answer"/>

                                        <template v-if="!item.imgUrl">
                                            <label class="example-file" v-bind:class="{bg:item.imgUrl}">
                                                <input type="file" :id="'multiple_'+index" v-on:change="uploadImage"/>
                                                <img v-if="item.imgUrl" :id="'multiple_choice_'+selectedSlide.id+'_'+index">
                                            </label>
                                        </template>
                                        <template v-else>
<!--                                            <label class="example-file" v-bind:class="{bg:item.imgUrl}">-->
<!--                                                <img v-if="item.imgUrl" :id="'multiple_choice_'+selectedSlide.id+'_'+index">-->
<!--                                            </label>-->
                                            <label class="example-file bg">
                                                <img v-if="item.imgUrl"
                                                     :id="'multiple_choice_'+selectedSlide.id+'_'+index"
                                                     @click="selectedAnswer(index)"
                                                >
                                                <div class="example-file__modi" v-bind:class="{'dn':!item.answerBtn}">
                                                    <button class="btn-sm btn-primary btn-round"><label :for="'multiple_'+index">수정</label></button>
                                                    <button class="btn-sm btn-red btn-round" v-on:click.stop.prevent="delAnswerImg(index)">삭제</button>
                                                    <input type="file" :id="'multiple_'+index" v-on:change="uploadImage"/>
                                                </div>
                                            </label>

                                        </template>

                                        <label class="example-check">
                                            <input type="checkbox" name="isRightAnswer"
                                                   v-model="item.isRightAnswer"
                                                   :checked=item.isRightAnswer
                                                   :disabled=!(selectedSlide.activationAnswer)>
                                        </label>
                                        <button class="btn-delete" @click="delAnswerItem(index)"></button>
                                    </div>
                                </div>
                            </draggable>


                            <button class="example__add-btn" @click="addAnswerItem">
                                <span class="btn btn-plus">
                                </span>보기 추가
                            </button>
                        </div>

                        <h4 class="write-slide__label inline">
                            대답 제한시간
                        </h4>
                        <label class="switch">
                            <input type="checkbox" name="activationTimeLimit" v-model="selectedSlide.activationTimeLimit" :checked=selectedSlide.activationTimeLimit @click="setActivationTime">
                        </label>

                        <div v-if="selectedSlide.activationTimeLimit" class="input-wrap">
<!--                            <input type="text" class="second" placeholder="0" /> 초-->
                            <input type="number" class="second" placeholder="0" name="timeout"
                                   :min=1
                                   :max=100
                                   v-model="selectedSlide.slide_content.timeout"/> 초 <br>
                        </div>


                        <div v-if="selectedSlide.activationAnswer">
                            <h4 class="write-slide__label inline">
                                점수부여selectedAnswer
                            </h4>

                            <label class="switch">
                                <input type="checkbox" name="activationScore" v-model="selectedSlide.activationScore" :checked=selectedSlide.activationScore :disabled=!(selectedSlide.activationAnswer)>
                            </label>
                        </div>
                        <div v-if="selectedSlide.activationScore && selectedSlide.activationAnswer">
                            <div class="input-wrap">
                                <div v-if="selectedSlide.activationFirstCome" >
                                    최소 <input type="number" class="score" placeholder="0"
                                              :min=1
                                              :max="selectedSlide.slide_content.maxScore"
                                              v-model="selectedSlide.slide_content.minScore"/> 점<span class="mr-20"></span>
                                    최대 <input type="number" class="score" placeholder="0"
                                              :min="selectedSlide.slide_content.minScore"
                                              :max=100
                                              v-model="selectedSlide.slide_content.maxScore"/> 점
                                    <br>
                                </div>
                                <div v-else>
                                    포인트 <input type="number" class="score" placeholder="0"
                                               :min=1
                                               :max=100
                                               v-model="selectedSlide.slide_content.maxScore"/> 점
                                </div>
<!--                                    -->
<!--                                <div v-if="selectedSlide.activationFirstCome">-->
<!--                                    최소 <input type="text" class="score" placeholder="0" v-model="selectedSlide.slide_content.minScore"/> 점<span class="mr-20"></span>-->
<!--                                    최대 <input type="text" class="score" placeholder="0" v-model="selectedSlide.slide_content.maxScore"/> 점-->
<!--                                    <br>-->
<!--                                </div>-->
<!--                                <div v-else>-->
<!--                                    포인트 <input type="text" class="score" placeholder="0" v-model="selectedSlide.slide_content.maxScore"/> 점-->
<!--                                </div>-->
                                <label v-if="selectedSlide.activationTimeLimit" class="checkbox mb-10">
                                    <input type="checkbox" name="activationFirstCome"
                                           v-model="selectedSlide.activationFirstCome"
                                           :checked=selectedSlide.activationFirstCome>
                                    선착순 가점 부여
                                </label>
                            </div>
                            <h4 class="write-slide__label inline">
                                리더보드
                            </h4>
                            <label class="switch">
                                <input type="checkbox" name="activationLayout"
                                       v-model="selectedSlide.activationLayout"
                                       :checked=selectedSlide.activationLayout
                                       :disabled=!(selectedSlide.activationAnswer)>
                            </label>
                            <div v-if="selectedSlide.activationLayout && selectedSlide.activationAnswer">
                                <h4 class="write-slide__label">
                                    결과 레이아웃
                                </h4>
                                <div class="radio-wrap">
<!--                                    <input type="radio" name="layout" id="stick" />-->

                                    <input type="radio" name="layout" id="stick"
                                           @click="selectLayoutContent('line_graph')"
                                           :checked="selectedSlide.slide_content.resultLayout === 'line_graph'"
                                    >
                                    <label class="radio-type stick" for="stick"></label>


                                    <input type="radio" name="layout" id="donut"
                                           @click="selectLayoutContent('donut_chart')"
                                           :checked="selectedSlide.slide_content.resultLayout === 'donut_chart'"
                                    >
                                    <label class="radio-type donut" for="donut"></label>



                                    <input type="radio" name="layout" id="pie"
                                           @click="selectLayoutContent('pie_chart')"
                                           :checked="selectedSlide.slide_content.resultLayout === 'pie_chart'"
                                    >
                                    <label class="radio-type pie" for="pie"></label>


                                </div>
                                <br>
                            </div>
                        </div>
                    </div>

                </li>
            </ul>
        </div>

        <div class="dim" id="write_copy_modal" v-bind:class="{'dn':!slideEx}">
            <div class="alert">
                <div class="alert__con">
                    기존에 만든 슬라이드 복사<br />
                    <select id='writeToCopy' class="alert__select">
                        <option :value="'none'">
                            선택
                        </option>
                        <option v-for="(slide, index) in slideEx" :value="index">
                            {{slide['name']}}
                        </option>
                    </select>
                </div>
                <div class="alert__bottom">
                    <div class="alert__btn-wrap">
                        <button class="alert__btn gray" @click=slideExBtnOff>취소</button>
                    </div>
                    <div class="alert__btn-wrap">
                        <button class="alert__btn primary ok-btn" @click="slideExBtnOn">확인</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="dim" id="slide_error_modal" v-bind:class="{'dn':!errorMsg}">
            <div class="alert">
                <div class="alert__con">
                    {{errorMsg}}
                </div>
                <div class="alert__bottom">
                    <div class="alert__btn-wrap">
                        <button class="alert__btn primary ok-btn" @click="errorMsg = null">확인</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
      LOADING
    </div>
</template>

<script>
export default {
    // props:['lectureId', 'classId', 'proUrl'],
    props: {
        lectureId : Number,
        classId : Number,
        proUrl : String,
    },
    data() {
        return {
            slides: [],
            originSlides: [],
            changeState: [],
            selectedSlide: '',
            currentIndex: -1,
            componentKey: 0,
            pptUpload: 'NORMAL',
            activeBtn: true,
            sideBtn: false,
            _proUrl: '',
            slideEx: null,
            selectedEx: 'none',
            errorMsg: null,
            position: null,
        }
    },
    created() {     //렌더링이 되기전
        this.init();
    },
    mounted() {     //렌더링이 되고 나서
        this.$nextTick(() => {
            // 모든 화면이 렌더링된 후 실행
        });

        // Select Menu
        $(document).ready(()=>{
            const that = this;
            $("#writeToCopy").selectmenu();
            $("#writeToCopy").selectmenu({
                change: function () {
                    that.selectedEx = $(this).val();
                }
            });
        });
    },
    beforeUpdate() {    //data 값이 바뀌기는 전 순간에 호출
    },
    updated(){          //data 값이 바뀌고나서 호출
        this.updateImage();
    },
    methods: {
        init(){
            this.fetchSlides();
            // this.proUrl = this.$props.userUrl;
            this._proUrl = this.$props.proUrl;
            const href = window.location.href.split('/');
            this._proUrl = href[2] + '/room/' + this.$props.proUrl;

            this.slideExCheck();
        },
        slideExCheck(){
            axios.get(window.location.pathname+'/slideExCheck').then(re=>{
                if(re.data){
                    this.slideEx = re.data;

                    if(this.slideEx.length === 1 && this.slideEx[0].id === this.$props.classId){
                        this.slideEx = null;
                    }
                }
            })
        },
        slideExBtnOn(){
            if(0 <= this.selectedEx){
                const idx = this.selectedEx;
                axios.post(window.location.pathname+'/slideExCheck', {slideEx:this.slideEx[idx]}).then(re=>{
                    if(re.data){
                        this.selectedSlide = [];
                        this.slides = [];
                        this.originSlides = [];

                        this.fetchSlides();
                    }
                })

                this.slideEx = '';
            }
        },
        slideExBtnOff(){
            this.slideEx = '';
        },
        pptUploadMethod(e){
            this.pptUpload = 'SENDING';

            const file = e.target.files[0];

            const formData = new FormData();
            formData.append('file', file);

            axios.post(window.location.pathname+'/pptUpload', formData,
                {headers: {'Content-Type': 'multipart/form-data'}}
                ).then(re=>{
                    if(re.data === 'TRUE'){
                        this.selectedSlide = [];
                        this.slides = [];
                        this.originSlides = [];

                        this.fetchSlides();
                    }
                    else if(re.data === 'NOTYPE'){
                        this.errorMsg = 'ppt 또는 pdf 파일만 가능합니다.'
                    }
                    else if(re.data === 'ERROR'){
                        this.errorMsg = '다시 시도 해주시길 바랍니다.';
                    }
                    else if(re.data === 'FALSE'){
                        this.errorMsg = '파일 업로드 실패';
                    }

                    this.pptUpload = 'NORMAL';
            });
        },
        setActivationTime(){
            if(this.selectedSlide.activationFirstCome){
                this.selectedSlide.activationFirstCome = !this.selectedSlide.activationFirstCome;
            }
        },
        fetchSlides(){
            axios.get(window.location.pathname+'/fetchSlides', ).then(re=>{
                if(re.data.status === true){
                    const slidesNum = re.data.slides_num;
                    if(!slidesNum){
                      return;
                    }

                    for(let i=0;i<slidesNum.length;i++){
                        for(let j=0;j<re.data.slides.length;j++){
                            if(slidesNum[i] === re.data.slides[j].id){
                                if(re.data.slides[j].type === 'none'){
                                    this.slides.push({
                                        id: re.data.slides[j].id,
                                        slides_num: slidesNum[i],
                                        type: re.data.slides[j].type,
                                        slide_content: re.data.slides[j].slide_content
                                    })

                                    this.originSlides.push({
                                        none:
                                        {
                                            id: re.data.slides[j].id,
                                            slides_num: slidesNum[i],
                                            type: re.data.slides[j].type,
                                            slide_content: _.cloneDeep(re.data.slides[j].slide_content)
                                        }
                                    })

                                    this.changeState.push(false);
                                }
                                else{
                                    const _slide_content = re.data.slides[j].slide_content;
                                    // _slide_content.answers = JSON.parse(_slide_content.answers);

                                    this.slides.push({
                                        id: re.data.slides[j].id,
                                        slides_num: slidesNum[i],
                                        type: re.data.slides[j].type,
                                        activationAnswer: !!re.data.slides[j].activation_answer,
                                        activationTimeLimit: !!re.data.slides[j].activation_time_limit,
                                        activationScore: !!re.data.slides[j].activation_score,
                                        activationFirstCome: !!re.data.slides[j].activation_first_come,
                                        activationLayout: !!re.data.slides[j].activation_layout,
                                        slide_content: _slide_content
                                    })

                                    if(re.data.slides[j].type === 'multiple_choice'){
                                        this.originSlides.push({
                                            multiple_choice:{
                                                id: re.data.slides[j].id,
                                                slides_num: slidesNum[i],
                                                type: re.data.slides[j].type,
                                                activationAnswer: !!re.data.slides[j].activation_answer,
                                                activationTimeLimit: !!re.data.slides[j].activation_time_limit,
                                                activationScore: !!re.data.slides[j].activation_score,
                                                activationFirstCome: !!re.data.slides[j].activation_first_come,
                                                activationLayout: !!re.data.slides[j].activation_layout,
                                                slide_content: _.cloneDeep(_slide_content)
                                            }
                                        })
                                    }
                                    else if(re.data.slides[j].type === 'short_answer'){
                                        this.originSlides.push({
                                            short_answer:{
                                                id: re.data.slides[j].id,
                                                slides_num: slidesNum[i],
                                                type: re.data.slides[j].type,
                                                activationAnswer: !!re.data.slides[j].activation_answer,
                                                activationTimeLimit: !!re.data.slides[j].activation_time_limit,
                                                activationScore: !!re.data.slides[j].activation_score,
                                                activationFirstCome: !!re.data.slides[j].activation_first_come,
                                                activationLayout: !!re.data.slides[j].activation_layout,
                                                slide_content: _.cloneDeep(_slide_content)
                                            }
                                        })
                                    }
                                    else if(re.data.slides[j].type === 'text'){
                                        this.originSlides.push({
                                            text:{
                                                id: re.data.slides[j].id,
                                                slides_num: slidesNum[i],
                                                type: re.data.slides[j].type,
                                                activationAnswer: !!re.data.slides[j].activation_answer,
                                                activationTimeLimit: !!re.data.slides[j].activation_time_limit,
                                                activationScore: !!re.data.slides[j].activation_score,
                                                activationFirstCome: !!re.data.slides[j].activation_first_come,
                                                activationLayout: !!re.data.slides[j].activation_layout,
                                                slide_content: _.cloneDeep(_slide_content)
                                            }
                                        })
                                    }
                                    else if(re.data.slides[j].type === 'image'){
                                        this.originSlides.push({
                                            image:{
                                                id: re.data.slides[j].id,
                                                slides_num: slidesNum[i],
                                                type: re.data.slides[j].type,
                                                activationAnswer: !!re.data.slides[j].activation_answer,
                                                activationTimeLimit: !!re.data.slides[j].activation_time_limit,
                                                activationScore: !!re.data.slides[j].activation_score,
                                                activationFirstCome: !!re.data.slides[j].activation_first_come,
                                                activationLayout: !!re.data.slides[j].activation_layout,
                                                slide_content: _.cloneDeep(_slide_content)
                                            }
                                        })
                                    }
                                    else if(re.data.slides[j].type === 'text_image'){
                                        this.originSlides.push({
                                            text_image:{
                                                id: re.data.slides[j].id,
                                                slides_num: slidesNum[i],
                                                type: re.data.slides[j].type,
                                                activationAnswer: !!re.data.slides[j].activation_answer,
                                                activationTimeLimit: !!re.data.slides[j].activation_time_limit,
                                                activationScore: !!re.data.slides[j].activation_score,
                                                activationFirstCome: !!re.data.slides[j].activation_first_come,
                                                activationLayout: !!re.data.slides[j].activation_layout,
                                                slide_content: _.cloneDeep(_slide_content)
                                            }
                                        })
                                    }

                                    this.changeState.push(false);
                                }
                                break;
                            }
                        }
                    }
                }
            });
        },
        forceRerender() {
            this.componentKey += 1;
        },
        addSlide(){
            const _slide ={
                type: 'none',
                slide_content: ''
            }

            axios.post(window.location.pathname, {slide: _slide}).then(re=>{
                if(re.data.status === true){
                    this.slides.push({
                        id: re.data.slide.id,
                        slides_num: re.data.slides_num[re.data.slides_num.length-1],
                        type: 'none',
                        slide_content: ''
                    })

                    this.originSlides.push({
                        none:{
                            id: re.data.slide.id,
                            slides_num: re.data.slides_num[re.data.slides_num.length-1],
                            type: 'none',
                            slide_content: ''
                        }
                    })

                    this.changeState.push(false);
                }
            });
        },
        delSlide(idx){
            if(this.slides.length === 1){
                axios.get(window.location.pathname+'/deleteSlide/'+this.slides[idx].id ).then(re=>{
                    if(re.data){
                        this.slides.splice(idx,1);
                        this.originSlides.splice(idx,1);
                        this.changeState.splice(idx,1);

                        this.selectSlide(-1);
                    }
                });
            }
            else if(idx >= this.slides.length-1){
                axios.get(window.location.pathname+'/deleteSlide/'+this.slides[idx].id ).then(re=>{
                    if(re.data) {
                        this.slides.splice(idx, 1);
                        this.originSlides.splice(idx,1);
                        this.changeState.splice(idx,1);

                        this.selectSlide(idx - 1);
                    }
                });
            }
            else{
                axios.get(window.location.pathname+'/deleteSlide/'+this.slides[idx].id, ).then(re=>{
                    if(re.data){
                        this.slides.splice(idx,1);
                        this.originSlides.splice(idx,1);
                        this.changeState.splice(idx,1);
                    }
                })
            }
        },
        selectSlide(idx){
            if(idx === -1){
                this.currentIndex = idx;
                this.selectedSlide = '';
            }
            else if(idx >= 0 && idx < this.slides.length){
                this.currentIndex = idx;
                this.selectedSlide = this.slides[idx];
                this.activeBtn = false;

                this.selectBtnCheck();
            }
        },
        selectTypeContent(type){
            //슬라이드 종류 초기 선택시 || 다른 종류 선택시
            if(this.selectedSlide.type !== type){
                if(this.originSlides[this.currentIndex][type]){
                    const tempSlide = _.cloneDeep(this.slides[this.currentIndex]);
                    const tempType = this.selectedSlide.type;

                    this.slides[this.currentIndex] = _.cloneDeep(this.originSlides[this.currentIndex][type]);
                    this.selectedSlide = this.slides[this.currentIndex];
                    this.originSlides[this.currentIndex][tempType] = _.cloneDeep(tempSlide);
                    // this.updateImage();
                }
                else{
                    this.originSlides[this.currentIndex][this.selectedSlide.type] = _.cloneDeep(this.slides[this.currentIndex]);
                    this.initTypeContent(type);
                    this.originSlides[this.currentIndex][type] = _.cloneDeep(this.slides[this.currentIndex]);;
                }
            }

            this.activeBtnOn();
        },
        initTypeContent(type){
            if(type === 'multiple_choice'){
                this.slides[this.currentIndex] = {
                    id: this.slides[this.currentIndex].id,
                    slides_num: this.slides[this.currentIndex].slides_num,
                    type: "multiple_choice",
                    activationAnswer: true,
                    activationTimeLimit: true,
                    activationScore: true,
                    activationFirstCome: true,
                    activationLayout: true,
                    slide_content: {
                        timeout: 1,
                        minScore: 1,
                        maxScore: 1,
                        question: "",
                        resultLayout:"line_graph",
                        answers: [
                            {
                                answer:"",
                                isRightAnswer:false,
                                imgUrl:"",
                                answerBtn: null,
                            },
                            {
                                answer:"",
                                isRightAnswer:false,
                                imgUrl:"",
                                answerBtn: null,
                            },
                            {
                                answer:"",
                                isRightAnswer:false,
                                imgUrl:"",
                                answerBtn: null,
                            }
                        ],
                    },
                }
            }
            else if(type === 'short_answer'){
                this.slides[this.currentIndex] = {
                    id: this.slides[this.currentIndex].id,
                    slides_num: this.slides[this.currentIndex].slides_num,
                    type: "short_answer",
                    activationAnswer: true,
                    activationTimeLimit: true,
                    activationScore: true,
                    activationFirstCome: true,
                    activationLayout: true,
                    slide_content: {
                        timeout: 1,
                        minScore: 1,
                        maxScore: 1,
                        question: "",
                        resultLayout:"line_graph",
                        answer: "",
                    },
                }
            }
            else if(type === 'text'){
                this.slides[this.currentIndex] = {
                    id: this.slides[this.currentIndex].id,
                    slides_num: this.slides[this.currentIndex].slides_num,
                    type: "text",
                    activationAnswer: true,
                    activationTimeLimit: true,
                    activationScore: true,
                    activationFirstCome: true,
                    activationLayout: true,
                    slide_content: {
                        question: "",
                        answer: "",
                    },
                }
            }
            else if(type === 'image'){
                this.slides[this.currentIndex] = {
                    id: this.slides[this.currentIndex].id,
                    slides_num: this.slides[this.currentIndex].slides_num,
                    type: "image",
                    activationAnswer: true,
                    activationTimeLimit: true,
                    activationScore: true,
                    activationFirstCome: true,
                    activationLayout: true,
                    slide_content: {
                        imgUrl: "",
                    },
                }
            }
            else if(type === 'text_image'){
                this.slides[this.currentIndex] = {
                    id: this.slides[this.currentIndex].id,
                    slides_num: this.slides[this.currentIndex].slides_num,
                    type: "text_image",
                    activationAnswer: true,
                    activationTimeLimit: true,
                    activationScore: true,
                    activationFirstCome: true,
                    activationLayout: true,
                    slide_content: {
                        question: "",
                        imgUrl: "",
                        sortType: 0,
                    },
                }
            }

            this.selectedSlide = this.slides[this.currentIndex];
        },
        selectLayoutContent(type){
            //그래프
            if(this.selectedSlide.slide_content.resultLayout !== type){
                this.initLayoutContent(type);
                return true;
            }
        },
        initLayoutContent(type){
            this.slides[this.currentIndex].slide_content.resultLayout = type;
            this.selectedSlide = this.slides[this.currentIndex];

            this.changeState[this.currentIndex] = true;

            //렌더링 강제로 주기
            this.changeState.push('none');
            this.changeState.pop();
        },
        delAnswerItem(idx){
            this.slides[this.currentIndex].slide_content.answers.splice(idx,1);
            this.selectedSlide = this.slides[this.currentIndex];

            this.changeState[this.currentIndex] = true;
            //렌더링 강제로 주기
            this.changeState.push('none');
            this.changeState.pop();
        },
        addAnswerItem(){
            this.slides[this.currentIndex].slide_content.answers.push({
                answer:"",
                isRightAnswer:false,
                imgUrl:""
            });
            this.selectedSlide = this.slides[this.currentIndex];

            this.changeState[this.currentIndex] = true;
            //렌더링 강제로 주기
            this.changeState.push('none');
            this.changeState.pop();
        },
        swapAnswerItem(idx, dir){
            //#dir 0 : UP,   1 : DOWN
            if(dir === 0){
                if(idx <= 0)
                    return

                const tempAnswerItem = this.slides[this.currentIndex].slide_content.answers[idx-1];
                this.slides[this.currentIndex].slide_content.answers[idx-1] = this.slides[this.currentIndex].slide_content.answers[idx];
                this.slides[this.currentIndex].slide_content.answers[idx] = tempAnswerItem;
                this.selectedSlide = this.slides[this.currentIndex];

                this.changeState[this.currentIndex] = true;
                this.$refs._slide_content.forceRerender();
                this.changeState.push('none');
                this.changeState.pop();

            }
            else if(dir === 1){
                if(idx >= this.selectedSlide.slide_content.answers.length-1)
                    return

                const tempAnswerItem = this.slides[this.currentIndex].slide_content.answers[idx+1];
                this.slides[this.currentIndex].slide_content.answers[idx+1] = this.slides[this.currentIndex].slide_content.answers[idx];
                this.slides[this.currentIndex].slide_content.answers[idx] = tempAnswerItem;
                this.selectedSlide = this.slides[this.currentIndex];



                this.changeState[this.currentIndex] = true;
                this.$refs._slide_content.forceRerender();
                this.changeState.push('none');
                this.changeState.pop();
            }
        },
        sendSlide(){
            if(this.selectedSlide.type === 'image' || this.selectedSlide.type === 'text_image' ) {
                if(typeof(this.selectedSlide.slide_content.imgUrl) === 'object'){
                    const formData = new FormData();
                    formData.append('length', '1');
                    formData.append('0', this.selectedSlide.slide_content.imgUrl);

                    axios.post(window.location.pathname + '/' + this.selectedSlide.id + '/image', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }}).then((re) =>{
                            this.slides[this.currentIndex].slide_content.imgUrl = re.data[0];

                            axios.post(window.location.pathname+'/'+this.selectedSlide.id, this.selectedSlide).then(re=>{
                                if(!!re.data){
                                    this.originSlides[this.currentIndex] = [];
                                    this.changeState[this.currentIndex] = false;
                                    //렌더링 강제로 주기
                                    this.changeState.push('none');
                                    this.changeState.pop();
                                }
                            });
                        });
                }
                else{
                    axios.post(window.location.pathname+'/'+this.selectedSlide.id, this.selectedSlide).then(re=>{
                        if(!!re.data){
                            this.originSlides[this.currentIndex] = [];
                            this.changeState[this.currentIndex] = false;
                            //렌더링 강제로 주기
                            this.changeState.push('none');
                            this.changeState.pop();
                        }
                    });
                }

            }
            else if(this.selectedSlide.type === 'multiple_choice'){

              let _check = false;
              let _imgUrls = {};
              let formData = new FormData();
              const test = [];
              formData.append('length', `${this.selectedSlide.slide_content.answers.length}`);
                for(let i=0;i<this.selectedSlide.slide_content.answers.length;i++){
                    if (typeof (this.selectedSlide.slide_content.answers[i].imgUrl) === 'object' && this.selectedSlide.slide_content.answers[i].imgUrl !== null) {
                        _check = true;
                        formData.append(`${i}`, this.selectedSlide.slide_content.answers[i].imgUrl);
                    }
                    else{
                        formData.append(`${i}`, 'none');
                    }
                }
              if(_check){
                axios.post(window.location.pathname + '/' + this.selectedSlide.id + '/image', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }}).then((re) =>{
                        for(let i=0;i<this.selectedSlide.slide_content.answers.length;i++){
                          if(re.data[i] !== ''){
                            this.slides[this.currentIndex].slide_content.answers[i].imgUrl = re.data[i];
                          }
                        }
                        axios.post(window.location.pathname+'/'+this.selectedSlide.id, this.selectedSlide).then(re=>{
                            if(!!re.data){
                                this.originSlides[this.currentIndex] = [];
                                this.changeState[this.currentIndex] = false;
                                //렌더링 강제로 주기
                                this.changeState.push('none');
                                this.changeState.pop();
                            }
                        });
                    });
              }
              else {
                axios.post(window.location.pathname+'/'+this.selectedSlide.id, this.selectedSlide).then(re=>{
                    if(!!re.data){
                        this.originSlides[this.currentIndex] = [];
                        this.changeState[this.currentIndex] = false;
                        //렌더링 강제로 주기
                        this.changeState.push('none');
                        this.changeState.pop();
                    }
                });
              }
            }
            else{
                axios.post(window.location.pathname+'/'+this.selectedSlide.id, this.selectedSlide).then(re=>{
                    if(!!re.data){
                        this.originSlides[this.currentIndex] = [];
                        this.changeState[this.currentIndex] = false;
                        //렌더링 강제로 주기
                        this.changeState.push('none');
                        this.changeState.pop();
                    }
                });
            }


        },
        changeCheckData(e){
            if(JSON.stringify(this.originSlides[this.currentIndex][this.selectedSlide.type]) !== JSON.stringify(this.selectedSlide)){
                this.changeState[this.currentIndex] = true;

                //렌더링 강제로 주기
                this.changeState.push('none');
                this.changeState.pop();
            }
        },
        uploadImage(e) {
            const file = e.target.files;

            const formData = new FormData();
            formData.append('file', file[0]);

            // URL.createObjectURL(
            if(this.selectedSlide.type === 'multiple_choice'){
                const idx = e.target.id.split('_');
                this.slides[this.currentIndex].slide_content.answers[idx[1]].imgUrl = file[0];

                for(let i=0;i<this.selectedSlide.slide_content.answers.length;i++){
                    this.selectedSlide.slide_content.answers[i].answerBtn = false;
                }
            }
            else if(this.selectedSlide.type === 'image' || this.selectedSlide.type === 'text_image' ){
                this.slides[this.currentIndex].slide_content.imgUrl = file[0];
            }
        },
        updateImage(){
            if(!this.activeBtn){
                if(this.selectedSlide.type === 'image' || this.selectedSlide.type === 'text_image' ){
                    const _src = document.getElementById(this.selectedSlide.type+'_'+this.selectedSlide.id);

                    if(_src === null) {
                    }
                    else if(this.selectedSlide.slide_content.imgUrl === null){
                        _src.src = '';
                    }
                    else if(this.selectedSlide.slide_content.imgUrl.length === 0){
                        _src.src = '';
                    }
                    else{
                        if(typeof(this.selectedSlide.slide_content.imgUrl) === 'object'){
                            _src.src = URL.createObjectURL(this.selectedSlide.slide_content.imgUrl);
                        }
                        else{
                            _src.src = window.location.pathname+'/image/'+this.selectedSlide.slide_content.imgUrl;
                        }
                    }

                }
                else if(this.selectedSlide.type === 'multiple_choice'){
                    // <img :id="'multiple_choice_'+selectedSlide.id+'_'+index" style="width: 40px; height: 40px">

                    for(let i=0;i<this.selectedSlide.slide_content.answers.length;i++) {
                        const _src = document.getElementById(this.selectedSlide.type+'_'+this.selectedSlide.id+'_'+i);

                        if(_src === null) {
                        }
                        else if(this.selectedSlide.slide_content.answers[i].imgUrl === null){
                            _src.src = '';
                        }
                        else if (this.selectedSlide.slide_content.answers[i].imgUrl.length === 0) {
                            _src.src = '';
                        }
                        else {
                            if (typeof (this.selectedSlide.slide_content.answers[i].imgUrl) === 'object') {
                                _src.src = URL.createObjectURL(this.selectedSlide.slide_content.answers[i].imgUrl);
                            } else {
                                _src.src = window.location.pathname+'/image/'+this.selectedSlide.slide_content.answers[i].imgUrl;
                            }
                        }
                    }
                }
            }
        },
        activeBtnOn(){
            if(this.selectedSlide.type === 'none'){
                this.activeBtn = true;
            }
            else{
                this.activeBtn = !this.activeBtn;
            }


            this.forceRerender();
        },
        sideBtnBtnOn(){
            if(this.selectedSlide){
                this.sideBtn = !this.sideBtn;
            }
            else{
                this.sideBtn = false;
            }
        },
        selectBtnCheck(){
            if(this.selectedSlide.type === 'none'){
                this.activeBtn = true;
            }
            else{
                this.activeBtn = false;
            }

            this.sideBtn = true;

        },
        selectSortType(type){
            if(this.selectedSlide.slide_content.sortType !== type){
                this.initSortType(type);
                return true;
            }
        },
        initSortType(type){
            this.slides[this.currentIndex].slide_content.sortType = type;
            this.selectedSlide = this.slides[this.currentIndex];

            this.changeState[this.currentIndex] = true;

            //렌더링 강제로 주기
            this.changeState.push('none');
            this.changeState.pop();
        },
        allSendSlides(){
            for(let i=0;i<this.changeState.length;i++){
                if(this.changeState[i]){
                    this.selectedSlide = this.slides[i];
                    this.sendSlide();
                    this.changeState[i] = false;
                }
            }
            //
            if(!(this.currentIndex === -1)){
                this.selectedSlide = this.slides[this.currentIndex];
            }
        },
        backOn(){
            location.href = 'http://www.plushdev.com/lecture/'+this.$props.lectureId;
        },
        slideMove(e){
            // console.log(e.moved.oldIndex);
            // console.log(e.moved.newIndex);
            const tempSlide = _.cloneDeep(this.originSlides[e.moved.oldIndex]);
            this.originSlides[e.moved.oldIndex] = _.cloneDeep(this.originSlides[e.moved.newIndex]);
            this.originSlides[e.moved.newIndex] = _.cloneDeep(tempSlide);

            let slidesIdx = [];
            for(let i=0;i<this.slides.length;i++){
                slidesIdx.push(this.slides[i].id);
            }

            axios.post(window.location.pathname+'/handle/slideMove', {slidesIdx:slidesIdx});
        },
        answerMove(){
            this.changeState[this.currentIndex] = true;

            //렌더링 강제로 주기
            this.changeState.push('none');
            this.changeState.pop();
        },
        selectedAnswer(idx){
            this.selectedSlide.slide_content.answers[idx].answerBtn = !this.selectedSlide.slide_content.answers[idx].answerBtn;
        },
        delAnswerImg(idx){
            this.selectedSlide.slide_content.answers[idx].imgUrl = '';
            this.changeState[this.currentIndex] = true;
        }
    }
}
</script>

<style scoped>



</style>
