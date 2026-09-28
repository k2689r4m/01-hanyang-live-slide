<template>
    <div class='slide-student-container' style="height: 100%; display: flex; padding: 0px;">


        <div class="back-btn" title="완료">
            <span>완료</span>
        </div>

        <div class="full-screen-btn" @click="fullScreen" title="풀스크린">
            <span>ㅁ</span>
        </div>

        <div class="user-list" title="유저리스트">
            <span>{{users.length-1}}</span>
        </div>

        <div class="chat-btn" id="chat-sidebarCollapse" title="채팅">
            <span>채팅</span>
        </div>

<!--        //좋아요 버튼-->
        <div class="good-btn dropdown toggle" data-toggle="dropdown">
            <i class="far fa-thumbs-up"></i>
            <ul class="dropdown-menu" role="menu">
                <li @click="sendGoods(0)">쉬워요</li>
                <li @click="sendGoods(1)">어려워요</li>
                <li @click="sendGoods(2)">좋아요</li>
            </ul>
        </div>

<!--        //좋아요 표시-->
        <div class="good-layout-1" title="쉬워요" >
            <span>{{ goods[0] }}</span>
        </div>

        <div class="good-layout-2" title="어려워요">
            <span>{{ goods[1] }}</span>
        </div>

        <div class="good-layout-3" title="좋아요">
            <span>{{ goods[2] }}</span>
        </div>


        <div v-if="slide.type == 'multiple_choice' || slide.type == 'short_answer' " class="h-100 w-100">
<!--            퀴즈준비 중-->
            <div v-if="slideState === 1" class="card h-100">
                <div class="card-header">
                    <h2 class="my-0 font-weight-normal">Quiz</h2>
                </div>
                <div v-if="!ready || ready === 'Send'" class="card-body row" style="text-align: center">
                    <p class="vw col-sm-12">퀴즈를 풀 준비가<br>되셨다면 준비 버튼을<br>눌러주세요!</p>
                    <div class="col-sm-12 d-flex justify-content-center">
                        <a @click="imReady" class="btn btn-primary d-flex align-items-center justify-content-center" style="height: 90px; width: 180px; font-size: 45px">준 비</a>
                    </div>
                </div>
                <div v-else class="card-body row" style="text-align: center">
                    <p class="vw col-sm-12">잠시만 기다려주세요.<br>퀴즈가 곧 시작 됩니다!<br></p>
                </div>
            </div>

<!--            퀴즈 진행-->
            <div v-else-if="slideState == 2" class="card" style="height: 100%">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">{{slide.question}}</h4>
                </div>
                <div v-if="!quizState" class="card-body">
                    <div class="quiz h-100" id="quiz" data-toggle="buttons">
                        <div class="row h-100 pb-5">
                            <div class="col-4 element-animation4 align-self-center text-center my-time">
                                {{ time }}
                            </div>
                            <div class="col-8 h-100 dir-column">
                                    <label v-for="(item, index) in slide.answers" class="element-animation1 btn btn-lg btn-light btn-block h-100">
                                        <span class="btn-label">
                                            <i class="glyphicon glyphicon-chevron-right"></i>
                                        </span>
                                        <div v-if="item.imgUrl!=''" class="row">
                                            <div class="col-9">
                                                <input :disabled="sendAnswerState == true" style=" display: none" type="radio"
                                                       name="q_answer" v-model="userAnswer[index]" v-bind:value=true>{{ item.answer }}
                                            </div>
                                            <div class="col-3 text-right">
                                                <img data-toggle="modal"
                                                     data-keyboard="false"
                                                     data-target="#myModalHorizontal"
                                                     :src="item.imgUrl"
                                                     @click="imgFatch(item.imgUrl)"
                                                     style="width: 115px; height: 115px;">
                                            </div>
                                        </div>
                                        <div v-else class="row">
                                            <div class="col-12">
                                                <input :disabled="sendAnswerState == true" style="display: none" type="radio"
                                                       name="q_answer" v-model="userAnswer[index]" v-bind:value=true>{{ item.answer }}
                                            </div>
                                        </div>
                                    </label>
                                <button v-if="!(ready === 'Send' || ready === 'end')" @click="sendAnswer">정답</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer text-muted">
                    밑에
                </div>
            </div>
            <div v-else-if="slideState == 3"  style="height: 90%">
                <div v-if="!quizState" style="height: 100%">
                    <div class="jumbotron row" style="height: 60%">
                        <div class="col-8">
                            <h1>{{slide.question}}</h1>
                        </div>
                        <div class="col-4 align-self-center text-center my-time">
                            {{ time }}
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="mb-4 mx-4 h-100 w-100">
                            <textarea :disabled="sendAnswerState == true"
                                      v-model="userAnswer"
                                      class="form-control" rows="3" style="float:none; margin:0 auto; font-size: 55px" placeholder="답을 적어주세요!"></textarea>
                        </div>
                        <button v-if="!(ready === 'Send' || ready === 'end')"
                                class="col-10 btn btn-success btn-lg btn-block" style="float:none; margin:0 auto;" @click="sendAnswer">정 답</button>
                    </div>
                </div>
            </div>
            <div v-else-if="slideState == 10" class="card-body">
                Quiz Result

