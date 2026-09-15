<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <p class="mb-1 font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Overview</p>
            <h2 class="font-serif text-[30px] font-light leading-tight text-gray-900">Dashboard</h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="font-mono text-[11px] uppercase tracking-[0.09em] text-gray-500">Status</p>
                    <p class="mt-2 text-sm text-gray-600">Panel admin utama berjalan di Blade. Lanjutkan ke:</p>
                    <Link href="/admin" class="mt-4 inline-flex items-center gap-2 rounded-full bg-gray-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800">
                        Buka Admin Panel
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
