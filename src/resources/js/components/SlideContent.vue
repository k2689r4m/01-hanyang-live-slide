<template>
    <form :key="componentKey">
<!--        {{ slide }}-->
        <div v-if="!isWriting">
        </div>
        <div v-if="slide.type === 'multiple_choice'">
            <h3 class="sub black">{{ slide.slide_content.question }}</h3>
            <ul class="example-list">
                <li v-for="(answer, index) in slide.slide_content.answers" class="example-list__item" >
                    <label class="checkbox round gray">
                        <input v-if="slide.activationAnswer" type="checkbox" :disabled=true :checked="answer.isRightAnswer" />
                    </label>
                    <div class="con">
                        <p class="txt">{{ answer.answer }}</p>
                        <div class="img-wrap">
                            <img :id="'_multiple_choice_'+slide.id+'_'+index" v-if="answer.imgUrl" :src="answer.imgUrl" alt="answer.answer"/>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div v-else-if="slide.type === 'short_answer'">
            <h3 class="sub black">{{ slide.slide_content.question }}</h3>
            <textarea v-if="slide.activationAnswer" :readonly=isWriting||isOwn placeholder="이곳에 의견을 얘기해주세요." rows="6">{{slide.slide_content.answer}}</textarea>
            <br>
            <button class="btn-primary btn-normal btn-round btn-disable">제출</button>
        </div>
        <div v-else-if="slide.type === 'text'">
            <h3 class="sub">{{ slide.slide_content.question ? slide.slide_content.question : '제목을 입력하세요.' }}</h3>
            <p class="txt">{{ slide.slide_content.answer ? slide.slide_content.answer : '내용을 입력하세요.' }}</p>
        </div>
        <div v-else-if="slide.type === 'image'" class="img-wrap" >
            <img :id="'_image_'+slide.id" v-if="slide.slide_content.imgUrl" :src="slide.slide_content.imgUrl"/>
        </div>
        <div v-else-if="slide.type === 'text_image'">
            <div v-if="slide.slide_content.sortType === 0" class="multi-wrap">
                <div class="img">
                    <img :id="'_text_image_'+slide.id" v-if="slide.slide_content.imgUrl":src="slide.slide_content.imgUrl"/>
                </div>
                <p class="txt">{{ slide.slide_content.question ? slide.slide_content.question : '내용을 입력하세요.' }}</p>
            </div>
            <div v-else-if="slide.slide_content.sortType === 1" class="multi-wrap">
                <p class="txt pt-0 black">{{ slide.slide_content.question ? slide.slide_content.question : '내용을 입력하세요.' }}</p>
                <div class="img">
                    <img :id="'_text_image_'+slide.id" v-if="slide.slide_content.imgUrl":src="slide.slide_content.imgUrl"/>
                </div>
            </div>
            <div v-else-if="slide.slide_content.sortType === 2" class="multi-wrap">
                <p class="txt right">{{ slide.slide_content.question ? slide.slide_content.question : '내용을 입력하세요.' }}</p>
                <div class="img left">
                    <img :id="'_text_image_'+slide.id" v-if="slide.slide_content.imgUrl":src="slide.slide_content.imgUrl"/>
                </div>
            </div>
            <div v-else-if="slide.slide_content.sortType === 3" class="multi-wrap">
                <p class="txt left black">{{ slide.slide_content.question ? slide.slide_content.question : '내용을 입력하세요.' }}</p>
                <div class="img right">
                    <img :id="'_text_image_'+slide.id" v-if="slide.slide_content.imgUrl":src="slide.slide_content.imgUrl"/>
                </div>
            </div>

        </div>
        <div v-else-if="slide.type === 'none'">
          질문을 입력하세요.
        </div>
        <div v-if="!isOwn">
            <button type="submit">제출</button>
        </div>
        <div v-if="!isWriting">
        </div>
    </form>
</template>

<script>
export default {
    props:['slide', 'isOwn', 'isWriting'],
    data() {
        return {
            id: null,
            slides_num: null,
            type: null,
            activationAnswer: null,
            activationTimeLimit: null,
            activationScore: null,
            activationFirstCome: null,
            activationLayout: null,
            slide_content: null,
            changeState: [],
            componentKey: 0,
        };
    },
  mounted() {     //렌더링이 되고 나서
    this.$nextTick(() => {
      // 모든 화면이 렌더링된 후 실행
      if(this.$props.isWriting)
        this.updateImage();
      else
        this._updateImage();
    })
  },
    updated(){          //data 값이 바뀌고나서 호출
      if(this.$props.isWriting)
        this.updateImage();
      else
        this._updateImage();

    },
    methods:{
        forceRerender() {
        this.componentKey += 1;
      },
        updateImage(){
            if(this.slide.type === 'image' || this.slide.type === 'text_image' ){
                const _src = document.getElementById('_'+this.slide.type+'_'+this.slide.id);

                if(_src === null) {
                }
                else if(this.slide.slide_content.imgUrl === null){
                    _src.src = '';
                }
                else if(this.slide.slide_content.imgUrl.length === 0){
                    _src.src = '';
                }
                else{
                    if(typeof(this.slide.slide_content.imgUrl) === 'object'){
                        _src.src = URL.createObjectURL(this.slide.slide_content.imgUrl);
                    }
                    else{
                        _src.src = window.location.pathname+'/image/'+this.slide.slide_content.imgUrl;
                    }
                }
            }
            else if(this.slide.type === 'multiple_choice'){
                for(let i=0;i<this.slide.slide_content.answers.length;i++) {
                    const _src = document.getElementById('_'+this.slide.type+'_'+this.slide.id+'_'+i);
                    if(_src === null) {
                    }
                    else if(this.slide.slide_content.answers[i].imgUrl === null){
                        _src.src = '';
                    }
                    else if (this.slide.slide_content.answers[i].imgUrl.length === 0) {
                        _src.src = '';
                    } else {
                        if (typeof (this.slide.slide_content.answers[i].imgUrl) === 'object') {
                            _src.src = URL.createObjectURL(this.slide.slide_content.answers[i].imgUrl);
                        } else {
                            _src.src = window.location.pathname+'/image/'+this.slide.slide_content.answers[i].imgUrl;
                        }
                    }
                }
            }

          this.changeState.push('none');
          this.changeState.pop();

        },
        _updateImage(){
          if(this.slide.type === 'image' || this.slide.type === 'text_image' ){
            const _src = document.getElementById('_'+this.slide.type+'_'+this.slide.id);
            if(_src){
                _src.src = window.location.pathname+'/api/downloadImage/'+this.slide.slide_content.imgUrl;
            }
          }
          else if(this.slide.type === 'multiple_choice'){
            for(let i=0;i<this.slide.slide_content.answers.length;i++) {
              const _src = document.getElementById('_'+this.slide.type+'_'+this.slide.id+'_'+i);
              if(_src && this.slide.slide_content.answers[i].imgUrl) {
                  _src.src = window.location.pathname+'/api/downloadImage/'+this.slide.slide_content.answers[i].imgUrl;
              }
            }
          }
        },
        countMembers() {
            // axios.post(window.location.pathname + '/api/sendMemberCount', {count_members: this.users.length});
        }

    }
}
</script>

<style scoped>

</style>
