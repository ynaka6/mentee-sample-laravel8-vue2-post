import Vue from 'vue'
import VueMeta from 'vue-meta'
import App from './App.vue'
import router from './router'
import store from './store'

import DefaultLayout from './layouts/DefaultLayout.vue'
import ErrorLayout from './layouts/ErrorLayout.vue'
import HomeLayout from './layouts/HomeLayout.vue'

Vue.use(VueMeta, {
    refreshOnceOnNavigation: true,
})

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
