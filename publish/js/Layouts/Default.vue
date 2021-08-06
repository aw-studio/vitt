<template>
    <Header/>
    <main>
        <slot />
    </main>
    <Footer />
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import Header from './../Partials/Header.vue'
import Footer from './../Partials/Footer.vue'

export default defineComponent({
    components: {
        Header,
        Footer
    },
    props: {},
    setup() {
        //
    },
});
</script>
