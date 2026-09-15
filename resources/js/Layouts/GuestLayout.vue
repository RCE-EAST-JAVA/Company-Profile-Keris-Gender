<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0">
        <div class="mb-2 flex flex-col items-center gap-2">
            <Link href="/">
                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-900 text-lg font-semibold text-white">G</span>
            </Link>
            <p class="font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">GInRe · Admin</p>
        </div>

        <div class="mt-4 w-full overflow-hidden bg-white px-6 py-6 shadow-md sm:max-w-md sm:rounded-2xl">
            <slot />
        </div>
    </div>
</template>
