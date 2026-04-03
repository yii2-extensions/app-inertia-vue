<script setup>
import { ref, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const alerts = ref([])

const typeMap = {
    success: 'alert-success',
    error: 'alert-danger',
    danger: 'alert-danger',
    info: 'alert-info',
    warning: 'alert-warning',
}

watch(
    () => page.props.flash,
    (flash) => {
        if (!flash || typeof flash !== 'object') {
            return
        }

        alerts.value = Object.entries(flash)
            .filter(([, message]) => message)
            .map(([type, message]) => ({
                id: Date.now() + Math.random(),
                type,
                cssClass: typeMap[type] || 'alert-info',
                message,
            }))
    },
    { immediate: true, deep: true },
)

const dismiss = (id) => {
    alerts.value = alerts.value.filter((a) => a.id !== id)
}
</script>

<template>
    <div v-for="alert in alerts" :key="alert.id" :class="['alert', alert.cssClass, 'alert-dismissible', 'fade', 'show']" role="alert">
        {{ alert.message }}
        <button type="button" class="btn-close" aria-label="Close" @click="dismiss(alert.id)"></button>
    </div>
</template>
