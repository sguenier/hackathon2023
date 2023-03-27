import './assets/main.css';

import { createApp } from 'vue';

import { createPinia } from 'pinia';

import App from '@/App.vue';
import $API from '@/plugins/axios';
import addInterceptors from '@/plugins/interceptors';
import router from '@/router';

const app = createApp(App);

app.config.globalProperties.$API = $API;

app.use(createPinia())
app.use(router)
addInterceptors($API, router);

app.mount('#app')
