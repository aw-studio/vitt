import { createApp, h } from 'vue';
import {
    App as InertiaApp,
    plugin as InertiaPlugin,
} from '@inertiajs/inertia-vue3';
import DefaultLayout from './Layouts/Default.vue';
import Components from './components'

const el = document.getElementById('app');

if (el instanceof HTMLElement) {
    /**
     * Create a new Inertia App
     * 
     */
    const app = createApp({
        render: () =>
            h(InertiaApp, {
                initialPage: JSON.parse(el.dataset.page as string),
                resolveComponent: (name) => {
                    const page = require(`./Pages/${name}`).default
                    page.layout = page.layout || DefaultLayout
                    return page
                },
            }),
    });
    
    /**
     * Load Plugins
     * 
     */
    app.use(InertiaPlugin);
    app.use(Components);
    
    /**
     * Mount the app in the app container
     * 
     */
    app.mount(el);
}