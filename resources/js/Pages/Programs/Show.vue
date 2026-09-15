<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    project: Object,
    relatedProjects: Array,
});

const allImages = computed(() => {
    const list = [];
    if (props.project?.image) {
        list.push({
            id: 'main',
            image: props.project.image,
            caption: 'Main Activity Documentation',
        });
    }
    if (props.project?.project_images && props.project.project_images.length > 0) {
        props.project.project_images.forEach((img, idx) => {
            list.push({
                id: img.id || idx,
                image: img.image,
                caption: `Documentation Photo ${idx + 1}`,
            });
        });
    }
    return list;
});

const currentImageIndex = ref(0);

const nextImage = () => {
    if (allImages.value.length > 1) {
        currentImageIndex.value = (currentImageIndex.value + 1) % allImages.value.length;
    }
};

const prevImage = () => {
    if (allImages.value.length > 1) {
        currentImageIndex.value = (currentImageIndex.value - 1 + allImages.value.length) % allImages.value.length;
    }
};

const selectImage = (idx) => {
    currentImageIndex.value = idx;
};

const formattedContent = computed(() => {
    const raw = props.project?.description || '';
    // If it already contains HTML tags (from rich text editor)
    if (/<[a-z][\s\S]*>/i.test(raw)) {
        return raw;
    }
    // If it is plain text, convert paragraph blocks into <p>...</p>
    return raw
        .split(/\n\s*\n/)
        .map(paragraph => `<p>${paragraph.replace(/\n/g, '<br />')}</p>`)
        .join('');
});
</script>

