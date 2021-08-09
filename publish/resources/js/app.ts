import { createApp, h } from 'vue';
import {
    App as InertiaApp,
    plugin as InertiaPlugin,
} from '@inertiajs/inertia-vue3';

const el = document.getElementById('app');

if (el) {
    const app = createApp({
        render: () =>
            h(InertiaApp, {
                initialPage: JSON.parse(el.dataset.page as string),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            }),
    })
        .use(InertiaPlugin);

    app.mount(el);

}