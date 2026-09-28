<template>
    <div class='slide-student-container' style="height: 100%">
        <div class="back-btn" title="완료">
            <span>완료</span>
        </div>

        <div class="full-screen-btn" @click="fullScreen" title="풀스크린">
            <span>ㅁ</span>
        </div>

        <div class="user-list" title="유저리스트">
            <span>{{users.length-1}}</span>
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


        <p>
            <a @click="prev">Previous</a> || <a @click="next">Next</a>
        </p>

        <div v-if="this.slideState == 0" class="h-100 w-100">
            <img :src="this.isSlide && this.isSlide.slide_content.imgUrl" class="h-100 w-100">
        </div>

        <div v-if="slideState == 1" class="card h-100">
            <div class="card-header">
                <h2 class="my-0 font-weight-normal">Quiz {{currentNumber+1}}</h2>
            </div>
            <div v-if="!quizReady[checkReady().idx].ready" class="card-body row" style="text-align: center">
<!--                <p class="vw col-sm-12">퀴즈 시작 버튼을<br>눌러주세요!<br>{{usersReadyCount}}/{{ users.length-1}} 준비</p>-->
                <p class="vw col-sm-12">퀴즈 시작 버튼을<br>눌러주세요!<br>{{usersReadyCount}}/{{ memberCount }} 준비</p>
                <div class="col-sm-12 d-flex justify-content-center">
                    <a @click="imReady" class="btn btn-primary d-flex align-items-center justify-content-center" style="height: 90px; width: 180px; font-size: 45px">시 작</a>
                </div>
            </div>
            <div v-else class="card-body row" style="text-align: center">
                <!--                <p class="vw col-sm-12">잠시만 기달려주세요.<br>퀴즈가 곧 시작 됩니다!<br></p>-->
                <div style="width: 100%;height: 100%;display: flex; flex-direction: column; justify-content: space-between;">
                    <div class="quiz-header">
                        <strong><p class="quiz-title" style="font-size: 100px;">QUIZ TITLE</p></strong>
                    </div>
                    <div class="quiz-graph-container">
<!--                        <svg id="graph"></svg>-->
                        <!--                        <div id="graph"></div>-->
                    </div>
                    <div class="quiz-footer">
                        <div>
                            <button @click="drawChart('word-cloud', 4)">워드 클라우드 랜더링 테스트</button>
                        </div>

                        <strong><p class="quiz-title" style="font-size: 100px;">QUIZ FOOTER</p></strong>
                    </div>
                </div>
            </div>
        </div>

        <div v-else-if="slideState == 2 || slideState == 3 || slideState == 10" class="card-body row" style="text-align: center;height: 80%;">
            <p class="vw col-sm-12">통계결과</p>
            <graph ref="graph" :width="`100%`" :height="`80%`" :type="this.graphType" :data="this.graphData" :who="`professor`" :id="this.graphId"></graph>
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


.my-time{
    font-size: 250px;
}

