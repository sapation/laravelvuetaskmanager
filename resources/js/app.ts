import "./bootstrap";

import { createApp } from "vue";
import App from "./src/App.vue";
import router from "./src/router";
import ToastPlugin from "vue-toast-notification";
import { createPinia } from "pinia";

import 'vue-toast-notification/dist/theme-bootstrap.css'
import '../vendor/bootstrap/bootstrap.css'
import '../vendor/bootstrap/bootstrap-icons.css'
import '../vendor/bootstrap/bootstrap.js'

// components 
import Error from "./src/components/Error.vue";
import BaseBtn from "./src/components/BaseBtn.vue";
import BaseInput from "./src/components/BaseInput.vue";

createApp(App)
.use(createPinia())
.use(router)
.use(ToastPlugin)
.component('Error', Error)
.component('BaseInput', BaseInput)
.component('BaseBtn', BaseBtn)
.mount("#app");
