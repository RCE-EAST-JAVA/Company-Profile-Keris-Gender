<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    articles: Array,
    featured: Object,
    filters: Object,
    categoryCounts: Object,
});

const searchTerm = ref(props.filters?.search || '');
const currentCategory = ref(props.filters?.category || 'all');

const categories = [
    { id: 'all', label: 'ALL PUBLICATIONS', count: props.categoryCounts?.all || 0 },
    { id: 'Journal Article', label: 'JOURNAL ARTICLES', count: props.categoryCounts?.['Journal Article'] || 0 },
    { id: 'Book & Module', label: 'BOOKS & MODULES', count: props.categoryCounts?.['Book & Module'] || 0 },
    { id: 'Policy Brief', label: 'POLICY BRIEFS', count: props.categoryCounts?.['Policy Brief'] || 0 },
    { id: 'Annual Report', label: 'ANNUAL REPORTS', count: props.categoryCounts?.['Annual Report'] || 0 },
];

const applyFilter = (catId) => {
    currentCategory.value = catId;
    router.get(
        route('publications.index'),
        {
            category: catId,
            search: searchTerm.value,
        },
        { preserveState: true, preserveScroll: true }
    );
};

let searchDebounce = null;
const handleSearch = () => {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() => {
        router.get(
            route('publications.index'),
            {
                category: currentCategory.value,
                search: searchTerm.value,
            },
            { preserveState: true, preserveScroll: true }
        );
    }, 300);
};
</script>

