// ------------------
// imports
// ------------------

import Vue from 'vue';
import Router from 'vue-router';
import Store from '@/common/store/index';
import Axios from '@/common/axios';

import routeLogin from '@/components/routes/login.vue';
import routeError from '@/components/routes/error.vue';
import routeDashboard from '@/components/routes/dashboard/index.vue';
import routeDashboardStock from '@/components/routes/dashboard/stock.vue';
import routeDashboardOrder from '@/components/routes/dashboard/order.vue';



// ------------------
// Setup
// ------------------

Vue.use(Router);



// ------------------
// Middleware
// ------------------

function login(to, from, next) {
    if (Store.state.session.auth) return next();
    next({name: 'login'});
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
        component: routeDashboard,
        beforeEnter: login,
        children: [
            {
                name: 'orders',
                path: '',
                component: routeDashboardOrder
            },
            {
                name: 'stocks',
                path: 'stocks',
                component: routeDashboardStock,
            }
        ]
    }


];



// ------------------
// Config
// ------------------

const router = new Router({
    routes: routes,
    linkActiveClass: '',
    linkExactActiveClass: 'active'
});



// ------------------
// Guards
// ------------------

router.beforeEach((to, from, next) => {
    Axios.abort();
    next();
});

router.afterEach(() => {
    Store.dispatch('loading', false);
});



// ------------------
// Export
// ------------------

export default router;