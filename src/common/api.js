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
// Exports
// ------------------

export default {

    login (data) {
        return API.post('/auth/authenticate', data, canceler());
    },

    orders () {
        return API.get('/items/messages', canceler());
    },

    createOrder () {
        return API.post(API_ORIGIN + '/api/orders', canceler());
    },

    stocks () {
        return API.get(API_ORIGIN + '/api/stocks', canceler());
    },

    abort () {
        requests.forEach(cancel => cancel());
        requests.length = 0;
    }

}