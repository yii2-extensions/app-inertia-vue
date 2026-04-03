<script setup>
import { ref, onMounted } from 'vue'

const theme = ref('light')

const getPreferred = () => {
    const stored = localStorage.getItem('theme')

    if (stored) {
        return stored
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
}

const apply = (value) => {
    theme.value = value
    document.documentElement.setAttribute('data-bs-theme', value)
    localStorage.setItem('theme', value)
}

const toggle = () => {
    apply(theme.value === 'dark' ? 'light' : 'dark')
}

onMounted(() => {
    apply(getPreferred())

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.getItem('theme')) {
            apply(e.matches ? 'dark' : 'light')
        }
    })
})
</script>

<template>
    <button
        class="btn btn-link nav-link fs-5"
        :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
        @click="toggle"
    >{{ theme === 'dark' ? '&#9728;' : '&#127769;' }}</button>
</template>
