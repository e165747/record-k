import '../css/style.scss'
import _ from 'lodash'
import { createWebHistory, createRouter } from 'vue-router'
import vuetify from '../../plugins/vuetify'

declare global {
  interface Window { _: typeof _ }
}
window._ = _

import axios from 'axios'
declare global {
  interface Window { axios: typeof axios }
}
window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

import { createApp } from 'vue'
import App from './components/pages/App.vue'
import Login from './components/pages/Login.vue'
import Home from './components/pages/home/Home.vue'

const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
]

const router = createRouter({
  history: createWebHistory(),
  // history: createMemoryHistory(),
  routes,
})

const app = createApp(App)
  .use(router)
  .use(vuetify) // Vuetify を使用するように追加

// 本当は↑だが，一旦ログイン画面にしておく
// const app = createApp(Login).use(router).use(vuetify)

console.log(app.version)

app.mount('#app')
