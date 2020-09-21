import Vue from 'vue'
import VueMeta from 'vue-meta'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import App from './App.vue'
import router from './router'
import store from './store'

import DefaultLayout from './layouts/DefaultLayout.vue'
import ErrorLayout from './layouts/ErrorLayout.vue'
import HomeLayout from './layouts/HomeLayout.vue'

Vue.use(VueMeta, {
    refreshOnceOnNavigation: true,
})

library.add(fas, far, fab)
Vue.component('FontAwesomeIcon', FontAwesomeIcon)
Vue.component('DefaultLayout', DefaultLayout)
Vue.component('ErrorLayout', ErrorLayout)
Vue.component('HomeLayout', HomeLayout)

store.dispatch('auth/setUser', window.currentUser)
const vm = new Vue({
    router,
    store,
    render: (h) => h(App),
}).$mount('#app')

console.log(vm)
