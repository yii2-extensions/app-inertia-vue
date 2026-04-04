<script setup>
import { ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { FwbAlert } from "flowbite-vue";

const page = usePage();
const alerts = ref([]);

const typeMap = {
    success: "success",
    error: "danger",
    danger: "danger",
    info: "info",
    warning: "warning",
};

watch(
    () => page.props.flash,
    (flash) => {
        if (!flash || typeof flash !== "object") {
            return;
        }

        alerts.value = Object.entries(flash)
            .filter(([, message]) => message)
            .map(([type, message]) => ({
                id: crypto.randomUUID(),
                type: typeMap[type] || "info",
                message,
            }));
    },
    { immediate: true, deep: true },
);

const dismiss = (id) => {
    alerts.value = alerts.value.filter((a) => a.id !== id);
};
</script>

<template>
    <div v-for="alert in alerts" :key="alert.id" class="mb-4">
        <FwbAlert :type="alert.type" closable @close="dismiss(alert.id)">
            {{ alert.message }}
        </FwbAlert>
    </div>
</template>
