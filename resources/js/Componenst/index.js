import { defineAsyncComponent } from 'vue';

const components = import.meta.glob('./**/*.vue');

export default {
    install(app) {
        for (const [path, component] of Object.entries(components)) {
            const name = path
                .split('/')
                .pop()
                .replace(/\.\w+$/, '');

            app.component(name, defineAsyncComponent(component));
        }
    }
};
