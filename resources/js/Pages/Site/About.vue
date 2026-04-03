<script setup>
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
    <Head title="About" />

    <div class="site-about d-flex align-items-center justify-content-center text-center">
        <div class="site-about-content mx-auto">
            <h1 class="display-6 fw-semibold mb-3">This is the About page.</h1>

            <p class="text-body-secondary mb-4">
                You may modify the following file to customize its content:
                <code class="d-block mt-2">resources/js/Pages/Site/About.vue</code>
            </p>

            <Link href="/" class="btn btn-outline-primary btn-lg">Go to Homepage</Link>
        </div>
    </div>
</template>
