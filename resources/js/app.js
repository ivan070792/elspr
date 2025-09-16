import './bootstrap';

import { createApp } from 'vue';
import components from './Componenst/index';

const app = createApp({});
// В development режиме включаем DevTools
if (import.meta.env.DEV) {
    app.config.devtools = true;
    app.config.performance = true;
}
app.use(components);
app.mount('#app');
