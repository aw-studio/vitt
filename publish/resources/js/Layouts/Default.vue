<template>
    <Head>
        <title>VITT - Home</title>
        <meta name="description" content="The is the VITT home page" />
    </Head>
    <Header />
    <main>
        <slot />
    </main>
    <Footer />
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';

import Header from './../Partials/Header.vue';
import Footer from './../Partials/Footer.vue';

export default defineComponent({
    components: {
        Header,
        Footer,
    },
    props: {},
    setup() {
        //
    },
});
</script>
