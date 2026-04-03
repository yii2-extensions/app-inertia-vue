<script setup>
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    status: {
        type: Number,
        default: 500,
    },
    message: {
        type: String,
        default: 'An internal server error occurred.',
    },
})
</script>

<template>
    <Head :title="String(status)" />

    <div class="site-error d-flex align-items-center justify-content-center text-center">
        <div class="site-error-content mx-auto">
            <h1 class="display-1 fw-bold text-body-secondary mb-0">{{ status }}</h1>
            <h2 class="display-6 fw-semibold mb-3">{{ message }}</h2>
            <p class="text-body-secondary mb-4">
                The above error occurred while the Web server was processing your request.
                Please contact us if you think this is a server error. Thank you.
            </p>
            <Link href="/" class="btn btn-outline-primary btn-lg">Go to Homepage</Link>
        </div>
    </div>
</template>
