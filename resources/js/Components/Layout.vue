<script setup>
import Navbar from './Navbar.vue'
import Footer from './Footer.vue'
import FlashMessages from './FlashMessages.vue'
</script>

<template>
    <div class="d-flex flex-column min-vh-100">
        <Navbar />

        <main id="main" class="flex-grow-1" role="main">
            <div class="container">
                <FlashMessages />
                <slot />
            </div>
        </main>

        <Footer />
    </div>
</template>
