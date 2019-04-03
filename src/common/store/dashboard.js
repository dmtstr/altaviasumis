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
            state.filter.query = null;
            state.filter.field = null;
            return dispatch('flip', 1);
        },

        activate({state}, item) {
            state.data.active = item;
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
            console.log(state.pager.offset);
        },

        lazy ({state, dispatch}, value) {
            state.data.lazy = value;
            state.filter.offset = state.filter.offset + state.filter.limit * value;
            return dispatch('load');
        },
        

        // load

        load ({state, dispatch, getters}) {

            Axios.abort();
            dispatch('loading', true, {root: true});

            return API[state.route](getters.filterParams).then(response => {

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