<!--                <div style="width: 100%;height: 100%;display: flex;justify-content: center;align-items: center;">-->
<!--                    <graph ref="graph" :width="`80%`" :height="`80%`" :type="this.graphType" :data="this.graphData" :who="`student`" ></graph>-->
<!--                </div>-->
                <div v-if="answerResult == true" class="row" style="font-size:4em;color:green;display:flex;flex-direction:column;align-items:center;">
                    <div style="font-size: 8em;">O</div>
                    <div>정답입니다.({{ score }}point 획득!)</div>
                </div>
                <div v-else class="row" style="font-size:4em;color:red;display:flex;flex-direction:column;align-items:center;">
                    <div style="font-size: 8em;">X</div>
                    <div>오답입니다.</div>
                </div>

            </div>
        </div>
        <div v-else-if="slideState === -1" class="h-100 w-100">
            강의자와 연결이 끊겼습니다.
        </div>
        <div v-else-if="slideState === 0" class="h-100 w-100">
            <img :src="slide && slide.imgUrl" class="h-100 w-100">
        </div>


<!--            모달 페이지-->
        <div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <img :src="this.imgSrc" style="width: 100%; height: 100%;">

                </div>
            </div>
        </div>

        <nav id="chat-sidebar">
            <div class="card card-default">
                <div class="card-header">Messages</div>
                <div class="card-body p-0">
                    <ul class="list-unstyled" style="height: 300px; overflow-y:scroll" v-chat-scroll>
<!--                        <li class="p-2" v-for="(message, index) in messages" :key="index">-->
<!--                            <strong>{{ message.user.name }}</strong>-->
<!--                            {{ message.message }}-->
<!--                        </li>-->
                        <strong>message.user.name</strong>
                    </ul>
                </div>

                <input
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    class="form-control">
            </div>
        </nav>
    </div>
</template>



<style>

#chat-sidebar {
    min-width: 250px;
    max-width: 250px;

    background: #7386D5;
    color: #fff;
    transition: all 0.3s;

    margin-right: -250px;
}

#chat-sidebar.active {
    margin-right: 0;
}



.slide-student-container{
}

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
    overflow-x:hidden;
}


.my-time{
    font-size: 250px;
}

.btn-light:not(:disabled):not(.disabled).active{
    color: #fff;
    background-color: #A4A4A4;
    border-color: #A4A4A4;
}

#qid {
    padding: 10px 15px;
    -moz-border-radius: 50px;
    -webkit-border-radius: 50px;
    border-radius: 20px;
}
label.btn {
    padding: 18px 60px;
    white-space: normal;
    -webkit-transform: scale(1.0);
    -moz-transform: scale(1.0);
    -o-transform: scale(1.0);
    -webkit-transition-duration: .3s;
    -moz-transition-duration: .3s;
    -o-transition-duration: .3s
}

