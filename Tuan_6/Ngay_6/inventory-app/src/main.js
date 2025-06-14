// src/main.js
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import autoSavePlugin from './stores/plugins'

const app = createApp(App)
const pinia = createPinia()
pinia.use(autoSavePlugin)

app.use(pinia)
app.mount('#app')
