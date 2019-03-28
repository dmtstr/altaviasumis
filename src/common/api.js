// imports

import Axios from '@/common/axios';


// helpers

function params(filter, defaults) {
    if (!filter || !filter.field && !filter.query) return defaults;
    if (!filter.field) defaults.q = filter.query;
    else defaults[`filter[${filter.field}][like]`] = filter.query;
    return defaults;
}


// exports

export default {

    login (data) {
        return Axios.call({
            method: 'POST',
            url: '/auth/authenticate',
            data: data
        })
    },

    orders (filter, offset) {
        return Axios.call({
            method: 'GET',
            url: '/items/orders',
            redirect: true,
            params: params(filter, {
                meta: '*',
                fields: '*.*',
                offset: offset
            })
        })

    },

    stocks (filter) {
        return Axios.call({
            method: 'GET',
            url: '/items/stocks',
            redirect: true,
            params: params(filter, {
                meta: '*',
                fields: '*.*',
            })
        })
    }

}