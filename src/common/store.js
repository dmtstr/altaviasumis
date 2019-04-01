// ------------------
// Imports
// ------------------

import Vue from 'vue'
import Vuex from 'vuex'
import API from '@/common/api';
import Axois from '@/common/axios';



// ------------------
// Config
// ------------------

Vue.use(Vuex);


const Config = {

    orders: {
        API: API.orders
    },

    stocks: {
        API: API.stocks
    }

};



// ------------------
// Exports
// ------------------

export default new Vuex.Store({

    state: {

        auth: localStorage.getItem('auth'),
        loading: false,

        items: {
            data: [],
            selected: -1,
            create: false
        },

        filter: {
            limit: 15,
            offset: 0,
            query: null,
            field: null
        },

        pager: {
            total: 0,
            current: 1
        }

    },

    mutations: {

        loading (state, value) {
            state.loading = value;
        },


        // pager

        'pager:total' (state, value) {
            Vue.set(state.pager, 'total', Math.ceil(value / state.filter.limit));
        },

        'pager:current' (state, value) {
            Vue.set(state.pager, 'current', value);
        },


        // filter

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


        // items

        'items:update' (state, {data, lazy}) {
            if (lazy === 1) {
                state.items.data = state.items.data.concat(data);
            }
            if (lazy === -1) {
                state.items.selected = state.items.selected + data.length;
                state.items.data = data.concat(state.items.data);
            }
            if (!lazy) {
                state.items.data = data;
                state.items.selected = 0;
            }
        },

        'items:create' (state, value) {
            state.items.create = value;
        },

        'items:select' (state, index) {
            state.items.selected = index;
        },



        // session

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
            let data = {};
            data.offset = state.filter.offset;
            data.limit = state.filter.limit;
            if (!state.filter.field && !state.filter.query) return data;
            if (!state.filter.field) data.q = state.filter.query;
            else data[`filter[${state.filter.field}][like]`] = state.filter.query;
            return data;
        }

    },

    actions: {

        load: async function (context, {endpoint, lazy, callback}) {
            Axois.abort();
            context.commit('loading', true);
            const response = await API[endpoint](context.getters.params);
            const data = response.data.data;
            const meta = response.data.meta;
            context.commit('loading', false);
            context.commit('pager:total', meta.total_count);
            context.commit('items:update', {data, lazy});
            callback && callback();
        }

    }

});