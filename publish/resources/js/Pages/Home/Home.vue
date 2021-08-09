<template>
    <h1 class="text-2xl text-blue-900">{{ message }}</h1>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import DefaultLayout from '../../Layouts/Default.vue';
export default defineComponent({
    layout: DefaultLayout,
    props: {
        message: {
            type: String as PropType<string>,
            required: true,
        },
    },
    setup(props) {
        console.log(props.message);
    },
});
</script>
