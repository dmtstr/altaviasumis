// ------------------
// imports
// ------------------

import axios from 'axios';



// ------------------
// Interceptor
// ------------------

axios.interceptors.response.use(undefined, function(error) {
    if (axios.isCancel(error)) error.message = null;
    else error.message = error.response && error.response.data && error.response.data.status && error.response.data.status.error || error.message;
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
        return axios.get('/api/api/orders/', canceler());
    },

    stocks () {
        return axios.get('/api/api/stocks/', canceler());
    },

    abort () {
        requests.forEach(cancel => cancel());
        requests.length = 0;
    }

}