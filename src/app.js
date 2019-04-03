import '@/assets/styles/app.css';

import Vue from 'vue';
import App from '@/components/app.vue';
import Router from '@/common/router';
import Store from '@/common/store/index';

new Vue({
    el: '#app',
    router: Router,
    store: Store,
    render: function(h) {
        return h(App);
    }
});