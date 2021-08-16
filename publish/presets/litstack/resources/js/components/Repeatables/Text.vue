<template>
    <div class="container">
        {{ repeatable.text }}
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
export default defineComponent({
    props: {
        repeatable: {
            type: Object,
        },
    },
    setup(props) {},
});
</script>
