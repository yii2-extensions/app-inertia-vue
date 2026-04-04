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

    if (value === 'dark') {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }

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
        class="p-2 text-gray-400 hover:text-white rounded-md text-lg transition-colors cursor-pointer"
        :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
        @click="toggle"
    >{{ theme === 'dark' ? '&#9728;' : '&#127769;' }}</button>
</template>
