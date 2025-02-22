import './bootstrap';
import '../css/app.css';
import {createApp} from "vue";
import Login from "./pages/Login.vue";

const app = createApp({})
createApp(Login).mount('#app');
