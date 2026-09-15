<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="mb-1 block font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
