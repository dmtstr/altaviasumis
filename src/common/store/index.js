// ------------------
// Imports
// ------------------

import Vue from 'vue'
import Vuex from 'vuex'

import session from './session';
import dashboard from './dashboard';



// ------------------
// Connect
// ------------------

Vue.use(Vuex);



// ------------------
// Exports
// ------------------

export default new Vuex.Store({

    modules: {
        session,
        dashboard
    },

    state: {

        loading: false

    },

    actions: {

        loading ({state}, value) {
            state.loading = value;
        }

    }

});