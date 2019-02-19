// ------------------
// imports
// ------------------

import axios from 'axios';



// ------------------
// Interceptor
// ------------------

function success(response) {
    return response;
}

function failure(error) {
    error.message = error.response.data && error.response.data.status && error.response.data.status.error || error.message;
    return Promise.reject(error);
}

axios.interceptors.response.use(success, failure);



// ------------------
// Exports
// ------------------

export default {

    login (data) {
        return axios.post('/api/login', data);
    },

    orders () {
        console.log(axios.defaults.headers.common['Authorization'])
        return axios.post('/api/api/orders');
    }

}