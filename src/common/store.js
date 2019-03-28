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
        }

    },

    mutations: {

        loading (state, value) {
            state.loading = value;
        },

        filter (state, filter) {
            state.filter = Object.assign({}, state.filter, filter);
        },

        'filter:reset' (state) {
            state.filter = {};
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