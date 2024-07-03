import "./bootstrap";

import { createApp } from "vue";
import App from "./src/App.vue";
import router from "./src/router";
import ToastPlugin from "vue-toast-notification";

import 'vue-toast-notification/dist/theme-bootstrap.css'
import '../vendor/bootstrap/bootstrap.css'
import '../vendor/bootstrap/bootstrap-icons.css'
import '../vendor/bootstrap/bootstrap.js'

createApp(App)
.use(router)
.use(ToastPlugin)
.mount("#app");
