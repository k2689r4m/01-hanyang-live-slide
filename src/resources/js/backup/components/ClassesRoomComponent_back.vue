<template>
        <div class="row justify-content-center">
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <div v-for="(slide, index) in slides">
                            <button @click="slideClick(index)"
                                    type="button"
                                    class="btn btn-secondary">
                                {{ index }}
                            </button>
                        </div>
                    </div>
                    <div>
                        <button @click="sendSlide" type="button" class="btn btn-secondary">추가</button>
                        <button @click="slideDelete(0)" type="button" class="btn btn-secondary">삭제</button>
                    </div>
                </div>
            </div>

            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div v-for="(slide, index) in slides">
                            <div v-if="index == sIndex">
                                {{ slide.slide_content }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <li class="py-2" v-for="(user, index) in users" :key="index">
                            {{ user.name }}
                        </li>
                    </div>
                </div>
            </div>
        </div>
</template>

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
        }
    },
    created() {
        // 해야할꺼
        // 중간에 들어왔을때 init 처리
        // 소켓 연결이 중간에 팅겼을때 처리
        // 슬라이드 저장 api 추가

        this.init();

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
            // .listenForWhisper('slideClick', (idx) =>{
            //     this.sIndex = idx;
            // })
            // .listenForWhisper('slideIdxSyn', (idx) =>{
            //     this.slides.splice(idx,1);
            // })
            .listen('classesRoomEvent', (event) =>{
                this.slides.push(event.slides);
            })
    },

    methods: {
        init(){
            this.fetchSlide();
        },
        fetchSlide(){
            axios.get(window.location.pathname + '/api/fetch_slides').then(response => {
                this.slides = response.data;
            })
        },
        sendSlide(){
            var s_content = new Object();
            s_content.title = "제에모옥";
            s_content.content = "내요용";
            var json_content = JSON.stringify(s_content);

            this.oneSlide = ({
                type:0,
                slide_content: json_content,
                available:0,
                order_num:0,
                user_email: 'test@test.test',
                class_id: 1
            });

            axios.post(window.location.pathname + '/api/send_slides', {slides: this.oneSlide, room_id: this.$props.roomId }).then(re =>{
                this.slides.push({...this.oneSlide, id:re.data.data.id});
            });

        },
        slideClick(idx){
            this.sIndex = idx;
            Echo.join('classesroom_'+this.$props.roomId)
                .whisper('slideClick', idx);
        },
        slideDelete(idx){
            axios.post(window.location.pathname + '/api/delete_slides', {slides: this.slides[idx], room_id: this.$props.roomId }).then(re => {
                this.slides.splice(idx,1);
                Echo.join('classesroom_'+this.$props.roomId)
                    .whisper('slideIdxSyn', idx);

                if(idx < 0){
                    idx = 0;
                }
                this.sIndex = idx;
                this.slideClick(idx);
            });

        },
    }
}
</script>
