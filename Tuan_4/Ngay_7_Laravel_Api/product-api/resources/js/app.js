import { createApp } from 'vue'
import App from './components/App.vue'
import router from './router'
import axios from 'axios'
import 'bootstrap/dist/css/bootstrap.min.css';


axios.defaults.withCredentials = true
axios.defaults.baseURL = 'http://localhost:8000' // sửa cho đúng host API

const app = createApp(App)
app.use(router)
app.mount('#app')
