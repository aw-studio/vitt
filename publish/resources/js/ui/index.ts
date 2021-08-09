import Button from './Button.vue';

const plugin = {
    install(app: any) {
        app.component('UiButton', Button);
    },
};

export { plugin };