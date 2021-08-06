<template>
    <header>
        <nav></nav>
    </header>
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";
import { Link, usePage } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        Link,
    },
    setup(){
        /**
         * Main naviagtion items from 
         */
        const mainNavigation = computed(
            () => usePage().props.value.mainNavigation
        );
        return {
            mainNavigation
        };
    }
});
</script>
