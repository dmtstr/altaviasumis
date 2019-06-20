// imports

import Axios from '@/common/axios';


// exports

export default {

    login (data) {
        return Axios.call({
            method: 'POST',
            url: '/auth/authenticate',
            data: data
        })
    },

    orders (filter) {
        return Axios.call({
            method: 'GET',
            url: '/items/orders',
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
            url: '/items/stocks',
            redirect: true,
            params: Object.assign({
                meta: '*',
                fields: '*.*',
                sort: '-modified_on'
            }, filter)
        })
    }

}