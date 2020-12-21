import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from './views/Login.vue'
import Dashboard from './views/Dashboard.vue'

import firebase from "firebase/app"
import 'firebase/app'
import 'firebase/auth'

Vue.use(VueRouter)

const routes = [
    {
        path: "/login",
        name: "Login",
        component: Login
    },
    {
        path: "/",
        name: "Dashboard",
        component: Dashboard,
        meta: {
          requiresAuth: false
        },
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(x => x.meta.requiresAuth);

    if(requiresAuth) {
      firebase.auth().onAuthStateChanged( (user) => {
        if (!user) next('/login')
        else next();
      })
    } else next()
})

export default router