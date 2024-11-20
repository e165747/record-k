import '../css/style.scss'
import _ from 'lodash'
import { createWebHistory, createRouter } from 'vue-router'
import vuetify from '../../plugins/vuetify'
import '@mdi/font/css/materialdesignicons.min.css'
import store from './store/share/index'

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
import Author from './components/pages/author/Author.vue'

const routes = [
  { path: '/', component: RecordsDashboard },
  { path: '/login', component: Login },
  { path: '/artists', component: Author },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// 全てのリクエスト時にstore共通処理を実行
axios.interceptors.request.use(
  config => {
    store.dispatch('loading/startLoading')
    return config
  },
)
// ログインしていない場合はログイン画面にリダイレクト
axios.interceptors.response.use(
  response => {
    store.dispatch('loading/endLoading')
    return response
  },
  error => {
    if (error.response.status === 401) {
      router.push('/login')
    }
    store.dispatch('loading/endLoading')
    return Promise.reject(error)
  }
)

const app = createApp(App)
  .use(router)
  .use(vuetify)
  .use(store)

console.log(app.version)

app.mount('#app')
