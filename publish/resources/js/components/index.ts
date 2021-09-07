import { Plugin } from 'vue';
import Button from './Ui/Button.vue';
import Head from './App/Head.vue';

const plugin = {
    install(app) {
        /**
         * UI-Components
         */
        app.component('UiButton', Button);

        /**
         * App-Components
         */
        app.component('AppHead', Head);
    },
} as Plugin;

export default plugin ;
