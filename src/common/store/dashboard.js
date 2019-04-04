import Vue from 'vue'
import API from '@/common/api'
import Axios from '@/common/axios'
import Util from '@/common/util'


export default {

    namespaced: true,



    // ------------------
    // State
    // ------------------

    state: {

        route: null,
        create: false,

        pager: {
            total: 0,
            active: 1,
            offset: 0
        },

        filter: {
            limit: 20,
            offset: 0,
            query: null,
            field: null
        },

        data: {
            lazy: false,
            active: 0,
            items: []
        }

    },



    // ------------------
    // Getters
    // ------------------

    getters: {


        // common

        route ({route}) {
            return route;
        },

        creating ({create}) {
            return create;
        },


        // filter

        filterParams ({filter}) {
            let data = {};
            data.offset = filter.offset;
            data.limit = filter.limit;
            if (!filter.field && !filter.query) return data;
            if (!filter.field) data.q = filter.query;
            else data[`filter[${filter.field}][like]`] = filter.query;
            return data;
        },

        filterQuery ({filter}) {
            return filter.query;
        },

        filterField ({filter}) {
            return filter.field || '';
        },


        // pager

        pagerCurrent ({pager}) {
            return pager.active + pager.offset;
        },

        pagerTotal ({pager}) {
            return pager.total
        },

        pagerPages ({pager}, getters) {
            const current = getters.pagerCurrent;
            if (current < 3) return Util.range(1, Math.min(pager.total, 3));
            if (current > pager.total - 2) return Util.range(pager.total - 2, pager.total);
            return Util.range(current - 1, current + 1);
        },


        // data

        dataChunk({data, filter}) {
            return Util.chunk(data.items, filter.limit);
        },

        dataLazy ({data}) {
            return data.lazy
        },

        dataActive ({data}) {
            return data.active
        }


    },



    // ------------------
    // Actions
    // ------------------

    actions: {

        init ({state, dispatch}, route) {
            state.route = route;
            state.data.lazy = 0;
            return dispatch('load', true).then(() => {
                state.create = false;
                state.filter.query = null;
                state.filter.field = null;
                state.filter.offset = 0;
                state.pager.active = 1;
                state.pager.offset = 0;
            })
        },

        activate({state, dispatch}, item) {
            state.data.active = item;
            dispatch('create', false);
        },

        flip ({state, dispatch}, number) {
            state.pager.active = number;
            state.pager.offset = 0;
            state.data.lazy = 0;
            state.filter.offset = (number - 1) * state.filter.limit;
            return dispatch('load');
        },

        filter ({state, dispatch}, {query, field}) {
            query && (state.filter.query = query);
            field && (state.filter.field = field);
            return dispatch('flip', 1);
        },

        move ({state}, offset) {
            state.pager.offset = offset;
        },

        lazy ({state, dispatch}, value) {
            state.data.lazy = value;
            state.filter.offset = state.filter.offset + state.filter.limit * value;
            return dispatch('load');
        },

        create ({state}, value) {
            state.create = value;
        },
        

        // load

        load ({state, dispatch, getters}, blank) {

            Axios.abort();
            dispatch('loading', true, {root: true});
            const params = blank ? {limit: state.filter.limit} : getters.filterParams;

            return API[state.route](params).then(response => {

                const items = response.data.data;
                const meta = response.data.meta;

                state.pager.total = Math.ceil(meta.total_count / state.filter.limit);

                if (state.data.lazy === 1) {
                    state.data.items = state.data.items.concat(items);
                }
                if (state.data.lazy === -1) {
                    state.pager.active = state.pager.active -1;
                    state.data.items = items.concat(state.data.items);
                }
                if (!state.data.lazy) {
                    state.data.items = items;
                    state.data.active = items[0];
                }

                dispatch('loading', false, {root: true});

            });

        }

    }

}