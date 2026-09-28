<template>
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <div v-for="(slide, index) in slides">
                            {{index}} ::: {{ slide.slide_content }}
                    </div>

                    <div v-for="(slide, index) in slides">
                        <div v-if="index == sIndex">
                            ## {{index}} ::: {{ slide.slide_content }}
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
        }
    },
    created() {
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
            .listenForWhisper('slideClick', (idx) =>{
                this.sIndex = idx;
            })
            .listenForWhisper('slideIdxSyn', (idx) =>{
                this.slides.splice(idx,1);
            })
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
    }
}
</script>
