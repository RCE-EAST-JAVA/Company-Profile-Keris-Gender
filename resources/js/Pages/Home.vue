<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    heroPhoto: Object,
    partners: Array,
    featuredMonograph: Object,
    recentPublications: Array,
    stats: Object,
});

const featuredLargeArticle = props.recentPublications?.[0] || props.featuredMonograph;
const sideArticles = props.recentPublications?.slice(1, 4) || [];
</script>

<template>
    <PublicLayout>
        <Head title="Center for Gender and International Relations Studies (GInRe) — Dismantling Inequality, Weaving a Just Future" />

        <!-- 1. Hero Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 sm:pt-16 pb-16 lg:pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Hero Content -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex items-center gap-2 font-mono text-xs text-terracotta font-medium tracking-wider uppercase">
                        <span>●</span>
                        <span>INDEPENDENT ACADEMIC RESEARCH INSTITUTE · EST. 2019</span>
                    </div>

                    <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-ink font-normal tracking-tight leading-[1.12]">
                        Dismantling Inequality,<br />
                        <span class="italic font-light">Weaving a Just Future.</span>
                    </h1>

                    <p class="text-base sm:text-lg text-ink-muted leading-relaxed max-w-xl font-normal">
                        An independent academic and policy research collective interrogating gender violence, agrarian inequality, and institutional patriarchies to cultivate emancipatory governance across Southeast Asia.
                    </p>

                    <!-- Action Buttons -->
                    <div class="pt-2 flex flex-wrap items-center gap-4">
                        <Link
                            :href="route('publications.index')"
                            class="inline-flex items-center gap-2 bg-ink hover:bg-black text-white text-xs sm:text-sm font-medium px-6 py-3 rounded-full transition-all duration-200 shadow-sm hover:shadow"
                        >
                            <span>EXPLORE PUBLICATIONS</span>
                            <span>→</span>
                        </Link>
                        <Link
                            :href="route('programs.index')"
                            class="inline-flex items-center gap-2 bg-transparent hover:bg-white text-ink text-xs sm:text-sm font-medium px-6 py-3 rounded-full border border-hairline transition-all duration-200"
                        >
                            <span>VIEW RESEARCH PORTFOLIO</span>
                        </Link>
                    </div>

                    <!-- Meta / Proof Pills -->
                    <div class="pt-6 flex flex-wrap items-center gap-4 text-xs font-mono text-ink-subtle">
                        <div class="flex items-center gap-1.5 bg-white/70 px-3 py-1.5 rounded-full border border-hairline/80">
                            <span class="text-ink font-semibold">Peer-Reviewed Publications:</span>
                            <span>{{ stats?.publications_count || '60+' }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-white/70 px-3 py-1.5 rounded-full border border-hairline/80">
                            <span class="text-ink font-semibold">Institutional Partners:</span>
                            <span>{{ stats?.partners_count || '24+' }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-white/70 px-3 py-1.5 rounded-full border border-hairline/80">
                            <span class="text-terracotta">●</span>
                            <span class="text-ink font-semibold">Active Programs:</span>
                            <span>2025</span>
                        </div>
                    </div>
                </div>

                <!-- Right Hero Floating Story Card -->
                <div class="lg:col-span-5">
                    <div class="relative bg-white p-3 sm:p-4 rounded-2xl border border-hairline shadow-lg transition-transform hover:-translate-y-1 duration-300">
                        <div class="relative aspect-[4/3] rounded-xl overflow-hidden bg-neutral-900 group">
                            <img
                                :src="heroPhoto?.image || 'https://images.unsplash.com/photo-1544654803-b69140b285a1?q=80&w=1200&auto=format&fit=crop'"
                                :alt="heroPhoto?.caption || 'Hero photo'"
                                class="w-full h-full object-cover grayscale contrast-105 group-hover:scale-105 transition-transform duration-700"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                            <!-- Top Floating Badge -->
                            <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md px-2.5 py-1 rounded-full text-[10px] font-mono text-white flex items-center gap-1.5 border border-white/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-terracotta"></span>
                                <span>RESEARCH LOG</span>
                            </div>

                            <!-- Bottom Overlay Title -->
                            <div class="absolute bottom-3 left-3 right-3 text-white">
                                <p class="text-xs sm:text-sm font-serif font-medium leading-snug">
                                    {{ heroPhoto?.caption || 'Women Fishers Resistance in Wawonii: Mining & Ecosystem Destruction' }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Meta Footer -->
                        <div class="pt-3 flex items-center justify-between text-[11px] font-mono text-ink-muted">
                            <div class="flex items-center gap-2">
                                <span class="bg-paper px-2 py-0.5 rounded border border-hairline text-ink">CLIMATE JUSTICE</span>
                                <span class="bg-paper px-2 py-0.5 rounded border border-hairline text-ink">INDIGENOUS RIGHTS</span>
                            </div>
                            <span class="text-terracotta font-medium">FIELD ARCHIVE ↗</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Institutional & Research Affiliates Logo Strip -->
        <section class="border-y border-hairline/80 bg-[#f7f6f1] py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <span class="font-mono text-[11px] uppercase tracking-widest text-ink-subtle shrink-0">
                        INSTITUTIONAL & RESEARCH AFFILIATES
                    </span>
                    <div class="flex flex-wrap items-center justify-between gap-6 md:gap-10 w-full md:w-auto">
                        <div
                            v-for="(partner, idx) in partners"
                            :key="idx"
                            class="font-mono text-xs sm:text-sm font-semibold tracking-wider text-ink-muted hover:text-ink transition-colors cursor-default"
                        >
                            {{ partner.logo || partner.name }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Interdisciplinary Approaches for Systemic Impact (Core Pillars) -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-2">
                        <span>01 / CORE PILLARS & INITIATIVES</span>
                    </div>
                    <h2 class="font-serif text-3xl sm:text-4xl text-ink font-normal tracking-tight">
                        Interdisciplinary Approaches for<br />Systemic Impact
                    </h2>
                </div>
                <p class="text-sm text-ink-muted max-w-md">
                    Synthesizing empirical field data with normative constitutional jurisprudence to construct actionable policy remedies across Southeast Asia.
                </p>
            </div>

            <!-- 3 Pillar Cards (Including 1 Solid Red Terracotta Card) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: Climate -->
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-hairline flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-mono text-[11px] text-ink-subtle uppercase">01 / CLIMATE</span>
                            <span class="w-6 h-6 rounded-full border border-hairline flex items-center justify-center text-xs text-ink-muted">↗</span>
                        </div>
                        <h3 class="font-serif text-2xl text-ink mb-3 font-normal">
                            Gender Justice &<br />Climate Change
                        </h3>
                        <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-6">
                            Investigating disproportionate coastal vulnerabilities, forced migration patterns, and unregistered female informal labor within climate-affected island archipelagos.
                        </p>
                    </div>
                    <div>
                        <div class="bg-paper p-3 rounded-xl border border-hairline mb-4">
                            <div class="flex items-center justify-between text-[11px] font-mono text-ink-muted mb-1">
                                <span>Vulnerability Index Shift</span>
                                <span class="text-terracotta font-medium">+34.2%</span>
                            </div>
                            <!-- Mini Sparkline SVG -->
                            <svg class="w-full h-8 text-terracotta" viewBox="0 0 100 25" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M0 20 L20 18 L40 14 L60 16 L80 8 L100 4" />
                            </svg>
                        </div>
                        <Link :href="route('programs.index')" class="font-mono text-xs text-ink hover:text-terracotta font-medium flex items-center gap-1.5 transition-colors">
                            <span>Read Cluster Dossier</span>
                            <span>→</span>
                        </Link>
                    </div>
                </div>

                <!-- Card 2: Legal Reform -->
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-hairline flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-mono text-[11px] text-ink-subtle uppercase">02 / ADVOCACY</span>
                            <span class="w-6 h-6 rounded-full border border-hairline flex items-center justify-center text-xs text-ink-muted">↗</span>
                        </div>
                        <h3 class="font-serif text-2xl text-ink mb-3 font-normal">
                            Public Policy &<br />Legal Reform
                        </h3>
                        <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-6">
                            Drafting statutory reforms on criminal code procedures, bodily autonomy protection, and procedural violence defense for grassroots public defenders.
                        </p>
                    </div>
                    <div>
                        <div class="bg-paper p-3 rounded-xl border border-hairline mb-4 space-y-1.5">
                            <div class="flex items-center justify-between text-[11px] font-mono text-ink-muted">
                                <span>Policy Adoption Rate</span>
                                <span class="font-semibold text-ink">78%</span>
                            </div>
                            <div class="w-full bg-hairline h-1.5 rounded-full overflow-hidden">
                                <div class="bg-ink h-full rounded-full" style="width: 78%"></div>
                            </div>
                        </div>
                        <Link :href="route('publications.index', { category: 'Policy Brief' })" class="font-mono text-xs text-ink hover:text-terracotta font-medium flex items-center gap-1.5 transition-colors">
                            <span>Jurisprudence Archive</span>
                            <span>→</span>
                        </Link>
                    </div>
                </div>

                <!-- Card 3: SOLID TERRACOTTA CARD (Matches Screenshot 4) -->
                <div class="bg-terracotta text-white p-6 sm:p-8 rounded-2xl flex flex-col justify-between shadow-lg relative overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-white/20 text-white font-mono text-[10px] uppercase px-2.5 py-1 rounded-full tracking-wider">
                                03 / INCUBATOR
                            </span>
                            <span class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs text-white">↗</span>
                        </div>
                        <h3 class="font-serif text-2xl text-white mb-3 font-normal">
                            Intersectional<br />Gender Policy Lab
                        </h3>
                        <p class="text-xs sm:text-sm text-white/90 leading-relaxed mb-6">
                            Translating academic rigor into actionable governance toolkits. We prototype and stress-test gender budgeting pathways with regional civil servants and community auditors.
                        </p>
                    </div>
                    <div class="space-y-4">
                        <div class="border-t border-white/20 pt-4 text-xs font-mono text-white/80">
                            120+ Subnational Audits Completed
                        </div>
                        <Link
                            :href="route('programs.index')"
                            class="block text-center bg-white hover:bg-paper text-terracotta font-mono text-xs font-semibold py-3 px-4 rounded-full transition-colors shadow-sm"
                        >
                            ACCESS OPEN DATA PORTAL ↗
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Recent Academic Publications & Policy Drafts -->
        <section class="bg-[#f5f4ef] border-t border-hairline py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-2">
                            <span>02 / RESEARCH ARCHIVE</span>
                        </div>
                        <h2 class="font-serif text-3xl sm:text-4xl text-ink font-normal tracking-tight">
                            Recent Academic Publications & Policy Drafts
                        </h2>
                    </div>
                    <Link
                        :href="route('publications.index')"
                        class="hidden sm:inline-flex font-mono text-xs text-ink hover:text-terracotta transition-colors uppercase tracking-wider"
                    >
                        VIEW FULL REPOSITORY ({{ stats?.publications_count || '60+' }}) →
                    </Link>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                    <!-- Left: Featured Card with Image -->
                    <div v-if="featuredLargeArticle" class="lg:col-span-7 bg-white rounded-2xl border border-hairline p-6 sm:p-8 flex flex-col justify-between">
                        <div>
                            <div class="relative aspect-[16/9] rounded-xl overflow-hidden mb-6 bg-neutral-900 group">
                                <img
                                    :src="featuredLargeArticle.thumbnail || 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1200&auto=format&fit=crop'"
                                    :alt="featuredLargeArticle.title"
                                    class="w-full h-full object-cover grayscale contrast-105 group-hover:scale-105 transition-transform duration-700"
                                />
                                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-full text-[10px] font-mono text-ink font-semibold uppercase tracking-wider">
                                    {{ featuredLargeArticle.category }}
                                </div>
                            </div>
                            <h3 class="font-serif text-2xl sm:text-3xl text-ink font-normal leading-tight mb-3">
                                <Link :href="route('publications.show', featuredLargeArticle.slug)" class="hover:text-terracotta transition-colors">
                                    {{ featuredLargeArticle.title }}
                                </Link>
                            </h3>
                            <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mb-6 line-clamp-3">
                                {{ featuredLargeArticle.excerpt }}
                            </p>
                        </div>
                        <div class="flex items-center justify-between border-t border-hairline pt-4 text-xs font-mono">
                            <span class="text-ink-muted">{{ featuredLargeArticle.author }}</span>
                            <Link
                                :href="route('publications.show', featuredLargeArticle.slug)"
                                class="text-ink hover:text-terracotta font-semibold uppercase flex items-center gap-1.5 transition-colors"
                            >
                                <span>READ FULL RESEARCH</span>
                                <span>→</span>
                            </Link>
                        </div>
                    </div>

                    <!-- Right: Stacked 3 Publication Cards -->
                    <div class="lg:col-span-5 flex flex-col justify-between gap-4">
                        <div
                            v-for="(item, idx) in sideArticles"
                            :key="idx"
                            class="bg-white p-5 rounded-xl border border-hairline flex flex-col justify-between hover:border-ink/40 transition-all group"
                        >
                            <div>
                                <div class="flex items-center justify-between text-[11px] font-mono text-ink-subtle mb-2">
                                    <span class="uppercase tracking-wider">{{ item.category }}</span>
                                    <span>{{ new Date(item.published_at).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) }}</span>
                                </div>
                                <h4 class="font-serif text-lg text-ink font-medium leading-snug group-hover:text-terracotta transition-colors mb-2">
                                    <Link :href="route('publications.show', item.slug)">
                                        {{ item.title }}
                                    </Link>
                                </h4>
                                <p class="text-xs text-ink-muted leading-relaxed line-clamp-2 mb-3">
                                    {{ item.excerpt }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between text-[11px] font-mono pt-2 border-t border-hairline/60">
                                <span class="text-ink-subtle truncate max-w-[200px]">{{ item.author }}</span>
                                <Link :href="route('publications.show', item.slug)" class="text-terracotta font-medium hover:underline">
                                    READ ↗
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. Editorial Quote Section -->
        <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="border-l-2 border-terracotta pl-6 sm:pl-10 space-y-6">
                <span class="font-serif text-5xl sm:text-6xl text-terracotta leading-none select-none">“</span>
                <blockquote class="font-serif text-2xl sm:text-3xl lg:text-4xl text-ink font-light leading-snug tracking-tight -mt-6">
                    Rigorous research is not a bystander in policy battles; it is the blueprint through which marginalized communities claim statutory dignity and dismantle structural silence.
                </blockquote>
                <div class="pt-2">
                    <div class="font-mono text-xs uppercase tracking-widest text-ink font-semibold">
                        Prof. Dr. Amanda Dewi, Ph.D.
                    </div>
                    <div class="text-xs text-ink-muted font-mono">
                        Director of Research & Critical Theory · Center for Gender and International Relations Studies (GInRe)
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. Call To Action Banner -->
        <section id="collaborate" class="bg-white border-y border-hairline py-16 sm:py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
                <div class="inline-flex items-center gap-2 bg-paper px-3 py-1 rounded-full border border-hairline text-xs font-mono text-terracotta">
                    <span>●</span>
                    <span>INSTITUTIONAL PARTNERSHIP · 2025-2026</span>
                </div>

                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-ink font-normal tracking-tight">
                    Ready to Integrate Evidence-Based<br />Research into Your Public Policy?
                </h2>

                <p class="text-sm sm:text-base text-ink-muted max-w-2xl mx-auto leading-relaxed">
                    We partner with government ministries, civil society coalitions, and international bodies to develop rigorous, rights-affirming frameworks on critical public challenges.
                </p>

                <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                    <a
                        href="mailto:director@kerisgender.org"
                        class="inline-flex items-center gap-2 bg-ink hover:bg-black text-white text-xs sm:text-sm font-medium px-6 py-3 rounded-full transition-all duration-200 shadow-sm hover:shadow"
                    >
                        <span>INITIATE RESEARCH PARTNERSHIP</span>
                        <span>→</span>
                    </a>
                    <Link
                        :href="route('programs.index')"
                        class="inline-flex items-center gap-2 bg-paper hover:bg-white text-ink text-xs sm:text-sm font-medium px-6 py-3 rounded-full border border-hairline transition-all duration-200"
                    >
                        <span>DOWNLOAD CAPABILITY STATEMENT</span>
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
