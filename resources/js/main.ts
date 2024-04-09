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
import Home from './components/pages/Home.vue'

const app = createApp(Home);

console.log(app.version);

app.mount('#app');