label.btn:hover {
    text-shadow: 0 3px 2px rgba(0,0,0,0.4);
    -webkit-transform: scale(1.03);
    -moz-transform: scale(1.03);
    -o-transform: scale(1.03)
}

.dir-column {
    display: flex;
    flex-direction: column;
}

label.btn-block {
    flex: 1;
    text-align: left;
    position: relative
}

.vw {font-size: 7vw;}
.vh {font-size: 15vh;}

label .btn-label {
    position: absolute;
    left: 0;
    top: 0;
    display: inline-block;
    padding: 0 10px;
    background: rgba(0,0,0,.15);
    height: 100%
}

label .glyphicon {
    top: 34%
}
.element-animation1 {
    animation: animationFrames ease .8s;
    animation-iteration-count: 1;
    transform-origin: 50% 50%;
    -webkit-animation: animationFrames ease .8s;
    -webkit-animation-iteration-count: 1;
    -webkit-transform-origin: 50% 50%;
    -ms-animation: animationFrames ease .8s;
    -ms-animation-iteration-count: 1;
    -ms-transform-origin: 50% 50%
}
.element-animation2 {
    animation: animationFrames ease 1s;
    animation-iteration-count: 1;
    transform-origin: 50% 50%;
    -webkit-animation: animationFrames ease 1s;
    -webkit-animation-iteration-count: 1;
    -webkit-transform-origin: 50% 50%;
    -ms-animation: animationFrames ease 1s;
    -ms-animation-iteration-count: 1;
    -ms-transform-origin: 50% 50%
}
.element-animation3 {
    animation: animationFrames ease 1.2s;
    animation-iteration-count: 1;
    transform-origin: 50% 50%;
    -webkit-animation: animationFrames ease 1.2s;
    -webkit-animation-iteration-count: 1;
    -webkit-transform-origin: 50% 50%;
    -ms-animation: animationFrames ease 1.2s;
    -ms-animation-iteration-count: 1;
    -ms-transform-origin: 50% 50%
}
.element-animation4 {
    animation: animationFrames ease 1.4s;
    animation-iteration-count: 1;
    transform-origin: 50% 50%;
    -webkit-animation: animationFrames ease 1.4s;
    -webkit-animation-iteration-count: 1;
    -webkit-transform-origin: 50% 50%;
    -ms-animation: animationFrames ease 1.4s;
    -ms-animation-iteration-count: 1;
    -ms-transform-origin: 50% 50%
}
@keyframes animationFrames {
    0% {
        opacity: 0;
        transform: translate(-1500px,0px)
    }

    60% {
        opacity: 1;
        transform: translate(30px,0px)
    }

    80% {
        transform: translate(-10px,0px)
    }

    100% {
        opacity: 1;
        transform: translate(0px,0px)
    }
}

@-webkit-keyframes animationFrames {
    0% {
        opacity: 0;
        -webkit-transform: translate(-1500px,0px)
    }
    60% {
        opacity: 1;
        -webkit-transform: translate(30px,0px)
    }

    80% {
        -webkit-transform: translate(-10px,0px)
    }

    100% {
        opacity: 1;
        -webkit-transform: translate(0px,0px)
    }
}

@-ms-keyframes animationFrames {
    0% {
        opacity: 0;
        -ms-transform: translate(-1500px,0px)
    }

    60% {
        opacity: 1;
        -ms-transform: translate(30px,0px)
    }
    80% {
        -ms-transform: translate(-10px,0px)
    }

    100% {
        opacity: 1;
        -ms-transform: translate(0px,0px)
    }
}

@-moz-keyframes fadeG {
    0% {
        background-color: #000
    }

    100% {
        background-color: #FFF
    }
}

@-webkit-keyframes fadeG {
    0% {
        background-color: #000
    }

    100% {
        background-color: #FFF
    }
}

@-ms-keyframes fadeG {
    0% {
        background-color: #000
    }

    100% {
        background-color: #FFF
    }
}

@-o-keyframes fadeG {
    0% {
        background-color: #000
    }
    100% {
        background-color: #FFF
    }
}

