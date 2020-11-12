// ------------------
// Imports
// ------------------

import axios from 'axios';
import Store from '@/common/store/index';
import Router from '@/common/router';



// ------------------
// Instance
// ------------------

const API = axios.create({
    // baseURL: API_ORIGIN,
    baseURL: '/api'
});



// ------------------
// Helpers
// ------------------

const code = error => {
    if (!error.response) return error.request.status;
    if (!error.response.data) return error.response.status;
    return error.response.data.error.code;
};

const message = error => {
    if (error.response && error.response.data) return error.response.data.error.message;
    return error.message;
};



// ------------------
// Interceptors
// ------------------

API.interceptors.response.use(undefined, function(data) {

    if (axios.isCancel(data)) return Promise.reject(null);

    if (data.response && data.response.status === 401) {
        Store.dispatch('session/destroy');
        Router.push({name: 'login'});
        return Promise.reject(null);
    }

    let error = {};
    error.code = code(data);
    error.message = message(data);

    if (data.config.redirect) {
        Router.push({name: 'error', params: {error}});
        return Promise.reject(null);
    }

    return Promise.reject(error);

});



// ------------------
// Exports
// ------------------

export default {
    
    canceller: axios.CancelToken.source(),

    call (config) {
        return API(Object.assign(config, {
            cancelToken: this.canceller.token,
            headers: {
                'Authorization': 'Bearer ' + Store.state.session.auth
            }
        }))
    },

    abort () {        
        this.canceller.cancel();
        this.canceller = axios.CancelToken.source();
        
    }

}