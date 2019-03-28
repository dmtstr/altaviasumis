import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({

    state: {

        auth: localStorage.getItem('auth'),
        loading: false,

        filter: {},

        items: {
            data: [],
            selected: -1
        },

        pager: {
            count: 200,
            total: 2429,
            offset: 0
        }

    },

    mutations: {

        loading (state, value) {
            state.loading = value;
        },

        reset (state) {
            state.pager = {};
            state.filter = {};
        },

        pager (state, pager) {
            state.pager = Object.assign({}, state.pager, pager);
        },

        'filter:set' (state, filter) {
            state.filter = Object.assign({}, state.filter, filter);
        },

        'items:update' (state, data) {
            state.items.data = data;
        },

        'items:select' (state, index) {
            state.items.selected = index;
        },

        'session:create' (state, token) {
            state.auth = token;
            localStorage.setItem('auth', token);
        },

        'session:destroy' (state) {
            state.auth = null;
            localStorage.removeItem('auth');
        }

    }

});