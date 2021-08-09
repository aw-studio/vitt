import Button from './Ui/Button.vue';
import Head from './App/Head.vue';

const plugin = {
    install(app: any) {
        /**
         * UI-Components
         */
        app.component('UiButton', Button);
        /**
         * App-Components
         */
        app.component('AppHead', Head);
    },
};

export default plugin ;