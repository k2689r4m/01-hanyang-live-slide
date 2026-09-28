/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// IE 에서 vue 보이기
// import "babel-polyfill";
// import 'whatwg-fetch';

require("./bootstrap");

window.uuid = require("uuid");
// require('vue-tiny-slider');
window.Vue = require("vue");
window.draggable = require('vuedraggable');


import VueChatScroll from 'vue-chat-scroll';
Vue.use(VueChatScroll);

Vue.prototype.$ = $;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "write_slide",
    require("./components/WriteSlide").default
);

Vue.component(
    "slide_content",
    require("./components/SlideContent").default
);

Vue.component(
    "student",
    require("./components/Student").default
);

Vue.component(
    "professor",
    require("./components/Professor").default
);

Vue.component(
    "graph",
    require("./components/GraphComponent").default
);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    // el: "#app",
    el: ".slide_vue",
    components: {
        draggable,
    }
});



// console.log(app.$el);
// console.log(app.$destroy());
// console.log(app.$el);
// console.log(app.$children[0].beforeDestroy())




