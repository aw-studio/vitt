<template>
    <DefaultLayout>
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempora minima labore provident saepe laudantium vel ratione aspernatur consequuntur voluptate pariatur blanditiis ut molestiae debitis necessitatibus eveniet rem, eum ullam ipsum?
    </DefaultLayout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import DefaultLayout from '../../Layouts/Default.vue';
export default defineComponent({
    components: {
        DefaultLayout,
    },
    props: {
        form: {
            type: Object,
            required: true,
        },
    },
    setup(props) {
       //
    },
});
</script>
