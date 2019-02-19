// ------------------
// imports
// ------------------

import Vue from 'vue'
import Router from 'vue-router'
import Session from '@/common/session'
import routeLogin from '@/components/routes/login.vue'
import routeOrders from '@/components/routes/orders.vue'
import routeStocks from '@/components/routes/stocks.vue'



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
// Exports
// ------------------

export default new Router({
    routes: [
        {
            path: '/',
            component: routeOrders,
            beforeEnter: login
        },
        {
            path: '/stocks',
            component: routeStocks,
            beforeEnter: login
        },
        {
            path: '/login',
            component: routeLogin
        }
    ]
})