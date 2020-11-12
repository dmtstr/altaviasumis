// imports

import Axios from '@/common/axios';


// exports

export default {

    login (data) {
        return Axios.call({
            // method: 'POST',
            // url: '/auth/authenticate',
            method: 'GET',
            url: '/auth.json',
            data: data
        })
    },

    orders (filter) {
        return Axios.call({
            method: 'GET',
            // url: '/items/orders',
            url: `/orders_offset${filter.offset || 0}.json`,
            redirect: true,
            params: Object.assign({
                meta: '*',
                fields: '*.*',
                sort: '-order_date'
            }, filter)
        })
    },

    stocks (filter) {
        return Axios.call({
            method: 'GET',
            // url: '/items/stocks',
            url: `/stocks_offset${filter.offset || 0}.json`,
            redirect: true,
            params: Object.assign({
                meta: '*',
                fields: '*.*',
                sort: '-modified_on'
            }, filter)
        })
    }

}