import 'bootstrap/dist/css/bootstrap.css'
import _ from 'lodash';
declare global {
  interface Window { _: typeof _; }
}
window._ = _;

import axios from 'axios';
declare global {
  interface Window { axios: typeof axios; }
}
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import { createApp } from 'vue';
import Login from './components/pages/Login.vue';

const app = createApp(Login);

console.log(app.version);

app.mount('#app');