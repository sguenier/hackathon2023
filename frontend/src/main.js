import './assets/main.css';

import { createApp } from 'vue';

import { createPinia } from 'pinia';

import App from '@/App.vue';
import $API from '@/plugins/axios';
import FontAwesomeIcon from '@/plugins/font-awesome';
import addInterceptors from '@/plugins/interceptors';
import router from '@/router';

const app = createApp(App);

app.config.globalProperties.$API = $API;

app.component('FontAwesomeIcon', FontAwesomeIcon);
app.use(createPinia())
app.use(router)
addInterceptors($API, router);

app.mount('#app')
