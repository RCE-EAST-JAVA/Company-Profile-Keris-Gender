<script setup>
import { ref, watch, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    journalArticles: {
        type: [Object, Array],
        default: () => ({ data: [], links: [] }),
    },
    bookModules: {
        type: [Object, Array],
        default: () => ({ data: [], links: [] }),
    },
    journalCount: {
        type: Number,
        default: 0,
    },
    bookCount: {
        type: Number,
        default: 0,
    },
    filters: {
        type: Object,
        default: () => ({ tab: 'journal', search: '' }),
    },
});

const journalList = computed(() => {
    return Array.isArray(props.journalArticles)
        ? props.journalArticles
        : (props.journalArticles?.data || []);
});

const bookList = computed(() => {
    return Array.isArray(props.bookModules)
        ? props.bookModules
        : (props.bookModules?.data || []);
});

const activeTab = ref(props.filters?.tab || 'journal');
const searchTerm = ref(props.filters?.search || '');

watch(
    () => props.filters?.tab,
    (newTab) => {
        if (newTab) {
            activeTab.value = newTab;
        }
    }
);

watch(
    () => props.filters?.search,
    (newSearch) => {
        searchTerm.value = newSearch || '';
    }
);

const setTab = (tab) => {
    activeTab.value = tab;
    router.get(
        route('publications.index'),
        {
            tab,
            search: searchTerm.value || undefined,
        },
        { preserveState: true, preserveScroll: true }
    );
};

const handleSearch = () => {
    router.get(
        route('publications.index'),
        {
            tab: activeTab.value,
            search: searchTerm.value || undefined,
        },
        { preserveState: true, preserveScroll: true }
    );
};

const formatDate = (dateStr) => {
    if (!dateStr) return '';
    return new Date(dateStr).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};
</script>

