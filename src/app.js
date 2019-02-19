import '@/styles/app.css';

import Vue from 'vue';
import App from '@/components/app.vue';
import Router from '@/common/router';
import Session from '@/common/session'

Session.restore();

new Vue({
    el: '#app',
    router: Router,
    render: function(h) {
        return h(App);
    }
});