@keyframes fadeG {
    0% {
        background-color: #000
    }

    100% {
        background-color: #FFF
    }
}



</style>

<script>

export default {
    props:['user', 'roomId', 'adminEmail'],
    data() {
        return {
            users: [],
            slide: '',
            currentNumber: 0,
            ready: false,
            slideState: 0,           //  1: 퀴즈 대기,  2: 퀴즈 진행(객관식), 3: 퀴즈 진행(주관식), 10: 퀴즈 결과(통계)
            imgSrc: '',
            time: 0,
            quizState: false,
            userAnswer: [],
            sendAnswerState: false,
            answerResult: false,           // -1 정답을 아직 못받음, 0 틀림, 1 정답
            tm: ()=>{},
            graphData: {},
            graphType: {},
            score: 0,
            goods: [0,0,0],
            docV: null,
            screenMode: true
        }
    },
    mounted() {
        this.init();


        $('#chat-sidebarCollapse').on('click', function () {
            $('#chat-sidebar').toggleClass('active');
        });

    },
    created() {
        this.graphType = [];
        this.graphData = [];

        Echo.join('classesroom_'+this.$props.roomId)
            .here(user => {
                this.users = user;

                let st = false;
                user.forEach((u)=>{
                    if(u.email === this.$props.adminEmail){
                        st = true;
                    }
                })

                if(!st){
                    console.log("교수가 없는디요?");
                    this.slideState = -1;
                    history.back();
                }
            })
            .joining(user => {
                this.users.push(user);
                // console.log(this.users[0].email);
            })
            .leaving(user => {
                this.users = this.users.filter(u => u.email !== user.email);

                if(user.email === this.$props.adminEmail){
                    console.log("교수가 없는디요?");
                    this.slideState = -1;
                    // history.back();
                }
            })
            .listenForWhisper('slideIdxSyn_'+this.$props.user.email, (_data) =>{
                    this.graphData = [];
                    this.graphType = [];

                    axios.post(window.location.pathname + '/api/user/fetch_slide', {idx:_data.idx}).then(re =>{
                        this.putSlide(re);
                        this.slideState = _data.slideState;
                        console.log('slideState::: '+ this.slideState);
                        this.userAnswer = [];

                        ////////////////////////////
                        ///이부분 수정해야함//////////
                        this.getAnswerResult();
                        ////////////////////////////

                        this.getGoods();

                        console.log("페이지 넘김 "+ this.slideState);

                        if(this.slide.type === "short_answer" || this.slide.type === "multiple_choice"){
                            this.time = this.slide.timeout;
                            this.quizState = _data.quizState;
                            this.ready = _data.userState;
                            // this.ready = false;
                        }
                        else{
                            this.time = -1;
                        }

                    // console.log('페이지로드::'+this.answerResult);
                });


            })
            .listenForWhisper('return_answer'+this.$props.user.email, (_data)=>{
                this.answerResult = _data.checkAnswer;

                this.score = _data.score;

                if(this.ready !== 'end')
                    this.ready = _data.userState;

                console.log("소켓시점::: "+ this.ready);
            })
            .listenForWhisper('quizTimer', (tm)=>{
                this.time = tm.adminTimer;
                this.quizState = tm.quizState;
                this.sendAnswerState = false;

                console.log("퀴즈 진행 :::" + this.ready);
                // this.getAnswerResult();
                // console.log('타이머시점::'+this.answerResult);
            })
            .listenForWhisper('endQuiz', (_data)=>{
                this.sendAnswer();
                this.slideState = _data.slideState;
                this.ready = _data.usersState;

                this.slideState = 10;

                console.log("퀴즈 끝남 :::" + this.ready);
            })
            .listenForWhisper('setGood', (_data)=>{
                this.goods = _data;
            })
    },

    methods: {
        init(){
            this.ready = false;
            this.slideState = 0;
            this.time = 0;
            this.imgSrc = '';
            this.tm = ()=>{}

            this.docV = document.documentElement;

            document.querySelector('.back-btn').addEventListener('click', () => {
                this.navBack();
            });
        },
        navBack() {
            location.href = location.href.substring(0, location.href.lastIndexOf(('/room')))
        },
        putSlide(_data){
            this.slide = JSON.parse(_data.data[0].slide_content);
            this.currentNumber = _data.data[0].id;

        },
        imReady(){
            this.ready = 'Ready';
            Echo.join('classesroom_'+this.$props.roomId)
                .whisper('userQuizState', {idx: this.currentNumber, userState: this.ready, user: this.$props.user.email});
        },
        imgFatch(img){
            this.imgSrc = img;
        },
        sendAnswer(){
            this.sendAnswerState = true;
            // this.ready = 'Send';            //바꿔야함
            let answer = {};
            let multipleAnswer = [];

            console.log('답보내는시점:'+this.ready);

            console.log('-----------------------------');
            console.log(this.answerResult);
            console.log('-----------------------------');



            if(this.ready === 'Send' || this.ready === 'End'){
                console.log('답을 이미 보냈어!');
                return false;
            }

            if(this.slide.type === "short_answer"){
                if(this.userAnswer.length === 0)
                    multipleAnswer = '';
                else
                    multipleAnswer = this.userAnswer;

                answer = {
                    "user": this.$props.user.email,
                    "type": this.slide.type,
                    "question": this.slide.question,
                    "answer": multipleAnswer,
                    "slideId": this.currentNumber,
                    "userState": this.ready,
                }

            }
            else if(this.slide.type === "multiple_choice"){
                multipleAnswer = [];
                for(let i=0;i<this.slide.answers.length;i++){
                    if(this.userAnswer[i] == undefined){
                        multipleAnswer.push({
                            'question' : this.slide.answers[i].answer,
                            'answer' : false
                        })
                    }
                    else{
                        multipleAnswer.push({
                            'question' : this.slide.answers[i].answer,
                            'answer' : this.userAnswer[i]
                        })
                    }
                }

                answer = {
                    "user": this.$props.user.email,
                    "type": this.slide.type,
                    "question": this.slide.question,
                    "answer": multipleAnswer,
                    "slideId": this.currentNumber,
                    "userState": this.ready,
                }
            }

            Echo.join('classesroom_'+this.$props.roomId)
                .whisper('sendAnswer',answer);
        },
        getAnswerResult(){
            axios.get(window.location.pathname + '/api/user/get_answers/'+ this.currentNumber).then(re=>{
                if(re.data[0] != undefined){
                    console.log('답API 받아옴');
                    this.answerResult = re.data[0].result;
                    this.score = JSON.parse(re.data[0].answer_data).score;
                    this.ready = 'Send';

                    // axios.post(window.location.pathname + '/api/user/quiz_result', {slideId: this.currentNumber }).then(re =>{
                    //     this.graphData.push(re.data.data);
                    //     this.graphType.push(re.data.resultLayout);
                    //
                    //     this.$refs.graph.drawChart();
                    // });
                }
                else{
                    console.log('답 없음');
                    this.answerResult = false;
                }

            });
        },
        sendGoods(flagType){
            //API 보내는부분
            axios.post(window.location.pathname + '/api/user/send_goods', {slide_id: this.currentNumber, flagType: flagType}).then(re=>{

                // 데이터를 넣어주면 교수한테 알려주기
                //re.data === true
                if(re.data === 1){
                    Echo.join('classesroom_'+this.$props.roomId)
                        .whisper('sendGood', {idx: this.currentNumber, user: this.$props.user.email, flagType: flagType});
                }
            });
        },
        getGoods(){
            //API 보내는부분
            axios.get(window.location.pathname + '/api/get_goods/'+ this.currentNumber).then(re=>{
                this.goods = re.data;
            });
        },
        fullScreen(){
            if (this.screenMode === true) {
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

                document.getElementById('_nav').style.display = 'none';
                this.screenMode = !this.screenMode;
            }
            else if (this.screenMode === false){
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

                document.getElementById('_nav').style.display = '';
                this.screenMode = !this.screenMode;
            }
        },
   }
}
</script>
