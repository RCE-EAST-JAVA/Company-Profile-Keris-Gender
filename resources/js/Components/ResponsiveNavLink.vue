<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'block w-full rounded-2xl bg-gray-900 px-4 py-2 text-start text-sm font-medium text-white transition'
        : 'block w-full rounded-2xl border border-transparent px-4 py-2 text-start text-sm font-medium text-gray-500 transition hover:bg-gray-100 hover:text-gray-900',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
