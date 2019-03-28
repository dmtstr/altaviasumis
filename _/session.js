import axios from 'axios';

export default {

    create (token) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        window.localStorage.setItem('token', token);
    },

    destroy () {
        axios.defaults.headers.common['Authorization'] = null;
        window.localStorage.removeItem('token');
    },

    exist () {
        return !!window.localStorage.getItem('token');
    },

    restore () {
        let token = window.localStorage.getItem('token');
        if (token) this.create(token);
    }

}