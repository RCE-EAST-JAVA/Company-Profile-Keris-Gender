<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { stripHtml } from '@/Utils/text';

const props = defineProps({
    about: Object,
    heroPhotos: {
        type: Array,
        default: () => [],
    },
    heroPhoto: Object,
    heroBackground: Object,
    partners: Array,
    programs: Array,
    featuredMonograph: Object,
    recentPublications: Array,
    stats: Object,
});

const aboutDescription = computed(() => {
    if (props.about?.description) {
        return props.about.description;
    }
    return "Center for Gender and International Relations Studies (GInRe) adalah lembaga penelitian akademik independen yang berdedikasi untuk mendekonstruksi wacana sosial-budaya, ketimpangan struktural, dan memajukan keadilan gender berbasis bukti ilmiah di seluruh Asia Tenggara.\n\nMelalui sintesis data lapangan empiris dan yurisprudensi normatif, kami merumuskan rekomendasi kebijakan yang dapat ditindaklanjuti untuk mengatasi tantangan kritis publik—mulai dari keadilan gender dalam krisis iklim, reformasi hukum dan advokasi kebijakan publik, hingga advokasi anggaran responsif gender bagi pengambil kebijakan di tingkat daerah maupun nasional.";
});

const featuredLargeArticle = props.recentPublications?.[0] || props.featuredMonograph;
const sideArticles = props.recentPublications?.slice(1, 4) || [];

// Partners list: only use actual database partners, never inject mock/fallback items
const partnerList = computed(() => {
    if (!props.partners || props.partners.length === 0) {
        return [];
    }

    // Duplicate database partners until track is comfortably wide (>= 24 items)
    // so that Track 1 & Track 2 span well beyond any ultrawide/4K screen without gaps or jump cuts
    let filled = [...props.partners];
    while (filled.length < 24) {
        filled = filled.concat(props.partners);
    }
    return filled;
});

const isLogoImage = (logo) => {
    if (!logo || typeof logo !== 'string') return false;
    const lower = logo.toLowerCase();
    return lower.endsWith('.svg') || lower.endsWith('.png') || lower.endsWith('.jpg') || lower.endsWith('.jpeg') || lower.endsWith('.webp') || lower.startsWith('http://') || lower.startsWith('https://') || lower.includes('/storage/');
};

const getLogoUrl = (logo) => {
    if (!logo) return '';
    if (logo.startsWith('http://') || logo.startsWith('https://') || logo.startsWith('/')) {
        return logo;
    }
    return `/storage/${logo}`;
};

const getImageUrl = (image) => {
    if (!image) return 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200&auto=format&fit=crop';
    if (image.startsWith('http://') || image.startsWith('https://') || image.startsWith('/')) {
        return image;
    }
    return `/storage/${image}`;
};

// Programs list with fallback
const programList = computed(() => {
    if (props.programs && props.programs.length > 0) {
        return props.programs.slice(0, 3);
    }
});

// Fallback list of photos for carousel
const activePhotoList = computed(() => {
    if (props.heroPhotos && props.heroPhotos.length > 0) {
        return props.heroPhotos;
    }
    if (props.heroPhoto) {
        return [props.heroPhoto];
    }
    return [
        {
            image: 'https://images.unsplash.com/photo-1544654803-b69140b285a1?q=80&w=1200&auto=format&fit=crop',
            caption: 'Women Fishers Resistance in Wawonii: Mining & Ecosystem Destruction',
        },
    ];
});

const currentSlide = ref(0);
const isPaused = ref(false);
let slideTimer = null;

const startSlideShow = () => {
    stopSlideShow();
    if (activePhotoList.value.length > 1) {
        slideTimer = setInterval(() => {
            if (!isPaused.value) {
                currentSlide.value = (currentSlide.value + 1) % activePhotoList.value.length;
            }
        }, 5000);
    }
};

const stopSlideShow = () => {
    if (slideTimer) {
        clearInterval(slideTimer);
        slideTimer = null;
    }
};

const goToSlide = (idx) => {
    currentSlide.value = idx;
    startSlideShow();
};

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % activePhotoList.value.length;
    startSlideShow();
};

const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + activePhotoList.value.length) % activePhotoList.value.length;
    startSlideShow();
};

onMounted(() => {
    startSlideShow();
});