<template>
    <PublicLayout>
        <Head :title="`${project.title} — Center for Gender and International Relations Studies (GInRe) Programs`" />

        <article class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 sm:pt-14 pb-20">
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs font-mono text-ink-muted mb-8">
                <Link :href="route('programs.index')" class="hover:text-ink transition-colors">
                    ← Back to All Programs
                </Link>
                <span>/</span>
                <span class="text-ink truncate max-w-xs">{{ project.title }}</span>
            </div>

            <!-- Program Header -->
            <header class="space-y-4 mb-10 pb-8 border-b border-hairline">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="bg-terracotta/10 text-terracotta font-mono text-xs uppercase px-3 py-1 rounded-full font-semibold">
                        ● {{ project.category }}
                    </span>
                    <span class="bg-paper text-ink-muted font-mono text-xs px-3 py-1 rounded-full border border-hairline">
                        Status: {{ project.status }}
                    </span>
                    <span v-if="project.date" class="font-mono text-xs text-ink-subtle">
                        Date: {{ project.date }}
                    </span>
                </div>

                <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-ink font-normal leading-tight">
                    {{ project.title }}
                </h1>

                <div v-if="project.author" class="flex items-center gap-2 pt-2 text-xs font-mono text-ink-muted">
                    <span>Directorate Lead:</span>
                    <span class="text-ink font-semibold">{{ project.author }}</span>
                </div>
            </header>

            <!-- Featured Image Carousel / Interactive Slider (Next / Prev between all photos) -->
            <div v-if="allImages.length > 0" class="mb-12 space-y-3">
                <div class="relative aspect-[16/9] rounded-2xl overflow-hidden bg-neutral-900 border border-hairline shadow-md group">
                    <img
                        :key="allImages[currentImageIndex]?.image"
                        :src="allImages[currentImageIndex]?.image"
                        :alt="`${project.title} documentation ${currentImageIndex + 1}`"
                        class="w-full h-full object-cover transition-opacity duration-300"
                    />

                    <!-- Vignette Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/20 pointer-events-none"></div>

                    <!-- Top Floating Counter & Badge -->
                    <div class="absolute top-4 left-4 bg-black/60 backdrop-blur-md px-3.5 py-1.5 rounded-full text-xs font-mono text-white flex items-center gap-2 border border-white/20 shadow-xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-terracotta"></span>
                        <span>PHOTO {{ currentImageIndex + 1 }} OF {{ allImages.length }}</span>
                    </div>

                    <!-- Prev & Next Overlay Buttons (Only when multiple photos exist) -->
                    <div v-if="allImages.length > 1" class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4 pointer-events-none">
                        <button
                            @click="prevImage"
                            type="button"
                            title="Previous Documentation Photo"
                            class="pointer-events-auto w-10 h-10 rounded-full bg-black/60 hover:bg-black text-white flex items-center justify-center text-sm font-mono border border-white/20 transition-all backdrop-blur-sm shadow-md hover:scale-110 active:scale-95"
                        >
                            ←
                        </button>
                        <button
                            @click="nextImage"
                            type="button"
                            title="Next Documentation Photo"
                            class="pointer-events-auto w-10 h-10 rounded-full bg-black/60 hover:bg-black text-white flex items-center justify-center text-sm font-mono border border-white/20 transition-all backdrop-blur-sm shadow-md hover:scale-110 active:scale-95"
                        >
                            →
                        </button>
                    </div>

                    <!-- Bottom Caption Bar -->
                    <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-xs font-mono text-white">
                        <span class="bg-black/50 backdrop-blur-md px-3 py-1 rounded border border-white/10">
                            {{ allImages[currentImageIndex]?.caption }}
                        </span>
                        <span v-if="project.date" class="bg-black/50 backdrop-blur-md px-3 py-1 rounded border border-white/10">
                            {{ project.date }}
                        </span>
                    </div>
                </div>

                <!-- Thumbnail Strip Below Featured Slider -->
                <div v-if="allImages.length > 1" class="flex items-center gap-3 overflow-x-auto pb-2 pt-1">
                    <button
                        v-for="(img, idx) in allImages"
                        :key="idx"
                        @click="selectImage(idx)"
                        type="button"
                        :title="`View photo ${idx + 1}`"
                        :class="[
                            'relative flex-shrink-0 w-20 sm:w-24 aspect-[16/10] rounded-lg overflow-hidden border-2 transition-all cursor-pointer',
                            currentImageIndex === idx ? 'border-terracotta ring-2 ring-terracotta/30 opacity-100' : 'border-hairline opacity-60 hover:opacity-100'
                        ]"
                    >
                        <img :src="img.image" :alt="`Thumbnail ${idx + 1}`" class="w-full h-full object-cover" />
                    </button>
                </div>
            </div>

            <!-- Program Content & Metadata Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 mb-16 items-start">
                <!-- Main Program Description -->
                <div class="lg:col-span-7 space-y-6 text-ink-muted text-sm sm:text-base leading-relaxed">
                    <div class="font-serif text-xl sm:text-2xl text-ink font-normal leading-snug">
                        Program Overview & Objectives
                    </div>

                    <div class="program-rich-text font-sans text-sm sm:text-base leading-relaxed" v-html="formattedContent"></div>
                </div>

                <!-- Sidebar Metadata & Actions (Pure Database Fields & Publication Navigation) -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-hairline shadow-sm space-y-4">
                        <h3 class="font-mono text-xs uppercase tracking-wider text-ink font-semibold">
                            Program Information
                        </h3>

                        <div class="space-y-4 text-xs font-mono border-t border-hairline pt-4">
                            <div class="flex justify-between items-start gap-4">
                                <span class="text-ink-subtle shrink-0">Category</span>
                                <span class="text-ink font-medium text-right">{{ project.category }}</span>
                            </div>
                            <div class="flex justify-between items-center gap-4">
                                <span class="text-ink-subtle shrink-0">Status</span>
                                <span class="text-terracotta font-semibold text-right">{{ project.status }}</span>
                            </div>
                            <div v-if="project.date" class="flex justify-between items-center gap-4">
                                <span class="text-ink-subtle shrink-0">Timeline / Cycle</span>
                                <span class="text-ink font-medium text-right">{{ project.date }}</span>
                            </div>
                            <div v-if="project.author" class="flex justify-between items-start gap-4">
                                <span class="text-ink-subtle shrink-0">Lead Researcher</span>
                                <span class="text-ink font-medium text-right leading-relaxed">{{ project.author }}</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-hairline space-y-2">
                            <Link
                                :href="route('programs.index')"
                                class="w-full block text-center bg-ink hover:bg-black text-white text-xs font-medium py-3 rounded-full transition-colors shadow-sm"
                            >
                                ← Back to All Programs
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Programs -->
            <section v-if="relatedProjects && relatedProjects.length > 0" class="border-t border-hairline pt-12">
                <h3 class="font-serif text-2xl text-ink font-normal mb-6">
                    Related Research Programs & Labs
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        v-for="rel in relatedProjects"
                        :key="rel.id"
                        class="bg-white p-5 rounded-xl border border-hairline flex flex-col justify-between hover:border-ink transition-all"
                    >
                        <div>
                            <span class="font-mono text-[10px] text-terracotta uppercase block mb-1">
                                {{ rel.category }}
                            </span>
                            <h4 class="font-serif text-lg text-ink font-medium leading-snug mb-2">
                                <Link :href="route('programs.show', rel.id)" class="hover:underline">
                                    {{ rel.title }}
                                </Link>
                            </h4>
                        </div>
                        <Link :href="route('programs.show', rel.id)" class="font-mono text-xs text-ink hover:text-terracotta font-semibold mt-4">
                            Explore →
                        </Link>
                    </div>
                </div>
            </section>
        </article>
    </PublicLayout>