<template>
    <PublicLayout>
        <Head title="Academic Publications & Policy Recommendations — Center for Gender and International Relations Studies (GInRe)" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 sm:pt-16 pb-20">
            <!-- 1. Header & Meta Section -->
            <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-4">
                <span>●</span>
                <span>RESEARCH REPOSITORY & SCHOLARLY ARCHIVE · SERIES 2024-2025</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-10">
                <div class="lg:col-span-8 space-y-4">
                    <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-ink font-normal tracking-tight leading-[1.15]">
                        Academic Publications &<br />Policy Recommendations
                    </h1>
                    <p class="text-sm sm:text-base text-ink-muted leading-relaxed max-w-2xl">
                        Open-access dissemination of empirical research, structural deconstructions, and multidimensional policy frameworks for transformative gender justice across Southeast Asia.
                    </p>
                </div>

                <!-- Academic Accreditation Badge Right -->
                <div class="lg:col-span-4 bg-white p-4 rounded-xl border border-hairline text-right space-y-1">
                    <div class="text-[11px] font-mono text-terracotta font-semibold flex items-center justify-end gap-1">
                        <span>★</span>
                        <span>DOAJ & SINTA 1 CERTIFIED</span>
                    </div>
                    <div class="text-xs text-ink-muted">
                        Updated Weekly · Peer-Reviewed Standard
                    </div>
                    <div class="text-[11px] font-mono text-ink-subtle">
                        DOI PREFIX: 10.22146/GINRE
                    </div>
                </div>
            </div>

            <!-- 2. Search Bar & Interactive Category Filter Pills -->
            <div class="space-y-4 mb-12">
                <!-- Search Input -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-ink-subtle">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input
                        v-model="searchTerm"
                        @input="handleSearch"
                        type="text"
                        placeholder="Search title, author, keyword, or policy topic (e.g., TFGBV, coastal labor, SINTA)..."
                        class="w-full pl-11 pr-4 py-3 bg-white border border-hairline rounded-xl text-xs sm:text-sm text-ink placeholder-ink-subtle focus:outline-none focus:border-ink transition-colors shadow-sm"
                    />
                </div>

                <!-- Category Pills -->
                <div class="flex flex-wrap items-center justify-between gap-4 pt-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <button
                            v-for="cat in categories"
                            :key="cat.id"
                            @click="applyFilter(cat.id)"
                            :class="[
                                'text-xs font-mono px-4 py-2 rounded-full transition-all duration-150 flex items-center gap-1.5',
                                currentCategory === cat.id
                                    ? 'bg-ink text-white font-medium shadow-sm'
                                    : 'bg-white hover:bg-paper text-ink-muted hover:text-ink border border-hairline'
                            ]"
                        >
                            <span>{{ cat.label }}</span>
                            <span v-if="cat.count" class="opacity-70 text-[10px]">({{ cat.count }})</span>
                        </button>
                    </div>

                    <div class="flex items-center gap-1.5 text-xs font-mono text-ink-subtle">
                        <span>⇅</span>
                        <span>ARRANGED CHRONOLOGICALLY</span>
                    </div>
                </div>
            </div>

            <!-- 3. Featured Monograph / Book Hero Card (Matches Screenshot 2) -->
            <div v-if="featured" class="bg-white rounded-2xl border border-hairline overflow-hidden shadow-sm mb-16">
                <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">
                    <!-- Left Monograph Data -->
                    <div class="lg:col-span-7 p-6 sm:p-10 flex flex-col justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-3 text-[11px] font-mono text-ink-subtle mb-4">
                                <span class="text-terracotta font-semibold">● FEATURED BOOK / MODULE · 2025 EDITION</span>
                                <span>DOI: 10.22146/keris.2024.0851</span>
                                <span>ISBN: 978-602-5319</span>
                            </div>

                            <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-ink font-normal leading-tight mb-4">
                                <Link :href="route('publications.show', featured.slug)" class="hover:text-terracotta transition-colors">
                                    {{ featured.title }}
                                </Link>
                            </h2>

                            <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-6">
                                {{ featured.excerpt }}
                            </p>

                            <!-- Author Card Pill -->
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-8 h-8 rounded-full bg-paper border border-hairline flex items-center justify-center font-mono text-xs font-bold text-ink">
                                    KR
                                </div>
                                <div class="text-xs">
                                    <span class="font-semibold text-ink">{{ featured.author }}</span>
                                    <span class="text-ink-subtle block text-[11px]">Center for Coastal Sociology & Gender Policy Directorate</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap items-center gap-4 pt-4 border-t border-hairline">
                            <Link
                                :href="route('publications.show', featured.slug)"
                                class="inline-flex items-center gap-2 bg-ink hover:bg-black text-white text-xs font-medium px-5 py-2.5 rounded-full transition-colors shadow-sm"
                            >
                                <span>DOWNLOAD FULL MONOGRAPH (PDF)</span>
                                <span>⭳</span>
                            </Link>
                            <Link
                                :href="route('publications.show', featured.slug)"
                                class="inline-flex items-center gap-1.5 bg-paper hover:bg-white text-ink text-xs font-mono px-4 py-2.5 rounded-full border border-hairline transition-colors"
                            >
                                <span>CITE THIS RESEARCH (APA / BIBTEX)</span>
                            </Link>
                            <span class="text-xs font-mono text-ink-subtle ml-auto">
                                412 Pages · Peer-Reviewed
                            </span>
                        </div>
                    </div>

                    <!-- Right Field Survey Image Container -->
                    <div class="lg:col-span-5 relative bg-neutral-900 min-h-[280px] lg:min-h-full">
                        <img
                            :src="featured.thumbnail || 'https://images.unsplash.com/photo-1544654803-b69140b285a1?q=80&w=1200&auto=format&fit=crop'"
                            :alt="featured.title"
                            class="w-full h-full object-cover grayscale contrast-105"
                        />
                        <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between text-[11px] font-mono text-white bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-lg border border-white/10">
                            <span>FIELD SURVEY: DEMAK & PEKALONGAN REGENCY</span>
                            <span class="text-terracotta">FIELD RECORD: A-24</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Recent Research Monograph Index (3-Column Grid) -->
            <div>
                <div class="flex items-center justify-between mb-8 pb-3 border-b border-hairline">
                    <div>
                        <span class="font-mono text-xs text-ink-subtle uppercase block mb-1">CATALOGUE</span>
                        <h3 class="font-serif text-2xl text-ink font-normal">
                            Recent Research Monograph Index
                        </h3>
                    </div>
                    <span class="font-mono text-xs text-ink-subtle">
                        DISPLAYING {{ articles.length }} MONOGRAPHS
                    </span>
                </div>

                <!-- Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="item in articles"
                        :key="item.id"
                        :class="[
                            'rounded-2xl border flex flex-col justify-between p-6 transition-all duration-200 group',
                            item.category === 'Policy Brief' && item.is_pinned
                                ? 'bg-terracotta text-white border-terracotta shadow-md'
                                : 'bg-white text-ink border-hairline hover:border-ink/40 shadow-sm'
                        ]"
                    >
                        <div>
                            <!-- Optional Card Image thumbnail -->
                            <div v-if="item.thumbnail && item.category === 'Book & Module' && item.id !== featured?.id" class="aspect-[16/9] rounded-xl overflow-hidden bg-neutral-900 mb-4">
                                <img
                                    :src="item.thumbnail"
                                    :alt="item.title"
                                    class="w-full h-full object-cover grayscale contrast-105 group-hover:scale-105 transition-transform duration-500"
                                />
                            </div>

                            <!-- Card Header Eyebrow -->
                            <div class="flex items-center justify-between text-[11px] font-mono mb-3">
                                <span :class="item.category === 'Policy Brief' && item.is_pinned ? 'bg-white/20 text-white px-2 py-0.5 rounded' : 'text-ink-subtle uppercase'">
                                    {{ item.category === 'Policy Brief' && item.is_pinned ? '● NATIONAL POLICY PRIORITY' : item.category }}
                                </span>
                                <span :class="item.category === 'Policy Brief' && item.is_pinned ? 'text-white/80' : 'text-ink-subtle'">
                                    {{ new Date(item.published_at).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h4 :class="['font-serif text-xl font-normal leading-snug mb-3', item.category === 'Policy Brief' && item.is_pinned ? 'text-white' : 'text-ink group-hover:text-terracotta transition-colors']">
                                <Link :href="route('publications.show', item.slug)">
                                    {{ item.title }}
                                </Link>
                            </h4>

                            <!-- Excerpt -->
                            <p :class="['text-xs leading-relaxed line-clamp-3 mb-6', item.category === 'Policy Brief' && item.is_pinned ? 'text-white/90' : 'text-ink-muted']">
                                {{ item.excerpt }}
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div :class="['pt-4 border-t flex items-center justify-between text-xs font-mono', item.category === 'Policy Brief' && item.is_pinned ? 'border-white/20' : 'border-hairline']">
                            <span :class="item.category === 'Policy Brief' && item.is_pinned ? 'text-white/80' : 'text-ink-subtle truncate max-w-[140px]'">
                                {{ item.author }}
                            </span>
                            <Link
                                :href="route('publications.show', item.slug)"
                                :class="[
                                    'font-semibold flex items-center gap-1 transition-colors',
                                    item.category === 'Policy Brief' && item.is_pinned
                                        ? 'bg-white text-terracotta px-3 py-1 rounded-full hover:bg-paper'
                                        : 'text-ink hover:text-terracotta'
                                ]"
                            >
                                <span>{{ item.category === 'Policy Brief' ? 'READ BRIEF ↗' : 'FULL ARTICLE →' }}</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
