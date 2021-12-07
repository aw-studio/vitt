<template>
    <component :is="tag" :target="target">
        <slot />
    </component>
</template>

<script setup lang="ts">
import { useAttrs } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
const attrs = useAttrs();
const props = defineProps({
    target: {
        type: String,
        default: null,
    },
    disabled: Boolean,
    primary: Boolean,
    secondary: Boolean,
    sm: Boolean,
});

const tag = 'href' in attrs ? Link : 'button';
</script>
