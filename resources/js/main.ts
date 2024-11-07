import '../css/style.scss'
import _ from 'lodash'
import { createWebHistory, createRouter } from 'vue-router'
import vuetify from '../../plugins/vuetify'
import '@mdi/font/css/materialdesignicons.min.css'

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
import RecordsDashboard from './components/pages/home/RecordsDashboard.vue'

const routes = [
  { path: '/', component: RecordsDashboard },
  { path: '/login', component: Login },
]

const router = createRouter({
  history: createWebHistory(),
  // history: createMemoryHistory(),
  routes,
})

// ログインしていない場合はログイン画面にリダイレクト
axios.interceptors.response.use(
  response => response,
  error => {
    if (error.response.status === 401) {
      router.push('/login')
    }
    return Promise.reject(error)
  }
)

const app = createApp(App)
  .use(router)
  .use(vuetify)

console.log(app.version)

app.mount('#app')
