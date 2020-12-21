import Vue from 'vue'
import coreui from '@coreui/coreui'

import router from './router'
import "./firebase"
import store from "./store"

import '../sass/app.scss'

Vue.config.productionTip = false

new Vue({
  router,
  store,
  coreui,
}).$mount('#app')
