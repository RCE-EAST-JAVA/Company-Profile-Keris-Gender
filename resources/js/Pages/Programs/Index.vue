<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    featuredPrograms: {
        type: Array,
        default: () => [],
    },
    initiatives: {
        type: Array,
        default: () => [],
    },
});

const activeFilter = ref('all');
const currentPage = ref(1);
const itemsPerPage = 6;

const filterCategories = [
    { id: 'all', label: 'All Initiatives' },
    { id: 'Flagship Fellowship', label: 'Fellowships' },
    { id: 'Policy Lab', label: 'Policy Labs' },
    { id: 'Community Initiative', label: 'Grassroots Leadership' },
    { id: 'Research Initiative', label: 'Research Initiatives' },
    { id: 'In Situ Fieldwork', label: 'In Situ Fieldwork' },
];

const filteredInitiatives = computed(() => {
    if (activeFilter.value === 'all') {
        return props.initiatives || [];
    }
    return (props.initiatives || []).filter(item => item.category === activeFilter.value);
});

const totalPages = computed(() => {
    return Math.ceil(filteredInitiatives.value.length / itemsPerPage) || 1;
});

const paginatedInitiatives = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    return filteredInitiatives.value.slice(start, start + itemsPerPage);
});

const selectFilter = (catId) => {
    activeFilter.value = catId;
    currentPage.value = 1;
};

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        const el = document.getElementById('programs-repository');
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
};
</script>

