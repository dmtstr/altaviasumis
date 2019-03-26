// ------------------
// imports
// ------------------

import axios from 'axios';
import Session from '@/common/session';
import Router from '@/common/router';



// ------------------
// Instance
// ------------------

const API = axios.create({
    baseURL: API_ORIGIN
});



// ------------------
// Interceptor
// ------------------

API.interceptors.response.use(undefined, function(error) {
    if (axios.isCancel(error)) {
        error.message = null;
    }
    else if (error.request && error.request.status === 401) {
        error.message = null;
        Session.destroy();
        Router.push('/login')
    }
    else {
        error.message = error.response && error.response.data && error.response.data.error.message || error.message;
    }
    return Promise.reject(error);
});



// ------------------
// Canceler
// ------------------

const CancelToken = axios.CancelToken;
let requests = [];

function canceler() {
    return {
        cancelToken: new CancelToken(c => requests.push(c))
    }
}



// ------------------
// Helpers
// ------------------

function filter(query, field) {
    if (!field && !query) return '';
    if (!field) return `&q=${query}`;
    return `&filter[${field}][like]=${query}`;
}



// ------------------
// Exports
// ------------------

export default {

    login (data) {
        return API.post('/auth/authenticate', data, canceler());
    },

    orders (query, field) {
        return API.get(`/items/orders?fields=*.*${filter(query, field)}&meta=*`, canceler());
    },

    stocks (query, field) {
        return API.get(`/items/stocks?fields=*.*${filter(query, field)}&meta=*`, canceler());
    },

    abort () {
        requests.forEach(cancel => cancel());
        requests.length = 0;
    }

}