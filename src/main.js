// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import VueBlu from 'vue-blu'
import 'vue-blu/dist/css/vue-blu.min.css'
import App from './App'
import router from './router'
import store from './vuex'

Vue.use(VueBlu)

Vue.config.productionTip = false

const eventHub = new Vue() // event hub
Vue.prototype.$bus = eventHub

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
