// ------------------
// imports
// ------------------

import Vue from 'vue';
import Router from 'vue-router';
import Store from '@/common/store';
import Axios from '@/common/axios';

import routeLogin from '@/components/routes/login.vue';
import routeError from '@/components/routes/error.vue';
import routeHome from '@/components/routes/home.vue';
import routeStock from '@/components/routes/stock.vue';
import routeOrder from '@/components/routes/order.vue';



// ------------------
// Config
// ------------------

Vue.use(Router);



// ------------------
// Middleware
// ------------------

function login(to, from, next) {
    if (Store.state.auth) return next();
    next('/login');
}



// ------------------
// Routes
// ------------------

const routes = [

    {
        name: 'login',
        path: '/login',
        component: routeLogin
    },
    {
        name: 'error',
        path: '/error',
        props: true,
        component: routeError
    },
    {
        path: '/',
        component: routeHome,
        beforeEnter: login,
        children: [
            {
                name: 'orders',
                path: '',
                component: routeOrder
            },
            {
                name: 'stocks',
                path: 'stocks',
                component: routeStock,
            }
        ]
    }


];



// ------------------
// Router
// ------------------

let router = new Router({routes});



// ------------------
// Listeners
// ------------------

router.beforeEach((to, from, next) => {
    Axios.abort();
    Store.commit('loading', false);
    next();
});



// ------------------
// Exports
// ------------------

export default router