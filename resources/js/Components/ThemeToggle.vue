<script setup>
import { onMounted, onUnmounted, ref } from "vue";

const theme = ref("light");
let mediaQuery;

const apply = (value, persist = true) => {
    theme.value = value;
    document.documentElement.classList.toggle("dark", value === "dark");

    if (persist) {
        localStorage.setItem("theme", value);
    }
};

const toggle = () => {
    apply(theme.value === "dark" ? "light" : "dark");
};

const handleSystemThemeChange = (event) => {
    if (!localStorage.getItem("theme")) {
        apply(event.matches ? "dark" : "light", false);
    }
};

onMounted(() => {
    mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");

    const stored = localStorage.getItem("theme");
    const preferred = stored ?? (mediaQuery.matches ? "dark" : "light");

    apply(preferred, Boolean(stored));
    mediaQuery.addEventListener("change", handleSystemThemeChange);
});

onUnmounted(() => {
    mediaQuery?.removeEventListener("change", handleSystemThemeChange);
});
</script>

<template>
    <button
        type="button"
        class="theme-switch"
        :aria-label="
            theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'
        "
        :title="theme === 'dark' ? 'Use light mode' : 'Use dark mode'"
        @click="toggle"
    >
        <span class="theme-switch__label">
            {{ theme === "dark" ? "Light" : "Dark" }}
        </span>
        <span class="theme-switch__track" aria-hidden="true">
            <span
                :class="{ 'theme-switch__thumb--dark': theme === 'dark' }"
            ></span>
        </span>
    </button>
</template>