</template>

<style>
/* Rich Content & Text Editor Typography Styles */
.program-rich-text p {
    margin-bottom: 1.25rem;
    line-height: 1.8;
    color: #2b2a27;
}

.program-rich-text p:last-child {
    margin-bottom: 0;
}

.program-rich-text h1,
.program-rich-text h2,
.program-rich-text h3,
.program-rich-text h4 {
    font-family: Newsreader, "Cormorant Garamond", Georgia, serif;
    font-weight: 500;
    color: #0f0f10;
    margin-top: 2rem;
    margin-bottom: 0.85rem;
    line-height: 1.3;
}

.program-rich-text h2 {
    font-size: 1.5rem;
}

.program-rich-text h3 {
    font-size: 1.25rem;
}

.program-rich-text h4 {
    font-size: 1.125rem;
}

.program-rich-text ul {
    list-style-type: disc;
    padding-left: 1.5rem;
    margin-top: 1rem;
    margin-bottom: 1.25rem;
}

.program-rich-text ol {
    list-style-type: decimal;
    padding-left: 1.5rem;
    margin-top: 1rem;
    margin-bottom: 1.25rem;
}

.program-rich-text li {
    margin-bottom: 0.5rem;
    line-height: 1.7;
    color: #2b2a27;
}

.program-rich-text blockquote {
    border-left: 3px solid #b83220;
    padding: 0.85rem 1.25rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #4a4843;
    background-color: #fafaf9;
    border-radius: 0 0.5rem 0.5rem 0;
}

.program-rich-text a {
    color: #b83220;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.15s ease;
}

.program-rich-text a:hover {
    color: #992819;
}

.program-rich-text strong,
.program-rich-text b {
    font-weight: 600;
    color: #0f0f10;
}

.program-rich-text em,
.program-rich-text i {
    font-style: italic;
}

.program-rich-text hr {
    border: none;
    border-top: 1px solid #e5e4de;
    margin: 2rem 0;
}

.program-rich-text table {
    width: 100%;
    margin: 1.5rem 0;
    border-collapse: collapse;
    border: 1px solid #e5e4de;
    font-size: 0.875rem;
}

.program-rich-text th,
.program-rich-text td {
    padding: 0.75rem 1rem;
    border: 1px solid #e5e4de;
    text-align: left;
}

.program-rich-text th {
    background-color: #fafaf9;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.75rem;
    text-transform: uppercase;
    font-weight: 600;
}

.program-rich-text img {
    max-width: 100%;
    height: auto;
    border-radius: 0.75rem;
    margin: 1.5rem 0;
    border: 1px solid #e5e4de;
}

.program-rich-text code {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85em;
    background: #fafaf9;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    border: 1px solid #e5e4de;
}

.program-rich-text iframe,
.program-rich-text div[data-youtube-video] iframe {
    width: 100%;
    aspect-ratio: 16 / 9;
    border-radius: 0.75rem;
    margin: 1.5rem 0;
    border: 1px solid #e5e4de;
}
</style>
