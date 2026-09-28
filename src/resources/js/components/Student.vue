<template>
    <div class="slide__wrap" v-bind:class="{full:fullScreen}" :key="componentKey">
        <div class="slide">
            <h2 class="slide__url">{{roomUrl}}</h2>
            <div class="slide__right-top">
                <div class="count-wrap">
                    <div id="my_count" class="count"></div>
                </div>
            </div>
            <div v-if="slide" class="slide__con">
                <div v-if="slide.type === 'multiple_choice' || slide.type === 'short_answer'">
                    <div v-if="stateSlide === 'READY'">
                        <h3 class="tit"><span class="t-primary">{{users.length-1}}명</span> 대기중</h3>
                        <div class="student-list__wrap">
                            <ul class="student-list">
                                <template v-for="(inUser, index) in users">
                                    <li v-if="proId !== inUser.id" class="student-list__item">
                                        <span class="student">{{ inUser.name }}</span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                    <div v-else-if="stateSlide === 'START'">
                        <div v-if="slide.type === 'multiple_choice'">
                            <h3 class="quiz">{{ slide.slide_content.question }}</h3>
                            <ul class="example-list">
                                <li v-for="(answer, index) in slide.slide_content.answers" class="example-list__item">
                                    <label class="checkbox round gray">
<!--                                        <input type="checkbox" />-->
                                        <input type="radio" name="quiz_radio" :disabled="userQuizState" :value=index v-model="userAnswer">
                                    </label>
                                    <div class="con">
                                        <p class="txt">{{ answer.answer }}</p>
                                        <div class="img-wrap"><img :id="'_multiple_choice_'+slide.id+'_'+index" v-if="answer.imgUrl" :src="answer.imgUrl" alt="answer.answer"/></div>
                                    </div>
                                </li>
                            </ul>
                            <button class="btn-md col1 btn-round btn-primary" v-bind:class="{'btn-disable':userQuizState}" @click="sendResult">
                                제출
                            </button>
                            <!--                        <h1>{{ slide.slide_content.question }}</h1>-->
                            <!--                        <label v-if="!!this.slide.activation_time_limit">시간:{{time}}</label>-->
                            <!--                        <div v-for="(answer, index) in slide.slide_content.answers" style="display: flex;justify-content: center;align-content: center;">-->
                            <!--                            <div>{{ answer.answer }}</div><br>-->
                            <!--                            <img :id="'_multiple_choice_'+slide.id+'_'+index" v-if="answer.imgUrl" :src="answer.imgUrl" alt="answer.answer" style="width: 100px; height: 100px;" /><br>-->
                            <!--                            <input type="radio" name="quiz_radio" :value=index v-model="userAnswer">-->
                            <!--                        </div>-->
                            <!--                        <button v-if="!userQuizState" @click="sendResult">제출</button>-->
                        </div>
                        <div v-else-if="slide.type === 'short_answer'">
                            <h3 class="quiz">{{ slide.slide_content.question }}</h3>
                            <textarea class="answer" placeholder="이곳에 의견을 얘기해주세요." rows="6" :disabled="userQuizState" v-model="userAnswer"></textarea>
                            <button class="btn-md col1 btn-round btn-primary" v-bind:class="{'btn-disable':userQuizState}" @click="sendResult">제출</button>

                            <!--                        <h1>{{ slide.slide_content.question }}</h1>-->
                            <!--                        <label v-if="!!this.slide.activation_time_limit">시간:{{time}}</label>-->
                            <!--                        <textarea :disabled="userQuizState" v-model="userAnswer"></textarea> <br>-->
                            <!--                        <button v-if="!userQuizState" @click="sendResult">제출</button>-->
                        </div>
                    </div>
                    <div v-else-if="stateSlide === 'END'">
                        <template v-if="slide.activation_answer && slide.activation_layout && slide.activation_score">
                            <template v-if="!leaderState">
                                <div class="result">
                                  <div>
                                    <svg id="graph"></svg>
                                  </div>
                                </div>
                            </template>
                            <template v-else>
                                <h3 class="quiz">Leader Board <span class="tit"><span class="t-primary"><span class="leader-board-cnt">10</span>명</span> <span class="t-gray">참가</span></span></h3>
                                <div class="result">
                                    <div>
                                        <svg id="graph"></svg>
                                    </div>
                                </div>
                            </template>
                        </template>
                        <template v-else>
                            퀴즈가 종료되었습니다.
                        </template>
                    </div>
                </div>
                <div v-else-if="slide.type === 'text'">
                    <h3 class="quiz">{{ slide.slide_content.question }}</h3>
                    <div class="txt">
                        {{ slide.slide_content.answer }}
                    </div>
                    <!--                <h1>{{ slide.slide_content.question }}</h1>-->
                    <!--                <h1>{{ slide.slide_content.answer }}</h1>-->
                </div>
                <div v-else-if="slide.type === 'image'" class="img-wrap" v-bind:class="{'h-100':fullScreen}">
                    <img class="wh-100" :id="'_image_'+slide.id" v-if="slide.slide_content.imgUrl" :src="slide.slide_content.imgUrl"/>
                </div>
                <div v-else-if="slide.type === 'text_image'">
                    <div v-if="slide.slide_content.sortType === 0" class="multi-wrap">
                        <div class="img">
                            <img :id="'_text_image_'+slide.id" v-if="slide.slide_content.imgUrl":src="slide.slide_content.imgUrl"/>
                        </div>
                        <p class="txt">{{ slide.slide_content.question }}</p>
                    </div>
                    <div v-if="slide.slide_content.sortType === 1" class="multi-wrap">
                        <p class="txt">{{ slide.slide_content.question }}</p>
                        <div class="img">
                            <img :id="'_text_image_'+slide.id" v-if="slide.slide_content.imgUrl":src="slide.slide_content.imgUrl"/>
                        </div>
                    </div>
                    <div v-if="slide.slide_content.sortType === 2" class="multi-wrap left">
                        <div class="img">
                            <img :id="'_text_image_'+slide.id" v-if="slide.slide_content.imgUrl":src="slide.slide_content.imgUrl"/>
                        </div>
                        <p class="txt">{{ slide.slide_content.question }}</p>
                    </div>
                    <div v-if="slide.slide_content.sortType === 3" class="multi-wrap right">
                        <p class="txt">{{ slide.slide_content.question }}</p>
                        <div class="img">
                            <img :id="'_text_image_'+slide.id" v-if="slide.slide_content.imgUrl":src="slide.slide_content.imgUrl"/>
                        </div>
                    </div>
                </div>
                <div v-else-if="slide.type === 'none'">
                    <h1>none 페이지</h1>
                </div>
            </div>

            <div class="slide__left-bottom">
                <button class="menu-btn" @click="slideMenuBtnOn"></button>
                <ul class="slide-menu" v-bind:class="{dn:!slideMenu}">
                    <li class="slide-menu__item">프레젠테이션 중단</li>
                    <li v-if="!fullScreen" class="slide-menu__item" @click="fullScreenBtnOn">풀 스크린</li>
                    <li v-else class="slide-menu__item" @click="fullScreenBtnOn">일반 스크린</li>
                    <li class="slide-menu__item">내 강의실</li>
                </ul>
            </div>

            <div class="slide__bottom">
                <ul class="express-list">
                    <li class="express-list__item">
                        <button class="express-1" @click="sendGoods(0)" title="잘 모르겠어요"></button>
                        <div class="txt">잘 모르겠어요</div>
                    </li>
                    <li class="express-list__item">
                        <button class="express-2" @click="sendGoods(1)" title="어려워요"></button>
                        <div class="txt">어려워요</div>
                    </li>
                    <li class="express-list__item">
                        <button class="express-3" @click="sendGoods(3)" title="도움이 됐어요"></button>
                        <div class="txt">이해했어요</div>
                    </li>
                    <li class="express-list__item">
                        <button class="express-4" @click="sendGoods(2)" title="이해했어요"></button>
                        <div class="txt">도움이 됐어요</div>
                    </li>
                </ul>
            </div>
            <div class="slide__right-bottom">
                <button class="student-count" @click="studentListMenuBtnOn">{{users.length-1}}</button>
                <ul class="student-list" v-bind:class="{dn:!studentListMenu}">
                    <template v-for="(inUser, index) in users">
                        <li v-if="proId !== inUser.id" class="student-list__item">
                            <span class="student">{{ inUser.name }}</span>
                        </li>
                    </template>
                </ul>
                <button class="cam-btn"></button>
                <button class="chat-btn" @click="chatMenuBtnOn"></button>
                <div class="chat-wrap" v-bind:class="{dn:!chatMenu}">
                    <li v-for="(message, index) in messages">
                        <strong>{{message.user.name}}</strong>
                        <span class="student">{{message.message}}</span>
                    </li>
                    <input
                        @keyup.enter="sendMessage"
                        v-model="newMessage"
                        type="text"
                        name="message"
                        placeholder="...">
                </div>
            </div>

            <!--            <label>학생수:{{users.length-1}}</label>-->

            <!--            goodlistinfo-->

            <!--            <button @click="sendGoods(0)" title="잘 모르겠어요">잘 모르겠어요</button>-->
            <!--            <button @click="sendGoods(1)" title="어려워요">어려워요</button>-->
            <!--            <button @click="sendGoods(2)" title="도움이 됐어요">도움이 됐어요</button>-->
            <!--            <button @click="sendGoods(3)" title="이해했어요">이해했어요</button>-->

            <!--            <br>-->
            <!--            <br>-->
            <!--            <div>-->
            <!--                <div>-->
            <!--                    <ul style="height: 300px; overflow-y: scroll" v-chat-scroll>-->
            <!--                        <li v-for="(message, index) in messages">-->
            <!--                            <strong>{{message.user.name}}</strong>-->
            <!--                            {{message.message}}-->
            <!--                        </li>-->
            <!--                    </ul>-->
            <!--                </div>-->
            <!--                <div>-->
            <!--                    <input-->
            <!--                        @keyup.enter="sendMessage"-->
            <!--                        v-model="newMessage"-->
            <!--                        type="text"-->
            <!--                        name="message"-->
            <!--                        placeholder="...">-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div>-->
            <!--                <ul>-->
            <!--                    <li v-for="(user, index) in users">-->
            <!--                        {{user.name}}-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--            </div>-->
        </div>
    </div>