<template>
    <PublicLayout>
        <Head title="Programs & Initiatives — Center for Gender and International Relations Studies (GInRe)" />

        <!-- 1. Header Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 sm:pt-16 pb-8">
            <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-4">
                <span>●</span>
                <span>RESEARCH PROGRAMS & INTERVENTIONS</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-8">
                <div class="lg:col-span-7">
                    <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-ink font-normal tracking-tight leading-[1.15]">
                        Programs & Research Initiatives
                    </h1>
                </div>
                <div class="lg:col-span-5 pt-2">
                    <p class="text-sm sm:text-base text-ink-muted leading-relaxed">
                        Documenting participatory action research, policy incubators, and emancipatory gender justice interventions led by the Center for Gender and International Relations Studies (GInRe).
                    </p>
                </div>
            </div>

            <!-- Filter Pills -->
            <div class="flex flex-wrap items-center gap-2 pt-2 border-b border-hairline/80 pb-6">
                <button
                    v-for="cat in filterCategories"
                    :key="cat.id"
                    @click="selectFilter(cat.id)"
                    :class="[
                        'text-xs font-mono px-4 py-2 rounded-full transition-all duration-150',
                        activeFilter === cat.id
                            ? 'bg-ink text-white font-medium shadow-sm'
                            : 'bg-white hover:bg-paper text-ink-muted hover:text-ink border border-hairline'
                    ]"
                >
                    {{ cat.label }}
                </button>
            </div>
        </section>

        <!-- 2. Featured Programs Section (2 Side-by-Side Cards as Before, Pure Database Data) -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-terracotta"></span>
                    <h2 class="font-mono text-xs uppercase tracking-widest text-ink font-semibold">
                        FEATURED INITIATIVES & FLAGSHIP PROGRAMS
                    </h2>
                </div>
                <span class="font-mono text-xs text-ink-subtle">
                    ACTIVE CYCLE
                </span>
            </div>

            <!-- 2-Column Grid for Featured Programs -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                <div
                    v-for="featured in (featuredPrograms && featuredPrograms.length > 0 ? featuredPrograms : initiatives.slice(0, 2))"
                    :key="featured.id"
                    class="bg-white rounded-2xl border border-hairline shadow-sm overflow-hidden flex flex-col justify-between hover:border-ink/40 transition-all duration-200 group"
                >
                    <div>
                        <!-- Activity Photo / Thumbnail -->
                        <div class="relative aspect-[16/9] bg-neutral-900 overflow-hidden">
                            <img
                                :src="featured.image || 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200&auto=format&fit=crop'"
                                :alt="featured.title"
                                class="w-full h-full object-cover contrast-105 group-hover:scale-105 transition-transform duration-700"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                            <!-- Top Floating Badge -->
                            <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-mono text-white flex items-center gap-1.5 border border-white/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-terracotta"></span>
                                <span>ACTIVITY DOCUMENTATION</span>
                            </div>

                            <!-- Bottom Floating Tag -->
                            <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-[11px] font-mono text-white">
                                <span v-if="featured.date" class="bg-white/20 backdrop-blur-md px-2 py-0.5 rounded text-[10px]">
                                    CYCLE: {{ featured.date }}
                                </span>
                                <span v-if="featured.status" class="text-white/90 bg-black/40 backdrop-blur-sm px-2 py-0.5 rounded text-[10px]">
                                    STATUS: {{ featured.status }}
                                </span>
                            </div>
                        </div>

                        <!-- Content Body (Pure Database Fields) -->
                        <div class="p-6 sm:p-8">
                            <div class="flex items-center justify-between text-[11px] font-mono mb-3">
                                <span class="text-terracotta font-semibold uppercase tracking-wider">
                                     {{ featured.author }}
                                </span>
                            </div>

                            <h3 class="font-serif text-2xl sm:text-3xl text-ink font-normal leading-snug mb-3 group-hover:text-terracotta transition-colors">
                                <Link :href="route('programs.show', featured.slug || featured.id)">
                                    {{ featured.title }}
                                </Link>
                            </h3>

                            <p class="text-xs sm:text-sm text-ink-muted leading-relaxed line-clamp-4 mb-4">
                                {{ featured.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Actions Bottom: Pure Detail Link (No Registration/Pendaftaran) -->
                    <div class="p-6 sm:p-8 pt-0 flex items-center justify-between gap-4 border-t border-hairline/60 mt-4 pt-4">
                        <span class="text-xs font-mono text-ink-subtle">
                            {{ featured.category }}
                        </span>
                        <Link
                            :href="route('programs.show', featured.slug || featured.id)"
                            class="inline-flex items-center gap-2 bg-ink hover:bg-black text-white text-xs font-mono px-5 py-2.5 rounded-full transition-all shadow-sm group-hover:bg-terracotta"
                        >
                            <span>Program Details</span>
                            <span>→</span>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. All Initiatives & Research Programs (Cards With Activity Photos / Thumbnails) -->
        <section id="programs-repository" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 border-t border-hairline pt-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="font-mono text-xs text-terracotta uppercase block mb-1">PROGRAM REPOSITORY</span>
                    <h3 class="font-serif text-2xl sm:text-3xl text-ink font-normal">
                        All Initiatives & Research Programs
                    </h3>
                </div>
                <span class="font-mono text-xs text-ink-subtle">
                    DISPLAYING {{ filteredInitiatives.length > 0 ? (currentPage - 1) * itemsPerPage + 1 : 0 }}–{{ Math.min(currentPage * itemsPerPage, filteredInitiatives.length) }} OF {{ filteredInitiatives.length }} INITIATIVES
                </span>
            </div>

            <!-- Initiatives Cards Grid with Activity Thumbnails (6 items per page) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    v-for="item in paginatedInitiatives"
                    :key="item.id"
                    class="bg-white rounded-2xl border border-hairline shadow-sm overflow-hidden flex flex-col justify-between hover:border-ink/40 transition-all duration-200 group"
                >
                    <div>
                        <!-- Activity Photo / Thumbnail -->
                        <div class="relative aspect-[16/10] bg-neutral-900 overflow-hidden">
                            <img
                                :src="item.image || 'https://images.unsplash.com/photo-1544654803-b69140b285a1?q=80&w=800&auto=format&fit=crop'"
                                :alt="item.title"
                                class="w-full h-full object-cover contrast-105 group-hover:scale-105 transition-transform duration-500"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-2.5 left-3 right-3 flex items-center justify-between text-[10px] font-mono text-white">
                                <span v-if="item.date" class="bg-black/60 backdrop-blur-md px-2 py-0.5 rounded border border-white/20">
                                    {{ item.date }}
                                </span>
                                <span v-if="item.status" class="text-white/90">
                                    ● {{ item.status }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body (Pure Database Fields) -->
                        <div class="p-6">
                            <div class="flex items-center justify-between text-[11px] font-mono text-ink-subtle mb-2">
                                <span class="text-terracotta font-semibold uppercase tracking-wider">
                                    {{ item.author }}
                                </span>
                            </div>

                            <h4 class="font-serif text-xl text-ink font-normal leading-snug mb-2 group-hover:text-terracotta transition-colors">
                                <Link :href="route('programs.show', item.slug || item.id)">
                                    {{ item.title }}
                                </Link>
                            </h4>

                            <p class="text-xs text-ink-muted leading-relaxed line-clamp-3 mb-4">
                                {{ item.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer: Pure Detail Link (No Registration) -->
                    <div class="px-6 pb-6 pt-0 flex items-center justify-between text-xs font-mono border-t border-hairline/60 pt-4">
                        <span v-if="item.author" class="text-ink-subtle truncate max-w-[140px]">
                            {{ item.category }}
                        </span>
                        <span v-else class="text-ink-subtle">
                            GInRe
                        </span>
                        <Link
                            :href="route('programs.show', item.slug || item.id)"
                            class="text-ink hover:text-terracotta font-semibold flex items-center gap-1 transition-colors"
                        >
                            <span>DETAILS</span>
                            <span>→</span>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Pagination Bar (6 items per page, centered on mobile) -->
            <div v-if="totalPages > 1" class="mt-12 flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-4 border-t border-hairline pt-6 text-center sm:text-left">
                <div class="font-mono text-xs text-ink-muted">
                    Showing Page {{ currentPage }} of {{ totalPages }}
                </div>

                <div class="flex items-center justify-center gap-1.5 flex-wrap">
                    <button
                        @click="goToPage(currentPage - 1)"
                        :disabled="currentPage === 1"
                        type="button"
                        class="px-3 py-1.5 rounded-lg border border-hairline bg-white font-mono text-xs text-ink transition-colors disabled:opacity-40 disabled:cursor-not-allowed hover:not-disabled:bg-paper"
                    >
                        ← Prev
                    </button>

                    <button
                        v-for="p in totalPages"
                        :key="p"
                        @click="goToPage(p)"
                        type="button"
                        :class="[
                            'w-8 h-8 rounded-lg font-mono text-xs transition-colors flex items-center justify-center',
                            currentPage === p
                                ? 'bg-ink text-white font-bold shadow-xs'
                                : 'bg-white text-ink border border-hairline hover:bg-paper'
                        ]"
                    >
                        {{ p }}
                    </button>

                    <button
                        @click="goToPage(currentPage + 1)"
                        :disabled="currentPage === totalPages"
                        type="button"
                        class="px-3 py-1.5 rounded-lg border border-hairline bg-white font-mono text-xs text-ink transition-colors disabled:opacity-40 disabled:cursor-not-allowed hover:not-disabled:bg-paper"
                    >
                        Next →
                    </button>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