.slide-student-container{
    position: relative;
    padding: 15px;
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
    props:['user', 'roomId'],
    data() {
        return {
            // slides: '',
            users: [],
            usersState: [],
            slides: [],
            isSlide: '',
            quizReady: [],
            usersReadyCount: 0,
            ready: false,             //안씀
            slideState: 0,           //  1: 퀴즈 대기,  2: 퀴즈 진행(통계 보기), 3: 퀴즈 진행(주관식), 10: 퀴즈 결과(통계)
            imgSrc: '',
            time: 0,
            tm: ()=>{},
            timerState: false,
            currentNumber: 0,

            graph: null,
            // graphSize: {width: null, height: null},
            // tooltip: null,
            //테스트용임
            graphType: [],
            // graphDataNum: null,
            graphData: [],
            graphId: [],
            memberCount: 0,
            scoreData: [[10],[7,3],[5,3,2],[4,3,2,1]],
            scoreX: 0,
            scoreY: 0,

            goods: [0,0,0],
            docV: null,
            screenMode: true
        }
    },
    mounted() {
        this.init();
        this.fetchSlides();
    },
    created() {
        Echo.join('classesroom_'+this.$props.roomId)
            .here(user => {
                this.users = user;
            })
            .joining(user => {
                this.users.push(user);
                this.checkUserState(user.email);
                this.userFetchSlide(user.email);
            })
            .leaving(user => {
                this.users = this.users.filter(u => u.email !== user.email);
            })
            .listenForWhisper('userQuizState', (_data) =>{
                this.userStateQuizSet(_data,'Ready');
            })
            .listenForWhisper('sendAnswer', (_data) =>{
                let userIdx = this.checkUser(_data.user).idx;
                this.usersState[userIdx].quizState[this.currentNumber] = _data.userState;

                if(this.slides[this.currentNumber].type !== 'multiple_choice' && this.slides[this.currentNumber].type !== 'short_answer') {
                    if(_data.type !== 'multiple_choice' && _data.type !== 'short_answer'){
                        return false;
                    }
                }

                // 정답 체크
                let checkAnswer = false;
                if(this.slides[this.currentNumber].type === 'multiple_choice'){
                    for(let i=0;i<this.slides[this.currentNumber].slide_content.answers.length;i++){
                        if(this.slides[this.currentNumber].slide_content.answers[i].isRightAnswer){
                            if(_data.answer[i].answer){
                                checkAnswer = true;
                            }
                            else{
                                checkAnswer = false;
                                break;
                            }
                        }
                        else if(_data.answer[i].answer){
                            checkAnswer = false;
                            break;
                        }
                    }
                }
                else if(this.slides[this.currentNumber].type === 'short_answer'){
                    if(this.slides[this.currentNumber].slide_content.answer === _data.answer) {
                        checkAnswer = true;
                    }
                }


                console.log('----------------------------------');
                console.log(this.slides[this.currentNumber].slide_content.score);
                console.log('----------------------------------');

                let answer = {
                    "user": _data.user,
                    "type": _data.type,
                    "question": _data.question,
                    "answer":  _data.answer,
                    "slideId": _data.slideId,
                    "score": 0,
                    // 주관식 점수 들어오면 밑에 코드로 사용
                    // _data.push({score: this.slides[this.currentNumber].slide_content.score});
                }




                if(checkAnswer){
                    if(this.memberCount <= this.scoreY){
                        answer.score = 0;
                    }
                    else{
                        //주관식 점수가 들어오면 밑에 객관식 점수 계산처럼 수정 필요
                        if(this.slides[this.currentNumber].type === 'multiple_choice'){
                            let _score = Math.floor(this.slides[this.currentNumber].slide_content.score * (this.scoreData[this.scoreX][this.scoreY]*0.1));
                            answer.score = _score;
                        }
                        else{
                            answer.score = this.scoreData[this.scoreX][this.scoreY];
                        }

                        this.scoreY++;
                    }
                    axios.post(window.location.pathname + '/api/professor/send_answers', {answer: JSON.stringify(answer), slideId: _data.slideId, user: _data.user, result: true}).then((re)=>{
                        if(re.data){
                            this.quizPageChange();
                        }
                    });
                }
                else{
                    axios.post(window.location.pathname + '/api/professor/send_answers', {answer: JSON.stringify(answer), slideId: _data.slideId, user: _data.user, result: false}).then((re)=>{
                        if(re.data){
                            this.quizPageChange();
                        }
                    })
                    console.log("정답을 틀림____");
                }

                Echo.join('classesroom_'+this.$props.roomId)
                    .whisper('return_answer'+_data.user,{checkAnswer:checkAnswer, userState: this.userStateQuizSet(_data.user, 'Send'), score: answer.score});
            })
            .listenForWhisper('sendGood', (_data) =>{
                this.goods[_data.flagType]++;

                Echo.join('classesroom_'+this.$props.roomId)
                    .whisper('setGood',this.goods);

                this.getGoods();
            })
    },
    methods: {
        init(){
            this.ready = false;
            this.slideState = 0;
            this.time = 0;
            this.imgSrc = '';
            this.tm = ()=>{};
            this.getMembersCount();

            this.docV = document.documentElement;

            document.querySelector('.back-btn').addEventListener('click', () => {
                this.navBack();
            });
        },
        navBack() {
            location.href = location.href.substring(0, location.href.lastIndexOf(('/room')))
        },
        fetchSlides(){
            axios.post(window.location.pathname + '/api/professor/fetch_slide').then(response => {
                // this.renderSlide(JSON.parse(response.data[0].slide_content));
                this.putSlide(response.data);

                console.log(response.data);

                response.data.forEach((slide) => {
                    this.graphData[slide[0].id] = [];
                    this.graphType[slide[0].id] = [];
                })

                if (this.graphId.length === 0) {
                    this.graphId.push(this.slides[this.currentNumber].id);
                }
                else {
                    this.graphId[0] = (this.slides[this.currentNumber].id);
                }

                //타입 체크 해야함함
                //슬라이드 타입 체크해주기
                this.checkSlideType();
                //상태 체크 해야함함
                this.checkState();
                // this.isSlide = this.slides[0]
                this.isSlide = this.slides[0];

                this.quizPageChange();

                //좋아요 초기 초기화
                this.getGoods();
            })
        },
        userFetchSlide(user){
            let userIdx = this.checkUser(user).idx;

            // console.log(this.quizReady);

            if(this.quizReady[this.checkReady().idx].state === 'end')
                this.slideState = 10;

            Echo.join('classesroom_'+this.$props.roomId)
                .whisper('slideIdxSyn_'+user,{
                    idx: this.currentNumber,
                    slideState: this.slideState,
                    userState: this.usersState[userIdx].quizState[this.currentNumber],
                    quizState: this.quizReady[this.checkReady().idx].state
                });
        },
        putSlide(_data){
            for(var i=0; i , i < _data.length; i++){
                // _data[i].slide_content = JSON.parse(_data[i].slide_content);
                _data[i][0].slide_content = JSON.parse(_data[i][0].slide_content);

                this.slides.push(_data[i][0]);

                console.log(this.slides[0].slide_content.id);
            }
            // this.slides = _data;
        },
        quizPageChange() {
            if (this.graphId.length === 0) {
                this.graphId.push(this.slides[this.currentNumber].id);
            }
            else {
                this.graphId[0] = (this.slides[this.currentNumber].id);
            }

            console.log('this.graphId[0]: ', this.graphId[0]);

            axios.post(window.location.pathname + '/api/user/quiz_result', {slideId: this.slides[this.currentNumber].id }).then(re =>{
                if (re.data !== null) {
                    if (this.graphData[this.slides[this.currentNumber].id].length === 0) {
                        this.graphData[this.slides[this.currentNumber].id].push(re.data.data);
                    }
                    else {
                        this.graphData[this.slides[this.currentNumber].id][0] = re.data.data;
                    }

                    if (this.graphType[this.slides[this.currentNumber].id].length === 0) {
                        this.graphType[this.slides[this.currentNumber].id].push(re.data.resultLayout);
                    }
                    else {
                        this.graphType[this.slides[this.currentNumber].id][0] = re.data.resultLayout;
                    }

                    if (this.$refs) {
                        if (this.$refs.graph) {
                            this.$refs.graph.drawChart();
                        }
                    }

                }
            });
        },
        imReady(){
            // this.quizReady[this.checkReady().idx].ready = true;
            if(this.quizReady[this.checkReady().idx].ready === false){
                this.quizReady[this.checkReady().idx].ready = true;


                if(this.slides[this.currentNumber].type === 'multiple_choice'){
                    this.slideState = 2;        //객관식
                }
                else if(this.slides[this.currentNumber].type === 'short_answer'){
                    this.slideState = 3;        //주관식
                }


                for(let i=0;i<this.usersState.length;i++){
                    this.userFetchSlide(this.usersState[i].email);
                }
                for(let i=0;i<this.usersState.length;i++){
                    this.usersState[i].quizState[this.currentNumber] = 'Start';
                }


                if(4 <= this.memberCount){
                    this.scoreX = 3;
                }
                else{
                    this.scoreX = this.memberCount-1;
                }
                this.scoreY = 0;





                this.quizTimer();
                this.timerState = true;
            }
            //whisper()

            // this.quizPageChange();

        },
        imgFatch(img){
            this.imgSrc = img;
        },
        quizTimer(){
            this.tm = setInterval(()=>{
                if(this.time <= 0){
                    this.stopTimer();
                    this.endQuiz();
                }
                Echo.join('classesroom_'+this.$props.roomId)
                    .whisper('quizTimer',{
                        adminTimer: this.time,
                        quizState: this.quizReady[this.checkReady().idx].state,
                    });
                this.time = this.time - 1;
            },1000)
        },
        stopTimer(){
            clearInterval(this.tm);
            this.quizReady[this.checkReady().idx].state = true
            this.timerState = false;
        },
        next() {
            if(this.currentNumber+1 < this.slides.length){
                // this.currentNumber += 1;
                // this.checkState();
                // this.isSlide = this.slides[this.currentNumber];
                if(this.timerState){
                    console.log('타이머가 실행중');
                }
                else{
                    this.currentNumber += 1;
                    this.quizPageChange();
                    this.checkState();
                    this.isSlide = this.slides[this.currentNumber];
                    this.checkSlideType();
                    this.usersReadyCount = 0;
                    this.getGoods();
                }
            }
            for(let i=0;i<this.usersState.length;i++){
                this.userFetchSlide(this.usersState[i].email);
            }
            console.log(this.currentNumber);
        },
        prev() {
            if(0 <= this.currentNumber-1){
                // this.currentNumber -= 1
                // this.checkState();
                // this.isSlide = this.slides[this.currentNumber];
                if(this.timerState){
                    console.log('타이머가 실행중');
                }
                else{
                    this.currentNumber -= 1;
                    this.quizPageChange();
                    this.checkState();
                    this.isSlide = this.slides[this.currentNumber];
                    this.checkSlideType();
                    this.usersReadyCount = 0;
                    this.getGoods();
                }
            }
            for(let i=0;i<this.usersState.length;i++){
                this.userFetchSlide(this.usersState[i].email);
            }
            console.log(this.currentNumber);
        },
        checkUserState(user){
            let st = false;
            st = this.checkUser(user);
            if(!st['state']){
                this.usersState.push({
                    email: user,
                    quizState: []
                });
                for(let i=0;i<this.slides.length;i++){
                    this.usersState[this.usersState.length-1].quizState.push(false);
                }
            }
        },
        checkUser(user){
            for(var i=0; i , i < this.usersState.length; i++){
                if(this.usersState[i].email === user){
                    return {state: true, idx: i};
                }
            }
            return {state: false, idx: 0};
        },
        checkState(){
            let st = false;

            //타입이 퀴즈이면 퀴즈 상태정보가 등록 되어 있는지 확인
            st = this.checkReady();




            //퀴즈 상태정보가 이미 있는지 확인 없으면 추가
            if(!st['state']){
                this.quizReady.push({
                    id: this.currentNumber,
                    ready: false,
                    state: false,
                });
            }

            if(this.slides[this.currentNumber].type === 'multiple_choice' || this.slides[this.currentNumber].type === 'short_answer'){


                // this.slideState = 1;

                if(this.quizReady[this.checkReady().idx].ready === false){
                    this.slideState = 1;
                }
                else if(this.slides[this.currentNumber].type === 'multiple_choice'){
                    this.slideState = 2;        //객관식
                }
                else if(this.slides[this.currentNumber].type === 'short_answer'){
                    this.slideState = 3;        //주관식
                }
            }
            else{
                this.slideState = 0;
            }
        },
        checkReady(){
            for(var i=0; i < this.quizReady.length; i++){
                if(this.quizReady[i].id === this.currentNumber){
                    return {state: true, idx: i};
                }
            }
            return {state: false, idx: 0};
        },
        userStateQuizSet(_data, _state){
            let userIdx = this.checkUser(_data.user).idx;
            //번경중
            this.usersState[userIdx].quizState[this.currentNumber] = _state;
            this.usersReadyCount += 1;
            //
            // for(let i=0;i<this.usersState.length;i++){
            //     this.usersReadyCount += this.userFetchSlide(this.usersState[userIdx].quizState[this.currentNumber]);
            // }

            return this.usersState[userIdx].quizState[this.currentNumber];
        },
        checkSlideType(){
            if(this.slides[this.currentNumber].slide_content.type === "short_answer" || this.slides[this.currentNumber].slide_content.type === "multiple_choice"){
                this.time = this.slides[this.currentNumber].slide_content.timeout;
            }
            else{
                this.time = -1;
            }
        },
        getMembersCount(){
            axios.get(window.location.pathname + '/api/professor/get_members').then(re => {
                this.memberCount = re.data;
            })
        },
        endQuiz(){
            this.slideState = 10;    //퀴즈 상태 변수 10: 결과창으로 넘기기
            this.quizReady[this.checkReady().idx].state = 'end';

            for(let i=0;i<this.usersState.length;i++){
                this.usersState[i].quizState[this.currentNumber] = 'end';
            }

            console.log("교수 퀴즈 끝남::");
            Echo.join('classesroom_'+this.$props.roomId)
                .whisper('endQuiz', {slideState: this.slideState, usersState: 'end'});


        },
        getGoods(){
            //API 보내는부분
            axios.get(window.location.pathname + '/api/get_goods/'+ this.slides[this.currentNumber].id).then(re=>{
                this.goods = re.data;
                console.log(this.goods);
            });
        },
        fullScreen(){
            console.log('풀스크린니닌');
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
        }
    }
}
</script>
