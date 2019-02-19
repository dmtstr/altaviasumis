import Vue from 'vue'
import Router from 'vue-router'
import routeLogin from '@/components/routes/login.vue'

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/login',
            component: routeLogin
        }
    ]
})