onUnmounted(() => {
    stopSlideShow();
});
</script>

<template>
    <PublicLayout :transparentHeader="true">
        <Head title="Center for Gender and International Relations Studies (GInRe) — Dismantling Inequality, Weaving a Just Future" />

        <!-- 1. Hero Section (Full Viewport Height with Static Background & Floating Auto-Slide Card) -->
        <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-24 pb-20 sm:pt-28 sm:pb-24 lg:pt-32 lg:pb-28">
            <!-- Static Hero Background (1 Gambar, Tidak Di-slide) -->
            <div class="absolute inset-0 z-0 select-none">
                <img
                    :src="heroBackground?.image || 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1920&auto=format&fit=crop'"
                    :alt="heroBackground?.title || 'Hero background'"
                    class="w-full h-full object-cover"
                />
                <!-- Atmospheric Dark Gradient Overlay for Maximum Readability -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/75 to-black/55 backdrop-blur-[0.5px]"></div>
                <!-- Bottom Smooth Vignette to Content Paper Background -->
                <!-- <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-[#f7f6f1] via-[#f7f6f1]/40 to-transparent"></div> -->
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-center">
                    <!-- Left Hero Content -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="flex items-center gap-2 font-mono text-xs text-terracotta font-semibold tracking-wider uppercase animate-fade-in-up animation-delay-100">
                            <span>INDEPENDENT ACADEMIC RESEARCH INSTITUTE</span>
                        </div>

                        <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-white font-normal tracking-tight leading-[1.12] animate-fade-in-up animation-delay-200">
                            Dismantling Inequality,<br />
                            <span class="italic font-light text-white/95">Weaving a Just Future.</span>
                        </h1>

                        <p class="text-base sm:text-lg text-white/80 leading-relaxed max-w-xl font-normal animate-fade-in-up animation-delay-300">
                            An independent academic and policy research collective interrogating gender violence, agrarian inequality, and institutional patriarchies to cultivate emancipatory governance across Southeast Asia.
                        </p>

                        <!-- Action Buttons -->
                        <div class="pt-2 flex flex-wrap items-center gap-4 animate-fade-in-up animation-delay-400">
                            <Link
                                :href="route('publications.index')"
                                class="inline-flex items-center gap-2 bg-terracotta hover:bg-[#a62b1a] text-white text-xs sm:text-sm font-semibold px-7 py-3.5 rounded-full transition-all duration-200 shadow-md hover:shadow-lg"
                            >
                                <span>EXPLORE PUBLICATIONS</span>
                                <span>→</span>
                            </Link>
                            <Link
                                :href="route('programs.index')"
                                class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white backdrop-blur-md text-xs sm:text-sm font-medium px-6 py-3.5 rounded-full border border-white/30 transition-all duration-200"
                            >
                                <span>VIEW GINTRE`S PROGRAMS</span>
                            </Link>
                        </div>

                        <!-- Meta / Proof Pills -->
                        <div class="pt-6 flex flex-wrap items-center gap-3 sm:gap-4 text-xs font-mono text-white/90 animate-fade-in-up animation-delay-500">
                            <div class="flex items-center gap-1.5 bg-black/40 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/15 shadow-xs">
                                <span class="text-white font-semibold">Publications:</span>
                                <span class="text-white/80">{{ stats?.publications_count ?? '0' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 bg-black/40 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/15 shadow-xs">
                                <span class="text-white font-semibold">Partners:</span>
                                <span class="text-white/80">{{ stats?.partners_count ?? '0' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 bg-black/40 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/15 shadow-xs">
                                <span class="text-white font-semibold">Programs:</span>
                                <span class="text-white/80">{{ stats?.active_programs_count ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Hero Floating Story Card (Auto Slide Carousel) -->
                    <div class="lg:col-span-5 animate-fade-in-right animation-delay-300">
                        <div
                            @mouseenter="isPaused = true"
                            @mouseleave="isPaused = false"
                            class="relative bg-white/10 backdrop-blur-xl p-3.5 sm:p-4 rounded-lg border border-white/30 shadow-2xl transition-transform hover:-translate-y-1 duration-300 group"
                        >
                            <!-- Image Slide Viewport -->
                            <div class="relative aspect-[4/3] rounded overflow-hidden bg-neutral-900 select-none">
                                <transition name="carousel-fade" mode="out-in">
                                    <div :key="currentSlide" class="w-full h-full relative">
                                        <img
                                            :src="activePhotoList[currentSlide]?.image"
                                            :alt="activePhotoList[currentSlide]?.caption || 'Hero photo'"
                                            class="w-full h-full object-cover contrast-105 group-hover:scale-105 transition-transform duration-700"
                                        />
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent"></div>

                                        <!-- Bottom Overlay Caption -->
                                        <div class="absolute bottom-3.5 left-3.5 right-3.5 text-white">
                                            <p class="text-xs sm:text-sm font-serif font-medium leading-snug">
                                                {{ activePhotoList[currentSlide]?.caption || 'Women Fishers' }}
                                            </p>
                                        </div>
                                    </div>
                                </transition>

                                <!-- Navigation Arrow Controls (Visible on Hover) -->
                                <button
                                    v-if="activePhotoList.length > 1"
                                    @click.stop="prevSlide"
                                    type="button"
                                    aria-label="Previous slide"
                                    class="absolute left-2.5 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/40 hover:bg-black/70 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-sm text-sm"
                                >
                                    ‹
                                </button>
                                <button
                                    v-if="activePhotoList.length > 1"
                                    @click.stop="nextSlide"
                                    type="button"
                                    aria-label="Next slide"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/40 hover:bg-black/70 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-sm text-sm"
                                >
                                    ›
                                </button>
                            </div>

                            <!-- Carousel Indicators & Controls Footer -->
                            <div v-if="activePhotoList.length > 1" class="pt-3 px-1 flex items-center justify-center">
                                <div class="flex items-center gap-1.5">
                                    <button
                                        v-for="(_, idx) in activePhotoList"
                                        :key="idx"
                                        @click="goToSlide(idx)"
                                        type="button"
                                        :aria-label="`Go to slide ${idx + 1}`"
                                        :class="[
                                            'h-1.5 rounded-full transition-all duration-300',
                                            currentSlide === idx ? 'w-6 bg-terracotta' : 'w-2 bg-neutral-300 hover:bg-neutral-400'
                                        ]"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. About GinRe (Core Pillars & Initiatives) -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div v-reveal class="mb-12">
                <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-2">
                    <span>01 / CENTER FOR GENDER AND INTERNATIONAL RELATIONS STUDIES</span>
                </div>
                <h2 class="font-serif text-3xl sm:text-4xl text-ink font-normal tracking-tight">
                    About GinRe
                </h2>
            </div>

            <!-- About GinRe Dynamic Description from Database -->
            <div v-reveal="{ delay: 150 }" class="bg-white rounded-2xl border border-hairline p-8 sm:p-12 lg:p-14 shadow-xs relative overflow-hidden">
                <!-- Subtle Aesthetic Gradient Backdrop -->
                <div class="absolute -right-16 -bottom-16 w-72 h-72 bg-terracotta/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-full">
                    <p class="text-base sm:text-lg text-ink/90 font-sans leading-relaxed sm:leading-loose whitespace-pre-line font-light text-justify">
                        {{ aboutDescription }}
                    </p>
                </div>
            </div>
        </section>

        <!-- 3. Institutional & Research Affiliates (Only displayed when actual partners exist) -->
        <section v-if="partnerList && partnerList.length > 0" class="border-y border-hairline/80 bg-[#f7f6f1] py-16 sm:py-20 overflow-hidden">
            <!-- Header Matching Standard Section Pattern -->
            <div v-reveal class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10 sm:mb-12">
                <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-2">
                    <span>02 / PARTNERS & COLLABORATORS</span>
                </div>
                <h2 class="font-serif text-3xl sm:text-4xl text-ink font-normal tracking-tight">
                    Institutional & Research Affiliates
                </h2>
            </div>

            <!-- Continuous Infinite Animated Marquee -->
            <div v-reveal="{ delay: 120, direction: 'fade' }" class="relative w-full overflow-hidden group">
                <!-- Left & Right Gradient Fade Masks -->
                <div class="pointer-events-none absolute inset-y-0 left-0 w-16 sm:w-28 bg-gradient-to-r from-[#f7f6f1] to-transparent z-10"></div>
                <div class="pointer-events-none absolute inset-y-0 right-0 w-16 sm:w-28 bg-gradient-to-l from-[#f7f6f1] to-transparent z-10"></div>

                <!-- Marquee Track Wrapper -->
                <div class="flex w-max select-none">
                    <!-- Track 1 -->
                    <div class="flex items-center gap-6 sm:gap-10 shrink-0 animate-marquee group-hover:[animation-play-state:paused] pr-6 sm:pr-10">
                        <div
                            v-for="(partner, idx) in partnerList"
                            :key="'track1-' + idx"
                            class="shrink-0"
                        >
                            <!-- If partner logo is an image -->
                            <div
                                v-if="isLogoImage(partner.logo)"
                                class="h-14 sm:h-16 px-4 py-2 flex items-center justify-center rounded-xl bg-white/90 border border-hairline hover:border-terracotta/40 hover:bg-white shadow-xs transition-all duration-300"
                            >
                                <img
                                    :src="getLogoUrl(partner.logo)"
                                    :alt="partner.name"
                                    class="h-9 sm:h-11 w-auto max-w-[150px] object-contain opacity-75 hover:opacity-100 transition-all duration-300 pointer-events-none"
                                />
                            </div>

                            <!-- Text Badge with Emblem Accent -->
                            <div
                                v-else
                                class="flex items-center gap-2.5 px-4 sm:px-5 py-2.5 rounded-xl bg-white/90 border border-hairline hover:border-terracotta/40 hover:bg-white shadow-xs hover:shadow-sm transition-all duration-300"
                            >
                                <span class="w-2 h-2 rounded-full bg-terracotta/70 shrink-0"></span>
                                <span class="font-mono text-xs sm:text-sm font-semibold tracking-wider text-ink-muted group-hover:text-ink whitespace-nowrap">
                                    {{ partner.logo || partner.name }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Track 2 (Seamless loop duplicate) -->
                    <div class="flex items-center gap-6 sm:gap-10 shrink-0 animate-marquee group-hover:[animation-play-state:paused] pr-6 sm:pr-10" aria-hidden="true">
                        <div
                            v-for="(partner, idx) in partnerList"
                            :key="'track2-' + idx"
                            class="shrink-0"
                        >
                            <!-- If partner logo is an image -->
                            <div
                                v-if="isLogoImage(partner.logo)"
                                class="h-14 sm:h-16 px-4 py-2 flex items-center justify-center rounded-xl bg-white/90 border border-hairline hover:border-terracotta/40 hover:bg-white shadow-xs transition-all duration-300"
                            >
                                <img
                                    :src="getLogoUrl(partner.logo)"
                                    :alt="partner.name"
                                    class="h-9 sm:h-11 w-auto max-w-[150px] object-contain  opacity-75 hover:opacity-100 transition-all duration-300 pointer-events-none"
                                />
                            </div>

                            <!-- Text Badge with Emblem Accent -->
                            <div
                                v-else
                                class="flex items-center gap-2.5 px-4 sm:px-5 py-2.5 rounded-xl bg-white/90 border border-hairline hover:border-terracotta/40 hover:bg-white shadow-xs hover:shadow-sm transition-all duration-300"
                            >
                                <span class="w-2 h-2 rounded-full bg-terracotta/70 shrink-0"></span>
                                <span class="font-mono text-xs sm:text-sm font-semibold tracking-wider text-ink-muted group-hover:text-ink whitespace-nowrap">
                                    {{ partner.logo || partner.name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Programs & Research Initiatives -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div v-reveal class="flex items-center justify-between mb-12">
                <div>
                    <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-2">
                        <span>03 / RESEARCH PROGRAMS & INTERVENTIONS</span>
                    </div>
                    <h2 class="font-serif text-3xl sm:text-4xl text-ink font-normal tracking-tight">
                        Programs & Research Initiatives
                    </h2>
                </div>
                <Link
                    :href="route('programs.index')"
                    class="hidden sm:inline-flex font-mono text-xs text-ink hover:text-terracotta transition-colors uppercase tracking-wider items-center gap-1.5"
                >
                    <span>VIEW ALL PROGRAMS</span>
                    <span>→</span>
                </Link>
            </div>

            <!-- 3 Program Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                <div
                    v-for="(program, pIdx) in programList"
                    :key="program.id"
                    v-reveal="{ delay: pIdx * 120, direction: 'up' }"
                    class="bg-white rounded-2xl border border-hairline overflow-hidden flex flex-col justify-between hover:shadow-md hover:border-ink/40 transition-all duration-300 group"
                >
                    <div>
                        <!-- Activity Cover Photo -->
                        <div class="relative aspect-[16/10] bg-neutral-900 overflow-hidden">
                            <img
                                :src="getImageUrl(program.image || program.project_images?.[0]?.image)"
                                :alt="program.title"
                                class="w-full h-full object-cover contrast-105 group-hover:scale-105 transition-transform duration-700"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>

                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md px-2.5 py-1 rounded-full text-[10px] font-mono text-white flex items-center gap-1.5 border border-white/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-terracotta"></span>
                                <span>{{ program.category || 'PROGRAM' }}</span>
                            </div>

                            <!-- Bottom Floating Tag -->
                            <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-[10px] font-mono text-white">
                                <span v-if="program.date" class="bg-white/20 backdrop-blur-md px-2 py-0.5 rounded">
                                    CYCLE: {{ program.date }}
                                </span>
                                <span v-if="program.status" class="bg-black/50 backdrop-blur-sm px-2 py-0.5 rounded text-white/90">
                                    {{ program.status }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <div v-if="program.author" class="text-[11px] font-mono text-terracotta font-semibold uppercase tracking-wider mb-2 line-clamp-2" :title="program.author">
                                {{ program.author }}
                            </div>
                            <h3 class="font-serif text-xl sm:text-2xl text-ink font-normal leading-snug mb-3 group-hover:text-terracotta transition-colors line-clamp-3">
                                <Link :href="route('programs.show', program.slug || program.id)">
                                    {{ program.title }}
                                </Link>
                            </h3>
                            <p class="text-xs sm:text-sm text-ink-muted leading-relaxed line-clamp-3 mb-2">
                                {{ stripHtml(program.description) }}
                            </p>
                        </div>
                    </div>

                    <!-- Bottom Action Link -->
                    <div class="p-6 pt-0 flex items-center justify-between border-t border-hairline/60 pt-4 mt-auto">
                        <span class="text-xs font-mono text-ink-subtle">
                            {{ program.category }}
                        </span>
                        <Link
                            :href="route('programs.show', program.slug || program.id)"
                            class="font-mono text-xs text-ink group-hover:text-terracotta font-medium flex items-center gap-1.5 transition-colors"
                        >
                            <span>Explore Dossier</span>
                            <span>→</span>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Mobile View All Link -->
            <div class="mt-8 text-center sm:hidden">
                <Link
                    :href="route('programs.index')"
                    class="inline-flex items-center gap-2 font-mono text-xs text-ink hover:text-terracotta transition-colors uppercase tracking-wider"
                >
                    <span>VIEW ALL PROGRAMS</span>
                    <span>→</span>
                </Link>
            </div>
        </section>

        <!-- 5. Recent Academic Publications & Policy Drafts -->
        <section class="bg-[#f5f4ef] border-t border-hairline py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div v-reveal class="flex items-center justify-between mb-12">
                    <div>
                        <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-2">
                            <span>04 / RESEARCH ARCHIVE</span>
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
                    <div v-if="featuredLargeArticle" v-reveal="{ delay: 100, direction: 'left' }" class="lg:col-span-7 bg-white rounded-2xl border border-hairline p-6 sm:p-8 flex flex-col justify-between">
                        <div>
                            <div class="relative aspect-[16/9] rounded-xl overflow-hidden mb-6 bg-neutral-900 group">
                                <img
                                    :src="featuredLargeArticle.thumbnail || 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1200&auto=format&fit=crop'"
                                    :alt="featuredLargeArticle.title"
                                    class="w-full h-full object-cover contrast-105 group-hover:scale-105 transition-transform duration-700"
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
                            v-reveal="{ delay: 150 + idx * 100, direction: 'right' }"
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
    </PublicLayout>
</template>

<style scoped>
@keyframes marquee {
    0% {
        transform: translateX(0%);
    }
    100% {
        transform: translateX(-100%);
    }
}

.animate-marquee {
    animation: marquee 45s linear infinite;
    will-change: transform;
}

@media (prefers-reduced-motion: reduce) {
    .animate-marquee {
        animation: none;
    }
}
</style>