<template>
    <PublicLayout>
        <Head title="Our Publications — Center for Gender and International Relations Studies (GInRe)" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 sm:pt-14 pb-24">
            <!-- 1. Eyebrow & Hero Header -->
            <div class="max-w-3xl mb-10">
                <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-3">
                    <span>●</span>
                    <span>WRITING & INSIGHTS</span>
                </div>
                <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-ink font-normal tracking-tight leading-[1.15] mb-4">
                    Our Publications
                </h1>
                <p class="text-sm sm:text-base text-ink-muted leading-relaxed">
                    A collection of research, insights, policy recommendations, and academic monographs on gender justice, international relations, and structural equity by Center for Gender and International Relations Studies (GInRe).
                </p>
            </div>

            <!-- 2. Search & Filter Bar (Matching Example Image) -->
            <div class="max-w-4xl mx-auto mb-10">
                <div class="bg-white rounded-full border border-hairline p-2 sm:p-2.5 shadow-sm flex items-center gap-3">
                    <span class="pl-3 sm:pl-4 text-ink-subtle">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input
                        v-model="searchTerm"
                        @keydown.enter="handleSearch"
                        type="text"
                        placeholder="Search publications, authors, or topics..."
                        class="w-full bg-transparent border-none text-xs sm:text-sm text-ink placeholder:text-ink-subtle focus:ring-0 focus:outline-none"
                    />
                    <button
                        @click="handleSearch"
                        type="button"
                        class="bg-ink hover:bg-neutral-800 text-white text-xs font-semibold px-5 sm:px-6 py-2 sm:py-2.5 rounded-full transition-colors shadow-sm shrink-0 flex items-center gap-1.5"
                    >
                        <span>Search & Filter</span>
                    </button>
                </div>
            </div>

            <!-- 3. Category Toggle Tabs (Jurnal & Artikel vs Buku & Modul) -->
            <div class="flex justify-center mb-12">
                <div class="inline-flex p-1 rounded-full bg-neutral-100 border border-hairline shadow-inner">
                    <button
                        @click="setTab('journal')"
                        :class="[
                            'flex items-center gap-2 text-xs font-medium px-5 sm:px-6 py-2 rounded-full transition-all duration-150',
                            activeTab === 'journal'
                                ? 'bg-white text-ink shadow-sm font-semibold'
                                : 'text-ink-muted hover:text-ink'
                        ]"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Jurnal & Artikel</span>
                    </button>

                    <button
                        @click="setTab('book')"
                        :class="[
                            'flex items-center gap-2 text-xs font-medium px-5 sm:px-6 py-2 rounded-full transition-all duration-150',
                            activeTab === 'book'
                                ? 'bg-white text-ink shadow-sm font-semibold'
                                : 'text-ink-muted hover:text-ink'
                        ]"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Buku & Modul</span>
                    </button>
                </div>
            </div>

            <!-- 4. TAB CONTENT 1: Jurnal & Artikel (Wide Horizontal Cards matching Image 1) -->
            <div v-if="activeTab === 'journal'">
                <!-- Section Header -->
                <div class="flex items-center justify-between mb-8 pb-3 border-b border-hairline">
                    <div>
                        <h2 class="font-bold text-xl sm:text-2xl text-ink">
                            Jurnal & Artikel Ilmiah
                        </h2>
                        <p class="text-xs sm:text-sm text-ink-muted mt-1">
                            Daftar jurnal, hasil penelitian, dan artikel ilmiah Center for Gender and International Relations Studies (GInRe)
                        </p>
                    </div>
                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200/70 text-xs font-medium px-3 py-1 rounded-full shrink-0">
                        {{ journalCount }} Dokumen
                    </span>
                </div>

                <!-- Articles Stack -->
                <div v-if="journalList && journalList.length > 0" class="space-y-4">
                    <div
                        v-for="item in journalList"
                        :key="item.id"
                        :class="[
                            'rounded-2xl border p-6 transition-all duration-200 flex flex-col sm:flex-row sm:items-center justify-between gap-6 group relative overflow-hidden',
                            item.is_pinned
                                ? 'bg-gradient-to-r from-orange-50/60 via-white to-white border-orange-300/90 shadow-md ring-1 ring-orange-400/20 hover:border-orange-400 hover:shadow-lg'
                                : 'bg-white border-hairline hover:border-ink/40 shadow-sm hover:shadow-md'
                        ]"
                    >
                        <!-- Orange Ornament Bar for Pinned Item -->
                        <!-- <div
                            v-if="item.is_pinned"
                            class="absolute top-0 left-0 bottom-0 w-1.5 bg-gradient-to-b from-terracotta to-orange-400"
                        /> -->

                        <div class="space-y-2 max-w-4xl">
                            <!-- Category Badge, Pinned Badge & Date -->
                            <div class="flex items-center flex-wrap gap-2.5 text-xs font-mono">
                                <!-- PINNED BADGE with Pin Icon -->
                                <span
                                    v-if="item.is_pinned"
                                    class="inline-flex items-center gap-1.5 bg-orange-100 text-terracotta border border-orange-300/80 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-2xs"
                                >
                                    <svg class="w-3 h-3 text-terracotta fill-current" viewBox="0 0 24 24">
                                        <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/>
                                    </svg>
                                    <span>PINNED</span>
                                </span>

                                <span class="bg-neutral-100 text-ink-subtle px-2 py-0.5 rounded text-[10px] uppercase font-semibold tracking-wider">
                                    {{ item.category === 'Journal Article' ? 'JOURNAL' : item.category.toUpperCase() }}
                                </span>
                                <span class="text-ink-subtle">
                                    {{ formatDate(item.published_at) }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="font-bold text-base sm:text-lg text-ink group-hover:text-terracotta transition-colors leading-snug">
                                <Link :href="route('publications.show', item.slug)">
                                    {{ item.title }}
                                </Link>
                            </h3>

                            <!-- Author Row -->
                            <div v-if="item.author" class="flex items-center gap-2 text-xs text-ink-subtle font-medium">
                                <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Penulis: {{ item.author }}</span>
                            </div>

                            <!-- Excerpt -->
                            <p v-if="item.excerpt" class="text-xs text-ink-muted leading-relaxed line-clamp-2">
                                {{ item.excerpt }}
                            </p>
                        </div>

                        <!-- Right Action Arrow Circle -->
                        <Link
                            :href="route('publications.show', item.slug)"
                            :class="[
                                'w-10 h-10 rounded-full border flex items-center justify-center text-sm transition-all shrink-0 self-end sm:self-center shadow-sm',
                                item.is_pinned
                                    ? 'border-orange-300 bg-orange-50 text-terracotta group-hover:bg-terracotta group-hover:text-white group-hover:border-terracotta'
                                    : 'border-hairline bg-neutral-50 text-ink group-hover:bg-ink group-hover:text-white'
                            ]"
                            title="Lihat Detail"
                        >
                            <span>→</span>
                        </Link>
                    </div>

                    <!-- Pagination for Jurnal & Artikel (9 items per page) -->
                    <div
                        v-if="journalArticles?.links && journalArticles.links.length > 3"
                        class="mt-12 pt-8 border-t border-hairline flex flex-col sm:flex-row items-center justify-between gap-4"
                    >
                        <div class="text-xs font-mono text-ink-subtle">
                            Menampilkan <span class="text-ink font-semibold">{{ journalArticles.from || 0 }}</span> - <span class="text-ink font-semibold">{{ journalArticles.to || 0 }}</span> dari <span class="text-ink font-semibold">{{ journalArticles.total || 0 }}</span> dokumen
                        </div>

                        <div class="flex items-center gap-1.5 flex-wrap">
                            <template v-for="(link, index) in journalArticles.links" :key="index">
                                <Link
                                    v-if="link.url"
                                    :href="link.url"
                                    :class="[
                                        'px-3.5 py-1.5 rounded-lg text-xs font-mono transition-colors',
                                        link.active
                                            ? 'bg-ink text-white font-semibold shadow-xs'
                                            : 'bg-white hover:bg-paper text-ink border border-hairline hover:border-ink/40'
                                    ]"
                                    v-html="link.label"
                                    preserve-scroll
                                    preserve-state
                                />
                                <span
                                    v-else
                                    class="px-3 py-1.5 text-xs font-mono text-ink-subtle opacity-40 cursor-not-allowed"
                                    v-html="link.label"
                                />
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="bg-white rounded-2xl border border-hairline p-12 text-center my-8">
                    <p class="text-sm font-mono text-ink-muted">Tidak ada jurnal atau artikel ilmiah ditemukan.</p>
                </div>
            </div>

            <!-- 5. TAB CONTENT 2: Buku & Modul (3-Column Book Covers matching Image 2) -->
            <div v-if="activeTab === 'book'">
                <!-- Section Header -->
                <div class="flex items-center justify-between mb-8 pb-3 border-b border-hairline">
                    <div>
                        <h2 class="font-bold text-xl sm:text-2xl text-ink">
                            Buku & Modul Publikasi
                        </h2>
                        <p class="text-xs sm:text-sm text-ink-muted mt-1">
                            Buku referensi, panduan, dan modul pembelajaran Center for Gender and International Relations Studies (GInRe)
                        </p>
                    </div>
                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200/70 text-xs font-medium px-3 py-1 rounded-full shrink-0">
                        {{ bookCount }} Buku
                    </span>
                </div>

                <!-- Book Grid -->
                <div v-if="bookList && bookList.length > 0">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div
                            v-for="item in bookList"
                            :key="item.id"
                            :class="[
                                'rounded-2xl border p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition-all duration-200 group relative overflow-hidden',
                                item.is_pinned
                                    ? 'bg-gradient-to-b from-orange-50/50 via-white to-white border-orange-300 ring-1 ring-orange-400/20 hover:border-orange-400'
                                    : 'bg-white border-hairline hover:border-ink/40'
                            ]"
                        >
                            <!-- Top Orange Accent Line for Pinned Book -->
                            <!-- <div
                                v-if="item.is_pinned"
                                class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-terracotta to-orange-400"
                            /> -->

                            <div>
                                <!-- Pinned Badge for Book with Pin Icon -->
                                <div v-if="item.is_pinned" class="mb-3">
                                    <span class="inline-flex items-center gap-1.5 bg-orange-100 text-terracotta border border-orange-300/80 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-2xs">
                                        <svg class="w-3 h-3 text-terracotta fill-current" viewBox="0 0 24 24">
                                            <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/>
                                        </svg>
                                        <span>PINNED</span>
                                    </span>
                                </div>

                                <!-- Book Cover Image (Displayed ONLY if thumbnail exists) -->
                                <div v-if="item.thumbnail" class="aspect-[3/4] rounded-xl overflow-hidden bg-neutral-100 mb-4 border border-hairline shadow-sm relative">
                                    <Link :href="route('publications.show', item.slug)">
                                        <img
                                            :src="item.thumbnail"
                                            :alt="item.title"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        />
                                    </Link>
                                </div>

                                <!-- Date -->
                                <div class="text-[11px] font-mono text-ink-subtle mb-1">
                                    {{ formatDate(item.published_at) }}
                                </div>

                                <!-- Title -->
                                <h3 class="font-bold text-base sm:text-lg text-ink group-hover:text-terracotta transition-colors leading-snug mb-2 line-clamp-2">
                                    <Link :href="route('publications.show', item.slug)">
                                        {{ item.title }}
                                    </Link>
                                </h3>

                                <!-- Author Row -->
                                <div v-if="item.author" class="flex items-center gap-1.5 text-xs text-ink-subtle font-medium mb-3 truncate">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="truncate">Penulis: {{ item.author }}</span>
                                </div>

                                <!-- Excerpt -->
                                <p v-if="item.excerpt" class="text-xs text-ink-muted leading-relaxed line-clamp-3">
                                    {{ item.excerpt }}
                                </p>
                            </div>

                            <!-- Card Footer Link -->
                            <div class="pt-4 border-t border-hairline flex items-center justify-end text-xs font-mono mt-4">
                                <Link
                                    :href="route('publications.show', item.slug)"
                                    class="text-ink hover:text-terracotta font-semibold flex items-center gap-1 transition-colors"
                                >
                                    <span>Lihat Detail →</span>
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination for Buku & Modul (9 items per page) -->
                    <div
                        v-if="bookModules?.links && bookModules.links.length > 3"
                        class="mt-12 pt-8 border-t border-hairline flex flex-col sm:flex-row items-center justify-between gap-4"
                    >
                        <div class="text-xs font-mono text-ink-subtle">
                            Menampilkan <span class="text-ink font-semibold">{{ bookModules.from || 0 }}</span> - <span class="text-ink font-semibold">{{ bookModules.to || 0 }}</span> dari <span class="text-ink font-semibold">{{ bookModules.total || 0 }}</span> buku
                        </div>

                        <div class="flex items-center gap-1.5 flex-wrap">
                            <template v-for="(link, index) in bookModules.links" :key="index">
                                <Link
                                    v-if="link.url"
                                    :href="link.url"
                                    :class="[
                                        'px-3.5 py-1.5 rounded-lg text-xs font-mono transition-colors',
                                        link.active
                                            ? 'bg-ink text-white font-semibold shadow-xs'
                                            : 'bg-white hover:bg-paper text-ink border border-hairline hover:border-ink/40'
                                    ]"
                                    v-html="link.label"
                                    preserve-scroll
                                    preserve-state
                                />
                                <span
                                    v-else
                                    class="px-3 py-1.5 text-xs font-mono text-ink-subtle opacity-40 cursor-not-allowed"
                                    v-html="link.label"
                                />
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="bg-white rounded-2xl border border-hairline p-12 text-center my-8">
                    <p class="text-sm font-mono text-ink-muted">Tidak ada buku atau modul ditemukan.</p>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