</template>


<script>
export default {
    props: {
        roomId : Number,
        pagination : Number,
        proId : Number,
        proUrl : String,
        userId : Number,
        checkRight : String,
        checkWrong : String,
        checkWrongDisable : String,
    },
    data() {
        return {
            users: [],
            changeState: [],
            componentKey: 0,
            slide: null,
            stateSlide: null,
            userQuizState: null,
            userAnswer: null,
            isCheckPro: null,
            time: null,
            messages: [],
            newMessage: '',
            slideMenu: false,
            chatMenu: false,
            fullScreen: false,
            studentListMenu: false,
            docV: null,
            roomUrl: '',
            leaderState: false,
        }
    },
    created() {     //렌더링이 되기전
        Echo.join('classesroom_'+this.$props.roomId)
            .here(user => {
                this.users = user;
                this.checkPro(user);
                this.countMembers();
            })
            .joining(user => {
                this.users.push(user);
            })
            .leaving(user => {
                this.users = this.users.filter(u => u.id !== user.id);
                this.checkPro(user);
            })
            .listenForWhisper('changeSlide', (_data)=>{
                this.changeSlide(_data.idx);
            })
            .listenForWhisper('stateQuiz', (_data)=>{
                this.stateSlide = _data.stateQuiz;

                if(_data.stateQuiz === 'END'){
                    this.stopQuizTimer();
                    //test graph
                    // this.handleDashBoard();
                }
            })
            .listenForWhisper('quizTimer', (_data)=>{
                this.time = _data.proTimer;

                this.startQuizTimer();
            })
            .listenForWhisper('quizTimer_'+this.$props.userId, (_data)=>{
                this.time = _data.proTimer;

                this.startQuizTimer();
            })
            .listenForWhisper('leaderOn', (_data)=>{
                this.leaderState = _data.state;
            })
            .listen('classesRoomEvent', (_data)=>{
                this.messages.push(_data.message);
            })


        this.init();
    },
    mounted() {
      //렌더링이 되고 나서
        this.$nextTick(() => {
            // 모든 화면이 렌더링된 후 실행
            this.roomUrl = this.$props.proUrl;
            const href = window.location.href.split('/');
            this.roomUrl = href[2] + '/room/' + this.$props.proUrl;

            function radialProgress($obj, options) {
                var defaults = {
                    "inline": true,
                    "font-size": 40,
                    "font-family": "Helvetica, Arial, sans-serif",
                    "text-color": null,
                    "lines": 1,
                    "line": 0,
                    "symbol": "",
                    "margin": 0,
                    "color": "rgb(55,123,181)",
                    "background": "rgba(0,0,0,0.1)",
                    "size": $obj.outerWidth(),
                    "fill": "5px",
                    "range": [0, 100]
                };
                this.options = $.extend(defaults, options);

                this.first_rot_base = -135;
                this.second_rot_base = -315;

                this.options['size'] = parseInt(this.options['size'], 10);
                this.options['fill'] = parseInt(this.options['fill'], 10);
                this.options['font-size'] = parseInt(this.options['font-size'], 10);
                this.options['margin'] = Math.max(0, parseInt(this.options['margin'], 10));
                this.options['text-color'] = this.options['text-color'] || this.options['color'];

                $obj.css({
                    "position": "relative",
                    "width": this.options['size'],
                    "height": this.options['size'],
                    "display": this.options['inline'] ? "inline-block" : "block"
                });

                this.$radialBackground = $("<div>").appendTo($obj).css({
                    "box-sizing": "border-box",
                    "-moz-box-sizing": "border-box",
                    "-webkit-box-sizing": "border-box",
                    "position": "absolute",
                    "top": this.options['margin'],
                    "left": this.options['margin'],
                    "width": this.options['size'] - this.options['margin'] * 2,
                    "height": this.options['size'] - this.options['margin'] * 2,
                    "border": this.options['fill'] + "px solid " + this.options['background'],
                    "border-radius": Math.ceil(this.options['size'] / 2) + "px",
                });

                this.$radialFirstHalfMask = $("<div>").appendTo($obj).css({
                    "position": "absolute",
                    "top": this.options['margin'],
                    "right": this.options['margin'],
                    "width": Math.round(this.options['size'] / 2) - this.options['margin'],
                    "height": this.options['size'] - this.options['margin'] * 2,
                    "overflow": "hidden"
                });

                this.$radialSecondHalfMask = $("<div>").appendTo($obj).css({
                    "position": "absolute",
                    "top": this.options['margin'],
                    "left": this.options['margin'],
                    "width": Math.round(this.options['size'] / 2) - this.options['margin'],
                    "height": this.options['size'] - this.options['margin'] * 2,
                    "overflow": "hidden"
                });

                this.$radialFirstHalf = $("<div>").appendTo(this.$radialFirstHalfMask).css({
                    "box-sizing": "border-box",
                    "-moz-box-sizing": "border-box",
                    "-webkit-box-sizing": "border-box",
                    "position": "absolute",
                    "top": "0px",
                    "border-width": this.options['fill'],
                    "border-style": "solid",
                    "border-color": this.options['color'] + " " + this.options['color'] + " transparent transparent",
                    "width": "200%",
                    "height": "100%",
                    "border-radius": "50%",
                    "left": "-100%",
                    "transform": "rotate(" + this.first_rot_base + "deg)"
                });

                this.$radialSecondHalf = $("<div>").appendTo(this.$radialSecondHalfMask).css({
                    "box-sizing": "border-box",
                    "-moz-box-sizing": "border-box",
                    "-webkit-box-sizing": "border-box",
                    "position": "absolute",
                    "top": "0px",
                    "border-width": this.options['fill'],
                    "border-style": "solid",
                    "border-color": this.options['color'] + " " + this.options['color'] + " transparent transparent",
                    "width": "200%",
                    "height": "100%",
                    "border-radius": "50%",
                    "left": "0px",
                    "transform": "rotate(" + this.second_rot_base + "deg)"
                });

                if (this.options['text-color']) {
                    this.$radialLabel = $("<div>").appendTo($obj).css({
                        "position": "absolute",
                        "font-size": this.options['font-size'] + "px",
                        "font-family": this.options['font-family'],
                        "color": this.options['text-color'],
                        "left": "50%",
                        "top": "50%",
                        "transform": "translate(-50%, -50%)"
                    });
                }

                this.perc = 0;
                this.queue = [];
            }

            radialProgress.prototype.toPerc = function(options) {
                var self = this,
                    offset = options['offset'] || 0,
                    interval_delay = 10,
                    time = options['time'] || 1000,
                    targetPerc = Math.max(0, Math.min(100, (options['perc'] - self.options['range'][0]) / (self.options['range'][1] - self.options['range'][0]) * 100)),
                    diffPerc = targetPerc - this.perc,
                    direction = diffPerc / Math.abs(diffPerc),
                    step = diffPerc / (time / interval_delay);
                if (!this.animation) {
                    this.animation = setInterval(function() {
                        if ((direction > 0 && self.perc >= targetPerc) || (direction < 0 && self.perc <= targetPerc)) {
                            window.clearInterval(self.animation);
                            self.animation = null;
                            var next = self.queue.shift();
                            if (next) self.toPerc(next);
                            return;
                        }
                        self.perc += step;
                        var first_rot = self.first_rot_base;
                        var second_rot = self.second_rot_base;
                        if (self.perc < 50) {
                            first_rot = self.first_rot_base + (self.perc / 50) * 180;
                            second_rot = self.second_rot_base;
                        } else {
                            first_rot = self.first_rot_base + 1 * 180;
                            second_rot = self.second_rot_base + ((self.perc - 50) / 50) * 180;
                        }
                        self.$radialFirstHalf.css({
                            "transform": "rotate(" + first_rot + "deg)"
                        });
                        self.$radialSecondHalf.css({
                            "transform": "rotate(" + second_rot + "deg)"
                        });
                        if (self.$radialLabel) {
                            var value = targetPerc ? self.perc/targetPerc * (targetPerc - offset) : 0;
                            value = self.options['range'][0] + value / 100 * (self.options['range'][1] - self.options['range'][0]);
                            var text = Math.round(value + self.options['symbol']);
                            for (var ti = 0; ti < self.options['line']; ti++) text = "&nbsp;<br>" + text;
                            for (var ti = self.options['lines'] - (self.options['line'] + 1); ti > 0; ti--) text = text + "<br>&nbsp;";
                            self.$radialLabel.html(text);
                        }
                    }, interval_delay);
                } else {
                    this.queue.push(options);
                }
            };

            $.fn.radialProgress = function(func, options) {
                if (func === "init") {
                    $(this).data("__radialProgress", new radialProgress($(this), options));
                } else if ($(this).data("__radialProgress")) {
                    if (func === "to") $(this).data("__radialProgress").toPerc(options)
                }
                return this;
            };

            $.fn.radialPieChart = function(func, options) {
                if (func === "init") {
                    var sum = options['data'].reduce(function(a, item) {
                        return a + item.perc;
                    }, 0);
                    for (var i = 0; i < options['data'].length; i++) {
                        $(this).data("__pieChartSegment" + i, new radialProgress($(this), $.extend(options, options['data'][i], {'lines': options['data'].length, 'line': i })));
                        $(this).data("__pieChartSegment" + i).toPerc({'perc': sum, 'offset': sum - options['data'][i].perc});
                        sum -= options['data'][i].perc;
                    }
                }
                return this;
            };

            $.fn.radialMultiProgress = function(func, options) {
                if (func === "init") {
                    var space = options['space'] || 2,
                        segmentFill = Math.floor(options['fill'] / options['data'].length) - space,
                        margin = 0;
                    for (var i = 0; i < options['data'].length; i++) {
                        $(this).data("__multiProgress" + i, new radialProgress($(this), $.extend(options, options['data'][i], {'fill': segmentFill, 'margin': margin, 'lines': options['data'].length, 'line': i })));
                        margin += segmentFill + space;
                    }
                }
                else if (options['index'] !== undefined) {
                    if ($(this).data("__multiProgress" + options['index'])) {
                        if (func === "to") $(this).data("__multiProgress" + options['index']).toPerc(options);
                    }
                }
                else if (options['list'] !== undefined) {
                    for (var i = 0; i < options['list'].length; i++) {
                        if (func === "to") $(this).data("__multiProgress" + options['list'][i]['index']).toPerc(options['list'][i]);
                    }
                }
                return this;
            };
        })
    },
    beforeUpdate() {    //data 값이 바뀌기는 전 순간에 호출
    },
    updated(){          //data 값이 바뀌고나서 호출
        this.updateImage();
        if(this.stateSlide === 'END'){
            if(!this.leaderState){
                axios.get(window.location.pathname + '/api/graphUpdate/'+ this.slide.id).then(re=>{
                    this.handleBarChart(re.data);
                })
            }
            else{
                axios.post(window.location.pathname + '/api/leaderUpdate/'+ this.slide.id, {state:0}).then(re=>{
                    this.handleDashBoard(re.data);
                })
            }
        }
    },
    methods: {
        init(){
            axios.get(window.location.pathname + '/api/fetchSlide/'+ this.$props.pagination).then(re=>{
                this.slide = re.data.slide;
                this.stateSlide = re.data.status;
                this.userQuizState = re.data.attempted;
                this.userAnswer = null;

                console.log(this.stateSlide);

                if(this.slide.type === 'multiple_choice' || this.slide.type === 'short_answer')
                {
                    this.time = this.slide.slide_content.timeout;
                    // if(this.stateSlide === 'END'){
                    //     this.handleDashBoard();
                    //     // this.forceRerender();
                    // }
                }
                //////////////////////
                // this.userQuizState = true;
            })

            axios.get(window.location.pathname + '/api/sendMemberCount');

            this.fetchMessages();
            this.docV = document.documentElement;
        },
        changeSlide(idx){
            axios.get(window.location.pathname + '/api/fetchSlide/'+ idx).then(re=>{
                this.slide = re.data.slide;
                this.stateSlide = re.data.status;
                this.userQuizState = re.data.attempted;
                this.userAnswer = null;

                this.leaderState = false;

                // this.userQuizState = true;

                if(this.slide.type === 'multiple_choice' || this.slide.type === 'short_answer'){
                    this.time = this.slide.slide_content.timeout;
                    if(this.stateSlide === 'END'){
                        // this.handleDashBoard();
                        // this.forceRerender();
                    }
                }

            })
        },
        forceRerender() {
            this.componentKey += 1;
        },
        updateImage(){
            if(this.slide) {
                if (this.slide.type === 'image' || this.slide.type === 'text_image') {
                    const _src = document.getElementById('_' + this.slide.type + '_' + this.slide.id);
                    if (_src) {
                        _src.src = window.location.pathname + '/api/downloadImage/' + this.slide.slide_content.imgUrl;
                    }
                } else if (this.slide.type === 'multiple_choice') {
                    for (let i = 0; i < this.slide.slide_content.answers.length; i++) {
                        const _src = document.getElementById('_' + this.slide.type + '_' + this.slide.id + '_' + i);
                        if (_src && this.slide.slide_content.answers[i].imgUrl) {
                            _src.src = window.location.pathname + '/api/downloadImage/' + this.slide.slide_content.answers[i].imgUrl;
                        }
                    }
                }
            }
        },
        sendResult(){
            // this.userQuizState = false;
            axios.post(window.location.pathname + '/api/sendAnswer/'+ this.slide.id, {user_answer:this.userAnswer}).then(re=>{
                this.init();
                // if(!!re.data){
                //     this.userQuizState = true;
                //     this.forceRerender();
                // }
            })
        },
        checkPro(user){
            if(this.stateSlide === 'START'){
                if(!user.length){
                    //퇴장한 유저를 검사
                    if(user.id === this.$props.proId){
                        this.stateSlide = 'READY';
                        this.stopQuizTimer();
                    }
                }
                else{
                    //퀴즈 시작중에
                    //기존 유저들중 교수가 없으면 중지 처리
                    for(let i=0;i<user.length;i++){
                        if(user[i].id === this.$props.proId){
                            return;
                        }
                    }
                    this.stateSlide = 'READY';
                }
            }
        },
        sendGoods(flagType){
            axios.post(window.location.pathname + '/api/sendReaction/' + this.slide.id, {flagType: flagType}).then(re=>{
                if(!!re.data){
                    this.stateGood = true;
                    Echo.join('classesroom_'+this.$props.roomId)
                        .whisper('sendGood', {flagType: flagType});
                }
            });

            // Echo.join('classesroom_'+this.$props.roomId)
            //     .whisper('sendGood', {flagType: flagType});
        },
        fetchMessages(){
            axios.get(window.location.pathname + '/api/fetchMessages').then(re=>{
                this.messages = re.data;
            })
        },
        sendMessage(){
            axios.post(window.location.pathname + '/api/sendMessage', {message: this.newMessage}).then(re=>{
                // console.log(re.data);
                if(re.data){
                    this.messages.push({
                        user: re.data,
                        message: this.newMessage
                    })
                }
                this.newMessage = '';
            })
        },
        countMembers() {
            axios.post(window.location.pathname + '/api/sendMemberCount', {count_members: this.users.length});
        },
        slideMenuBtnOn(){
            this.slideMenu = !this.slideMenu;
        },
        studentListMenuBtnOn(){
            if(this.chatMenu){
                this.chatMenu = false;
            }
            this.studentListMenu = !this.studentListMenu;
        },
        chatMenuBtnOn(){
            if(this.studentListMenu){
                this.studentListMenu = false;
            }
            this.chatMenu = !this.chatMenu;
        },
        fullScreenBtnOn(){
            // this.fullScreen = !this.fullScreen;

            if (this.fullScreen === false) {
                if (this.docV.requestFullscreen)
                    this.docV.requestFullscreen();
                else if (this.docV.webkitRequestFullscreen) // Chrome, Safari (webkit)
                    this.docV.webkitRequestFullscreen();
                else if (this.docV.mozRequestFullScreen) // Firefox
                    this.docV.mozRequestFullScreen();
                else if (this.docV.msRequestFullscreen) // IE or Edge
                    this.docV.msRequestFullscreen();
                else
                    return false;

                document.getElementById('slid_header').style.display = 'none';
                document.getElementById('slid_footer').style.display = 'none';
                this.fullScreen = !this.fullScreen;
                // this.screenMode = !this.screenMode;
            }
            else {
                if (document.exitFullscreen)
                    document.exitFullscreen();
                else if (document.webkitExitFullscreen) // Chrome, Safari (webkit)
                    document.webkitExitFullscreen();
                else if (document.mozCancelFullScreen) // Firefox
                    document.mozCancelFullScreen();
                else if (document.msExitFullscreen) // IE or Edge
                    document.msExitFullscreen();
                else
                    return false;

                document.getElementById('slid_header').style.display = '';
                document.getElementById('slid_footer').style.display = '';
                this.fullScreen = !this.fullScreen;
                // this.screenMode = !this.screenMode;
            }
            this.slideMenuBtnOn();
        },
        startQuizTimer(){
            const _time = parseInt(this.time);
            $('#my_count').addClass('count');
            $('#my_count').css({
                'position': 'relative',
                'width': '100px',
                'height': '100px',
                'display': 'inline-block'
            });

            $(".count").radialProgress("init",
                {
                    'size': 100,
                    'fill': 10,
                    "range": [_time, 0],
                    "font-size": 50,
                    "color":"#f76282",
                    "background":"#fff",
                    "text-color":"#fff",
                }).radialProgress("to", {'perc': 0,'time': parseInt(this.time)*1000});
        },
        getTest(){
            axios.post(window.location.pathname + '/api/leaderUpdate/'+ this.slide.id, {state:0}).then(re=>{
                // this.messages = re.data;
            })
        },
        stopQuizTimer(){
            $('#my_count').empty();
            $('#my_count').removeClass('count');
            $('#my_count').removeAttr('style');
        },
          handleDashBoard (data) {

            if (!data) {
              return;
            }
            /**
             *
             *  data format
             *  type: array[object] (php ? array[array])
             *
             *  array [
             *      object {
             *          name: string('title')
             *          value: integer('count of data')
             *          image: uri('link of image') ? if not exist -> null
             *          isRightAnswer: boolean('isRightAnswer')
             *          selectedAnswer: boolean('selectedAnswer')
             *      },
             *      {}
             *  ]
             */

            //remove following test data set when it use
            // let data = [
            //       {name:'TEST 1', value:40, rank:1, additionalScore:20, own: false},
            //       {name:'TEST 2', value:40, rank:2, additionalScore:20, own: false},
            //       {name:'TEST 3', value:30, rank:3, additionalScore:15, own: false},
            //       {name:'TEST 4', value:30, rank:4, additionalScore:15, own: false},
            //       {name:'TEST 5', value:20, rank:5, additionalScore:10, own: false},
            //       {name:'TEST 6', value:20, rank:6, additionalScore:10, own: false},
            //       {name:'TEST 7', value:10 , rank:7, additionalScore:5, own: false},
            //       {name:'TEST 8', value:10 , rank:8, additionalScore:5, own: false},
            //       {name:'TEST 9', value:10 , rank:9, additionalScore:5, own: false},
            //       {name:'TEST 10', value:10 , rank:10, additionalScore:5, own: false},
            //       {},
            //       {name:'TEST 10', value:10 , rank:10, additionalScore:5, own: false},
            //     ];
            //
            // // console.log(this.page[1]);
            // if (this.page[0] == null) {
            //   data = [
            //     {name:'감나무', value:20, rank:1, additionalScore:20, own: false},
            //     {name:'가나다', value:20, rank:2, additionalScore:20, own: false},
            //     {name:'가나다라', value:15, rank:3, additionalScore:15, own: false},
            //     {name:'가나다라마', value:15, rank:4, additionalScore:15, own: false},
            //     {name:'가나다라마바사아자차', value:10, rank:5, additionalScore:10, own: false},
            //     {name:'AAAAAAAAAAAAAAAA', value:10, rank:6, additionalScore:10, own: false},
            //     {name:'TEST 7', value:5 , rank:7, additionalScore:5, own: false},
            //     {name:'TEST 8', value:5 , rank:8, additionalScore:5, own: false},
            //     {name:'TEST 9', value:5 , rank:9, additionalScore:5, own: false},
            //     {name:'TEST 10', value:5 , rank:10, additionalScore:5, own: false},
            //     {},
            //     {name:'이게 나임', value:2 , rank:36, additionalScore:2, own: true},
            //   ];
            // }

            // let stringByteLength = (function(s,b,i,c){
            //   for(b=i=0;c=s.charCodeAt(i++);b+=c>>11?3:c>>7?2:1);
            //   return b
            // })('아무의미 없는 answkduf');

            // console.log(stringByteLength)

            data.forEach((d) => {
              if (d.hasOwnProperty('name')) {
                if (d.name.length > 7) {
                  d.name = d.name.substr(0, 6) + '...';
                }
              }
            })


            const colorSet = [
              '#FF6699',
              '#Ff9966',
              '#ffcc66',
              '#66cccc',
              '#6699cc',
              '#666699',
              '#9966cc',
              '#666666',
              '#666666',
              '#666666',
              '#666666',
            ]

            let margin = ({top: 30, right: 100, bottom: 10, left: 120})
            let barHeight = 40
            let height = Math.ceil((data.length + 0.1) * barHeight) + margin.top + margin.bottom
            let width = 1000

            let yAxis = g => g
                .attr("transform", `translate(${margin.left},0)`)
                .attr("fill", `#666666`)
                .attr("stroke", `#666666`)
                .attr("stroke-width", `0.4`)
                .call(d3.axisLeft(y).tickFormat(i => data[i].name).tickSizeOuter(0)).attr('font-size', '0.9rem')

            let xAxis = g => g
                .attr("transform", `translate(0,${margin.top})`)
                .call(d3.axisTop(x).ticks(width / 80, data.format))
                .call(g => g.select(".domain").remove())

            let y = d3.scaleBand()
                .domain(d3.range(data.length))
                .rangeRound([margin.top, height - margin.bottom])
                .padding(0.1)

            let x = d3.scaleLinear()
                .domain([0, d3.max(data, d => d.value)])
                .range([margin.left + 20, width - margin.right])

            let format = x.tickFormat(20, data.format)

            const clear = d3.select("svg").selectAll('*').remove();

            const svg = d3.select("svg")
                .attr("viewBox", [0, 0, width, height]);

            // svg.;

            let myRank = -1;
            let blankRank = -1;
            for (let iter = 0;iter < data.length;iter++) {
              if (!data[iter].hasOwnProperty('own')) {
                blankRank = iter;
              }
              else {
                if (data[iter].own) {
                  myRank = iter;
                }
              }
            }
            if (blankRank != -1) {
              svg.append('circle').attr('cx', margin.left + 13).attr('cy', y(blankRank) + y.bandwidth() / 2 - 10).attr('r', 1).attr('stroke', colorSet[10]).attr('stroke-width', '1');
              svg.append('circle').attr('cx', margin.left + 13).attr('cy', y(blankRank) + y.bandwidth() / 2).attr('r', 1).attr('stroke', colorSet[10]).attr('stroke-width', '1');
              svg.append('circle').attr('cx', margin.left + 13).attr('cy', y(blankRank) + y.bandwidth() / 2 + 10).attr('r', 1).attr('stroke', colorSet[10]).attr('stroke-width', '1');
            }
            if (myRank != -1) {
              svg.append('path').attr('fill', '#f3f3f4').attr('d', () => {
                    let _x = 4;
                    let _width = width - _x * 2;
                    let _height = 30;
                    let _y = y(myRank) + 2.5 + _height / 2;
                    let _radius = 15;


                    return "M" + _x + "," + _y
                        + "a" + _radius + "," + _radius + " 0 0 1 " + _radius + "," + -_radius
                        + "h" + (_width - _radius * 2)
                        + "a" + _radius + "," + _radius + " 0 0 1 " + _radius + "," + _radius
                        + "v" + (_height - _radius * 2)
                        + "a" + _radius + "," + _radius + " 0 0 1 " + -_radius + "," + _radius
                        + "h" + (_radius * 2 - _width)
                        + "a" + _radius + "," + _radius + " 0 0 1 " + -_radius + "," + -_radius
                        + "z";
                  }
              );
            }

            function rightRoundedRect(x, y, width, height, radius) {
              return "M" + x + "," + y
                  + "h" + (width - radius)
                  + "a" + radius + "," + radius + " 0 0 1 " + radius + "," + radius
                  + "v" + (height - radius * 2)
                  + "a" + radius + "," + radius + " 0 0 1 " + -radius + "," + radius
                  + "h" + (radius - width)
                  + "z";
            }

            svg.append('g')
                .selectAll('path').data(data).enter().append('path')
                .attr('fill', (d, i) => {
                  if (i < 10) {
                    return colorSet[i];
                  }
                  else {
                    return colorSet[10];
                  }

                })
                .attr("d", (d, i) => {
                  return d.hasOwnProperty('value') ? rightRoundedRect(x(0), y(i) + y.bandwidth() / 4, x(d.value) - x(0), y.bandwidth() / 2, 8) : '';
                })
            ;

            svg.append("g")
                // .attr("stroke", "white")
                // .attr("stroke-width", "0.7")
                .attr("text-anchor", "end")
                .attr("font-family", "sans-serif")
                .attr("font-size", 12)
                .selectAll("text")
                .data(data)
                .join("text")
                .attr("x", d => d.hasOwnProperty('value') ? x(d.value) : 0)
                .attr("y", (d, i) => y(i) + y.bandwidth() / 2)
                .attr("dy", "0.35em")
                .attr("dx", -4)
                .attr("fill", 'white')
                .attr("stroke", 'white')
                .attr("stroke-width", '0.5')
                .text(d => d.hasOwnProperty('value') ? d.value+'점' : '')
                .call(text => text.filter(d => x(d.value) - x(0) < 20) // short bars
                    .attr("dx", +4)
                    .attr("fill", "white")
                    .attr("text-anchor", "start")
                );

            let _i = 0;

            svg.append("g")
                // .attr("stroke", colorSet[_i++])
                // .attr("stroke-width", "0.7")
                .attr("text-anchor", "start")
                .attr("font-family", "sans-serif")
                .attr("font-size", 12)
                .selectAll("text")
                .data(data)
                .join("text")
                .attr("x", d => d.hasOwnProperty('value') ? x(d.value) + 10 : 0)
                .attr("y", (d, i) => y(i) + y.bandwidth() / 2)
                .attr("dy", "0.35em")
                .attr("dx", -4)
                .attr("stroke", () => _i < 10 ? colorSet[_i++] : colorSet[10])
                .text(d => d.hasOwnProperty('additionalScore') ? `+${d.additionalScore}` : '')
                .call(text => text.filter(d => d.hasOwnProperty('value') ? x(d.value) - x(0) < 20 : '') // short bars
                    // .attr("fill", colorSet[_i++])
                    .attr("text-anchor", "start"));

            svg.append("g")
                .attr("fill", "white")
                // .attr("stroke-width", "0.7")
                .selectAll("circle")
                .data(data)
                .join('circle')
                // .attr("x", d => margin.left + 5)
                // .attr("y", (d, i) => y(i) + y.bandwidth() / 2)
                .attr('cx', d => {
                  return margin.left + 13;
                })
                .attr('cy', (d, i) => y(i) + y.bandwidth() / 2)
                .attr('r', (d) => {
                  if (d.hasOwnProperty('value')) {
                    return 12;
                  }
                })
                .attr('stroke', (d, i) => {
                  return i < 10 ? colorSet[i] : colorSet[10];
                })
                .attr('stroke-width', (d, i) => {
                  return d.hasOwnProperty('value') ? '2' : '0';
                })




            svg.append("g")
                .attr("stroke", "black")
                .attr("stroke-width", "0.4")
                .attr("text-anchor", "middle")
                .attr("font-family", "sans-serif")
                .attr("font-size", 12)
                .selectAll("text")
                .data(data)
                .join("text")
                .attr("x", d => margin.left + 17)
                .attr("y", (d, i) => y(i) + y.bandwidth() / 2)
                .attr("dy", "0.35em")
                .attr("dx", -4)
                .text((d, i) => d.hasOwnProperty('rank') ? d.rank : '')
                .call(text => text.filter(d => d.hasOwnProperty('value') ? x(d.value) - x(0) < 20 : '') // short bars
                    .attr("fill", "black")
                    .attr("text-anchor", "middle"));

            // svg.append("g")
            //     .call(xAxis);


            svg.append("g")
                .call(yAxis);

            document.querySelector('.domain').remove();
          },
        handleBarChart(data) {
        /**
         *
         *  data format
         *  type: array[object] (php ? array[array])
         *
         *  array[
         *      object {
         *          name: string('title')
         *          value: integer('count of data')
         *          image: uri('link of image') ? if not exist -> null
         *          isRightAnswer: boolean('isRightAnswer')
         *          selectedAnswer: boolean('selectedAnswer')
         *      }
         *  ]
         */

        //remove following test data set when it use
        // console.log(data);

        // const
        //     data = [
        //       {name:'그들은 어디에 있나요?', value:69, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-54-5fba7f4ac7faf.jpeg', isRightAnswer: false, selectedAnswer: false },
        //       {name:'그들은 어디에 있나요?', value:42, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-55-5fba7f5567f37.jpeg', isRightAnswer: false, selectedAnswer: false },
        //       {name:'C', value:29, image:null, isRightAnswer: false, selectedAnswer: false },
        //       {name:'D', value:39, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-54-5fba7f4ac7faf.jpeg', isRightAnswer: false, selectedAnswer: false },
        //       // {name:'E', value:29, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-55-5fba7f5567f37.jpeg', isRightAnswer: true, selectedAnswer: false },
        //       // {name:'F', value:19, image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-78-5fbb4fce6f529.jpeg', isRightAnswer: false, selectedAnswer: false },
        //       // {name:'G', value:9 , image:'http://www.plushdev.com:8000/room/12eqswe/api/downloadImage/1-44-79-5fbb4fd39c2d9.jpeg', isRightAnswer: false, selectedAnswer: false },
        //     ];

        let margin = ({top: 50, right: 0, bottom: 130, left: 0})
        let height = 500
        let width = 1000
        let color = "steelblue"

        let y = d3.scaleLinear()
            .domain([0, d3.max(data, d => d.value)]).nice()
            .range([height - margin.bottom, margin.top])

        let x = d3.scaleBand()
            .domain(d3.range(data.length))
            .range([margin.left, width - margin.right])
            .padding(0.1)

        let yAxis = g => g
            .attr("transform", `translate(${margin.left},0)`)
            .call(d3.axisLeft(y).ticks(null, data.format))
            .call(g => g.select(".domain").remove())
            .call(g => g.append("text")
                .attr("x", -margin.left)
                .attr("y", 10)
                .attr("fill", "currentColor")
                .attr("text-anchor", "start")
                .text(data.y))

        let xAxis = g => g
            .attr("transform", `translate(0,${height - margin.bottom})`)
            .call(d3.axisBottom(x).tickFormat(i => data[i].name).tickSizeOuter(0))

        const clear = d3.select("svg").selectAll('*').remove();

        const svg = d3.select("svg")
            .attr("viewBox", [0, 0, width, height]);

        function rightRoundedRect(x, y, width, height, radius) {
          return "M" + x + "," + (y + radius)
              + "a" + radius + "," + radius + " 0 0 1 " + radius + "," + -radius
              + "h" + (width - radius * 2)
              + "a" + radius + "," + radius + " 0 0 1 " + radius + "," + radius
              + "v" + (height - radius)
              + "h" + ( - width)
              + "z";
        }

        svg.append('g')
            .selectAll('path').data(data).enter().append('path')
            .attr('fill', (d, i) => {
              if (data[i].isRightAnswer) {
                return `#72c5ca`
              } else if (!data[i].isRightAnswer && data[i].selectedAnswer) {
                return `#fe5579`
              } else {
                return `#d5d5dd`
              }
            })
            .attr("d", (d, i) => {
              return !d.value ? '' : rightRoundedRect(x(i) + (x.bandwidth() / 2 - 10), y(d.value), 20, y(0) - y(d.value), 10)
            });

        svg.append("g")
            .call(xAxis);

        d3.selectAll('.tick').each(function (d, i) {
          d3.select(this)
              .append('image')
              .attr('xlink:href', i < data.length ? data[i].image : null)
              .attr('x', - (x.bandwidth() / 2))
              .attr('y', 1)
              .attr('width',x.bandwidth())
              .attr('height', '100')
          ;
        })

        let checkRight = this.$props.checkRight;
        let checkWrong = this.$props.checkWrong;
        let checkWrongDisable = this.$props.checkWrongDisable;

        d3.selectAll('.tick').each(function (d, i) {
          d3.select(this)
              .append('image')
              .attr('xlink:href',  () => { if (data[i].isRightAnswer)
              { return checkRight } else if (!data[i].isRightAnswer && data[i].selectedAnswer)
              { return checkWrong } else
              { return checkWrongDisable } })
              .attr('x', -10)
              .attr('y', -(y(0) -y(data[i].value)) - 47)
              .attr('width','20')
              .attr('height', '20')
          ;
        })

        d3.selectAll('text').each(function (d, i) {
          d3.select(this)
              .attr('stroke', () => {
                if (data[i].isRightAnswer) {
                  return `#72c5ca`
                } else if (!data[i].isRightAnswer && data[i].selectedAnswer) {
                  return `#fe5579`
                } else {
                  return `#d5d5dd`
                }
              })
              .attr('y', function () { if (data[i].image) { return 110 } else { return 10 } })
              .attr('font-size', '1rem')
        })

        d3.selectAll('.tick').each(function (d, i) {
          d3.select(this)
              .append('text')
              .text(data[i].value)
              .attr('x', 0)
              .attr('y', -(y(0) -y(data[i].value)) - 7)
              .attr("stroke", "#828291")
              .attr('font-size', '1rem')
              .attr("text-anchor", "middle")
          ;
        })
      }
    }
}
</script>

<style scoped>


</style>
