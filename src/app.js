import '@/styles/app.css';

import Vue from 'vue';
import App from '@/components/app.vue';
import router from '@/common/routes';

new Vue({
    el: '#app',
    router: router,
    render: function(h) {
        return h(App);
    }
});