<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    staff: Object,
    publications: Array,
    otherStaff: Array,
});
</script>

<template>
    <PublicLayout>
        <Head :title="`${staff.name} — Center for Gender and International Relations Studies (GInRe) Research Directorate`" />

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 sm:pt-14 pb-24">
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs font-mono text-ink-muted mb-8">
                <Link :href="route('people.index')" class="hover:text-ink transition-colors">
                    ← Back to All Scholars
                </Link>
                <span>/</span>
                <span class="text-ink truncate max-w-xs">{{ staff.name }}</span>
            </div>

            <!-- Profile Hero Card -->
            <div class="bg-white rounded-2xl border border-hairline p-6 sm:p-10 shadow-sm mb-12">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                    <!-- High-Res Portrait Column Left -->
                    <div class="md:col-span-4 space-y-4">
                        <div class="aspect-[4/5] rounded-xl overflow-hidden bg-neutral-900 border border-hairline shadow-sm relative">
                            <img
                                :src="staff.image || 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop'"
                                :alt="staff.name"
                                class="w-full h-full object-cover grayscale contrast-105"
                            />
                            <div class="absolute bottom-2 right-2 bg-black/80 backdrop-blur-md px-2.5 py-1 rounded text-[10px] font-mono text-white">
                                {{ staff.category }}
                            </div>
                        </div>

                        <!-- Contact & Links -->
                        <div class="space-y-2 text-xs font-mono">
                            <a
                                v-if="staff.email"
                                :href="`mailto:${staff.email}`"
                                class="block text-ink-muted hover:text-terracotta transition-colors truncate"
                            >
                                ✉ {{ staff.email }}
                            </a>
                            <a
                                v-if="staff.linkedin"
                                :href="staff.linkedin"
                                target="_blank"
                                class="block text-terracotta hover:underline font-semibold"
                            >
                                ↗ Institutional ORCID / Dossier
                            </a>
                        </div>
                    </div>

                    <!-- Scholar Details Column Right -->
                    <div class="md:col-span-8 space-y-4">
                        <div class="flex items-center gap-2 text-xs font-mono text-terracotta uppercase tracking-wider font-semibold">
                            <span>●</span>
                            <span>{{ staff.category.toUpperCase() }} · DIRECTORATE</span>
                        </div>

                        <h1 class="font-serif text-3xl sm:text-4xl text-ink font-normal leading-tight">
                            {{ staff.name }}
                        </h1>

                        <div class="text-sm font-medium text-ink-muted">
                            {{ staff.role }}
                        </div>

                        <!-- Expertise Tags -->
                        <div v-if="staff.expertise" class="pt-2 flex flex-wrap gap-2">
                            <span
                                v-for="(tag, idx) in staff.expertise.split(',')"
                                :key="idx"
                                class="bg-paper px-3 py-1 rounded-md border border-hairline text-xs font-mono text-ink"
                            >
                                {{ tag.trim() }}
                            </span>
                        </div>

                        <!-- Bio -->
                        <div class="pt-4 border-t border-hairline text-xs sm:text-sm text-ink leading-relaxed whitespace-pre-line font-sans space-y-3">
                            <h3 class="font-serif text-lg text-ink font-semibold">Scholarly Biography & Research Focus</h3>
                            <p>{{ staff.description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Authored Publications Catalog -->
            <section class="mb-16">
                <div class="flex items-center justify-between mb-6 pb-3 border-b border-hairline">
                    <h2 class="font-serif text-2xl text-ink font-normal">
                        Authored Publications & Policy Drafts
                    </h2>
                    <span class="font-mono text-xs text-ink-subtle">
                        {{ publications.length }} TITLES IN ARCHIVE
                    </span>
                </div>

                <div v-if="publications.length > 0" class="space-y-4">
                    <div
                        v-for="paper in publications"
                        :key="paper.id"
                        class="bg-white p-6 rounded-xl border border-hairline hover:border-ink/40 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4 group"
                    >
                        <div class="space-y-1 max-w-2xl">
                            <div class="flex items-center gap-3 text-[11px] font-mono text-ink-subtle">
                                <span class="text-terracotta font-semibold">● {{ paper.category }}</span>
                                <span>Published {{ new Date(paper.published_at).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) }}</span>
                            </div>
                            <h3 class="font-serif text-xl text-ink font-normal group-hover:text-terracotta transition-colors">
                                <Link :href="route('publications.show', paper.slug)">
                                    {{ paper.title }}
                                </Link>
                            </h3>
                            <p class="text-xs text-ink-muted line-clamp-2">
                                {{ paper.excerpt }}
                            </p>
                        </div>

                        <Link
                            :href="route('publications.show', paper.slug)"
                            class="shrink-0 bg-paper hover:bg-ink hover:text-white text-ink text-xs font-mono px-4 py-2 rounded-full border border-hairline transition-all text-center"
                        >
                            Read Full Paper →
                        </Link>
                    </div>
                </div>

                <div v-else class="bg-paper p-8 rounded-xl border border-hairline text-center text-xs font-mono text-ink-muted">
                    No publications catalogued for this scholar under this exact citation variant yet.
                </div>
            </section>

            <!-- Other Scholars in Division -->
            <section v-if="otherStaff && otherStaff.length > 0" class="border-t border-hairline pt-12">
                <h3 class="font-serif text-2xl text-ink font-normal mb-6">
                    Other Scholars in Directorate
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        v-for="other in otherStaff"
                        :key="other.id"
                        class="bg-white p-5 rounded-xl border border-hairline flex flex-col justify-between hover:border-ink transition-all"
                    >
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-neutral-200 shrink-0">
                                <img
                                    v-if="other.image"
                                    :src="other.image"
                                    :alt="other.name"
                                    class="w-full h-full object-cover grayscale"
                                />
                            </div>
                            <div>
                                <h4 class="font-serif text-base text-ink font-medium leading-snug">
                                    <Link :href="route('people.show', other.slug || other.id)" class="hover:underline">
                                        {{ other.name }}
                                    </Link>
                                </h4>
                                <span class="text-[10px] font-mono text-ink-muted block">{{ other.role }}</span>
                            </div>
                        </div>
                        <Link :href="route('people.show', other.slug || other.id)" class="font-mono text-xs text-ink hover:text-terracotta font-semibold mt-2">
                            View Profile →
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    </PublicLayout>
</template>
