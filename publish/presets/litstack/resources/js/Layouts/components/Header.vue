<template>
    <header class="py-3 bg-gray-100">
        <div class="container flex justify-between items-center">
            <div>Logo</div>
            <nav>
                <Localize />
            </nav>
        </div>
    </header>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue';
import { Link, usePage } from '@inertiajs/inertia-vue3';
import Localize from './Localize.vue';
export default defineComponent({
    components: {
        Link,
        Localize,
    },
    setup() {
        /**
         * Main naviagtion items from
         */
        const mainNavigation = computed(
            () => usePage().props.value.mainNavigation
        );
        return {
            mainNavigation,
        };
    },
});
</script>
