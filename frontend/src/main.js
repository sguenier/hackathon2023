import './assets/scss/main.scss';
import 'element-plus/dist/index.css';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

import { createApp } from 'vue';

import ElementPlus from 'element-plus';
import { createPinia } from 'pinia';
import VueFeather from 'vue-feather';

import App from '@/App.vue';
import $API from '@/plugins/axios';
import addInterceptors from '@/plugins/interceptors';
import router from '@/router';
import { useAuthStore } from '@/store/authStore';
import { QuillEditor } from '@vueup/vue-quill';

const app = createApp(App);

app.config.globalProperties.$API = $API;

app.component(VueFeather.name, VueFeather);
app.use(ElementPlus)
app.component('QuillEditor', QuillEditor);
app.use(createPinia())
app.use(router)
addInterceptors($API, router);

app.mount('#app');

const authStore = useAuthStore();

authStore.init();
