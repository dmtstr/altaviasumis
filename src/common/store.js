import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({

    state: {

        auth: localStorage.getItem('auth'),
        loading: false,

        items: {
            data: [],
            selected: -1
        },

        filter: {
            limit: 200,
            count: 0,
            total: 0,
            offset: 0,
            query: null,
            field: null
        }

    },

    mutations: {

        loading (state, value) {
            state.loading = value;
        },

        'filter:set' (state, filter) {
            for (let key in filter) {
                if (filter.hasOwnProperty(key)) {
                    Vue.set(state.filter, key, filter[key]);
                }
            }
        },

        'filter:reset' (state) {
            state.filter = {limit: state.filter.limit};
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

    },

    getters: {

        params (state) {
            let data = {offset: state.filter.offset};
            if (!state.filter.field && !state.filter.query) return data;
            if (!state.filter.field) data.q = state.filter.query;
            else data[`filter[${state.filter.field}][like]`] = state.filter.query;
            return data;
        },

        pager (state) {
            const limit = state.filter.limit;
            const total = state.filter.total;
            const offset = state.filter.offset;
            return {
                limit: limit,
                total: Math.ceil(total / limit),
                current: (offset || 0) / limit + 1
            }
        }

    }

});