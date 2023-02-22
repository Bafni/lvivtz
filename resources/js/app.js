import './bootstrap';
import {createApp} from 'vue'
import App from './App.vue'
import '../css/app.css'

const app = createApp(App)
//app.use(axios)
app.mount("#app")
