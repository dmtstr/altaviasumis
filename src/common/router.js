// ------------------
// imports
// ------------------

import Vue from 'vue'
import Router from 'vue-router'
import Session from '@/common/session'
import API from '@/common/api'
import Event from '@/common/event'
import routeLogin from '@/components/routes/login.vue'
import routeOrders from '@/components/routes/orders.vue'
import routeStocks from '@/components/routes/stocks.vue'

import routeDashboard from '@/components/routes/dashboard.vue'
import routeDashboardStock from '@/components/routes/dashboard/stock.vue'
import routeDashboardOrder from '@/components/routes/dashboard/order.vue'



// ------------------
// Config
// ------------------

Vue.use(Router);



// ------------------
// Middleware
// ------------------

function login(to, from, next) {
    if (Session.exist()) return next();
    next('/login');
}



// ------------------
// Routes
// ------------------

const routes = [
    // {
    //     path: '/',
    //     component: routeOrders,
    //     beforeEnter: login
    // },
    // {
    //     path: '/stocks',
    //     component: routeStocks,
    //     beforeEnter: login
    // },


    {
        path: '/login',
        component: routeLogin
    },
    {
        path: '/',
        component: routeDashboard,
        beforeEnter: login,
        children: [
            {
                path: '',
                component: routeDashboardOrder,
                props: {test: 'orders'}
            },
            {
                path: 'stocks',
                component: routeDashboardStock,
                props: {test: 'stocks'}
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
    Event.$emit('loading', false);
    API.abort();
    setTimeout(next, 0);
});



// ------------------
// Exports
// ------------------

export default router