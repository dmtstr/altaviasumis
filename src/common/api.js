// ------------------
// imports
// ------------------

import axios from 'axios';
import Session from '@/common/session';
import Router from '@/common/router';



// ------------------
// Interceptor
// ------------------

axios.interceptors.response.use(undefined, function(error) {
    if (axios.isCancel(error)) {
        error.message = null;
    }
    else if (error.request && error.request.status === 401) {
        error.message = null;
        Session.destroy();
        Router.push('/login')
    }
    else {
        error.message = error.response && error.response.data && error.response.data.status && error.response.data.status.error || error.message;
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
        return axios.post('/api/login', data, canceler());
    },

    orders () {
        return axios.get('/api/orders', canceler());
    },

    createOrder () {
        return axios.post('/api/orders', canceler());
    },

    stocks () {
        return axios.get('/api/stocks', canceler());
    },

    abort () {
        requests.forEach(cancel => cancel());
        requests.length = 0;
    }

}