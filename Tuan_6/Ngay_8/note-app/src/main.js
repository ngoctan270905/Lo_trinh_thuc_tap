import { createApp } from 'vue'
import App from './App.vue'

// Vuetify
import { vuetify } from './plugins/vuetify' // ✅ chỉ dùng 1 lần

// Router
import router from './router'

const app = createApp(App)
app.use(router)
app.use(vuetify)
app.mount('#app')
