<template>
            <!--            객관식 퀴즈 진행-->

    <div v-if="$props.isSlide.type === 'image'" class="h-100 w-100">
        <img :src="$props.isSlide.imgUrl" class="h-100 w-100">
    </div>


    <div v-else-if="$props.isSlide.type === 'multiple_choice'" class="card" style="height: 100%">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">{{this.$props.isSlide.question}}</h4>
            </div>
            <div class="card-body">
                <div class="quiz h-100" id="quiz" data-toggle="buttons">
                    <div class="row h-100 pb-5">
                        <div class="col-4 element-animation4 align-self-center text-center my-time">
                            {{ $props.isSlide.timeout }}
                        </div>
                        <div class="col-8 h-100 dir-column">
                            <label v-for="(item, index) in this.$props.isSlide.answers" class="element-animation1 btn btn-lg btn-light btn-block h-100">
                                <span class="btn-label">
                                    <i class="glyphicon glyphicon-chevron-right"></i>
                                </span>
                                <div v-if="item.imgUrl!=''" class="row">
                                    <div class="col-9">
                                        <input style="display: none" type="radio" name="q_answer" value=index+1>{{ item.answer }}
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
                                        <input style="display: none" type="radio" name="q_answer" value=index+1>{{ item.answer }}
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-muted">
                밑에
            </div>
        </div>

        <!--            주관식 퀴즈 진행-->
    <div v-else-if="$props.isSlide.type === 'short_answer'"  style="height: 90%">
        <div v-if="true" style="height: 100%">
            <div class="jumbotron row" style="height: 60%">
                <div class="col-8">
                    <h1>{{$props.isSlide.question}}</h1>
                </div>
                <div class="col-4 align-self-center text-center my-time">
                    {{ $props.isSlide.timeout }}
                </div>
            </div>
            <div class="row text-center">
                <div class="mb-4 mx-4 h-100 w-100">
                    <textarea class="form-control" rows="3" style="float:none; margin:0 auto; font-size: 55px" placeholder="답을 적어주세요!"></textarea>
                </div>
                <button class="col-10 btn btn-success btn-lg btn-block" style="float:none; margin:0 auto;">정 답</button>
            </div>
        </div>
        <div v-else class="card-body">
            Quiz Result
        </div>
    </div>
<!--    슬라이드가 선택이 안되어 있을시 나오는 페이지-->
    <div v-else class="w-100 h-100 text-center" style="background: #BDBDBD">
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
    props:['isSlide'],
    data() {
        return {
            slideState: 0,           //  1: 퀴즈 대기,  2: 퀴즈 진행(객관식), 3: 퀴즈 진행(주관식), 10: 퀴즈 결과(통계)
        }
    },
    mounted() {
        // if($props.isSlide.type == 'multiple_choice'){
        //     this.slideState = 2;
        // }
        // else if($props.isSlide.type == 'short_answer'){
        //     this.slideState = 3;
        // }
        // else{
        //     this.slideState = 1;
        // }
    },
    created() {
    },

    methods: {

    }
}
</script>
