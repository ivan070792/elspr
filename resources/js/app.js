import './bootstrap';

import { createApp } from 'vue';
import ElsprFormPage from './Componenst/Documents/ElsprFormPage.vue';

const app = createApp({});

// Регистрация глобальных компонентов
app.component('elspr-form-page', ElsprFormPage);

// Монтируем Vue приложение
app.mount('#app');
