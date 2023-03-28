import './assets/scss/main.scss';
import 'element-plus/dist/index.css';

import { createApp } from 'vue';

import ElementPlus from 'element-plus';
import { createPinia } from 'pinia';

import App from '@/App.vue';
import $API from '@/plugins/axios';
import FontAwesomeIcon from '@/plugins/font-awesome';
import addInterceptors from '@/plugins/interceptors';
import router from '@/router';

const app = createApp(App);

app.config.globalProperties.$API = $API;

app.component('FontAwesomeIcon', FontAwesomeIcon);
app.use(ElementPlus)
app.use(createPinia())
app.use(router)
addInterceptors($API, router);

app.mount('#app')
