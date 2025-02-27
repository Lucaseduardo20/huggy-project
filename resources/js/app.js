import './bootstrap';
import '../css/app.css';
import {createApp} from "vue";
import App from "./App.vue";
import router from "./router/index.ts";
import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'
import { createVfm } from 'vue-final-modal'

const app = createApp(App)
    .use(router)
    .use(VueGoodTablePlugin)
    .use(createVfm())
    .mount('#app');
