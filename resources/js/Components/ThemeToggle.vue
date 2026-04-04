<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const theme = ref('light')
const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)')

const getPreferred = () => {
    const stored = localStorage.getItem('theme')

    if (stored) {
        return stored
    }

    return mediaQuery.matches ? 'dark' : 'light'
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

const handleSystemThemeChange = (e) => {
    if (!localStorage.getItem('theme')) {
        apply(e.matches ? 'dark' : 'light')
    }
}

onMounted(() => {
    apply(getPreferred())
    mediaQuery.addEventListener('change', handleSystemThemeChange)
})

onUnmounted(() => {
    mediaQuery.removeEventListener('change', handleSystemThemeChange)
})
</script>

<template>
    <button
        class="p-2 text-gray-400 hover:text-white rounded-md text-lg transition-colors cursor-pointer"
        :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
        @click="toggle"
    >{{ theme === 'dark' ? '&#9728;' : '&#127769;' }}</button>
</template>
