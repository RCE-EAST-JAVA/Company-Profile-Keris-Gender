<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    staff: Object,
});

const formattedDescription = computed(() => {
    const raw = props.staff?.description || '';
    if (!raw) return '';
    // If it already contains HTML tags (from rich text editor)
    if (/<[a-z][\s\S]*>/i.test(raw)) {
        return raw;
    }
    // If it is plain text, convert paragraph breaks into <p> tags and line breaks into <br />
    return raw
        .split(/\n\s*\n/)
        .map((paragraph) => `<p>${paragraph.replace(/\n/g, '<br />')}</p>`)
        .join('');
});
</script>

<template>
    <PublicLayout>
        <Head :title="`${staff.name} — People in GInRe`" />

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 sm:pt-14 pb-24">
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs font-mono text-ink-muted mb-8 animate-fade-in-up animation-delay-75">
                <Link :href="route('people.index')" class="hover:text-ink transition-colors">
                    ← Back to People in GInRe
                </Link>
                <span>/</span>
                <span class="text-ink truncate max-w-xs">{{ staff.name }}</span>
            </div>

            <!-- Profile Hero Card -->
            <div v-reveal="{ delay: 100 }" class="bg-white rounded-2xl border border-hairline p-6 sm:p-10 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-10 items-start">
                    <!-- Portrait & Contacts Column Left -->
                    <div class="md:col-span-4 space-y-6">
                        <div class="aspect-[4/5] rounded-xl overflow-hidden bg-neutral-100 border border-hairline shadow-sm relative">
                            <img
                                :src="staff.image || 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop'"
                                :alt="staff.name"
                                class="w-full h-full object-cover"
                            />
                            <div class="absolute bottom-3 right-3 bg-black/75 backdrop-blur-md px-2.5 py-1 rounded-md text-[11px] font-mono text-white">
                                {{ staff.category }}
                            </div>
                        </div>

                        <!-- Contact & Links (Email and LinkedIn) -->
                        <div class="space-y-2.5 pt-2">
                            <span class="font-mono text-[11px] text-ink-subtle uppercase tracking-wider block mb-2">
                                Connect & Inquiries
                            </span>

                            <!-- Email Link -->
                            <a
                                v-if="staff.email"
                                :href="`mailto:${staff.email}`"
                                class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-lg border border-hairline bg-paper/60 hover:bg-paper hover:border-ink/40 text-xs font-mono text-ink transition-colors group"
                            >
                                <svg class="w-4 h-4 text-terracotta shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="truncate">{{ staff.email }}</span>
                            </a>

                            <!-- LinkedIn Link -->
                            <a
                                v-if="staff.linkedin"
                                :href="staff.linkedin"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-between px-3.5 py-2.5 rounded-lg border border-hairline bg-paper/60 hover:bg-paper hover:border-ink/40 text-xs font-mono text-ink transition-colors group"
                            >
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <svg class="w-4 h-4 text-[#0a66c2] shrink-0 fill-current" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                    <span class="truncate font-medium">LinkedIn Profile</span>
                                </div>
                                <span class="text-ink-subtle group-hover:text-terracotta text-xs shrink-0">↗</span>
                            </a>

                            <div v-if="!staff.email && !staff.linkedin" class="text-xs font-mono text-ink-subtle italic">
                                No direct links available.
                            </div>
                        </div>
                    </div>

                    <!-- Details Column Right -->
                    <div class="md:col-span-8 space-y-5">
                        <div class="flex items-center gap-2 text-xs font-mono text-terracotta uppercase tracking-wider font-semibold">
                            <span>{{ staff.category.toUpperCase() }} OF GINRE</span>
                        </div>

                        <div>
                            <h1 class="font-serif text-3xl sm:text-4xl text-ink font-normal leading-tight mb-2">
                                {{ staff.name }}
                            </h1>
                            <div class="text-sm font-medium text-ink-muted">
                                {{ staff.role }}
                            </div>
                        </div>

                        <!-- Expertise Tags -->
                        <div v-if="staff.expertise" class="pt-1">
                            <span class="block font-mono text-[11px] text-ink-subtle uppercase tracking-wider mb-2">Areas of Expertise</span>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    v-for="(tag, idx) in staff.expertise.split(',')"
                                    :key="idx"
                                    class="bg-paper px-3 py-1 rounded-md border border-hairline text-xs font-mono text-ink"
                                >
                                    {{ tag.trim() }}
                                </span>
                            </div>
                        </div>

                        <!-- Description Bio with Rich Text Editor Support -->
                        <div class="pt-6 border-t border-hairline font-sans space-y-3">
                            <h2 class="font-serif text-xl text-ink font-normal mb-3">
                                Biography & Overview
                            </h2>
                            <div
                                v-if="staff.description"
                                class="scholar-rich-text text-sm leading-relaxed text-justify"
                                v-html="formattedDescription"
                            />
                            <p v-else class="text-ink-subtle italic text-xs font-mono">
                                No biography recorded yet.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>

<style>
/* Rich Content & Text Editor Typography Styles */
.scholar-rich-text {
    color: #4a4843;
}

.scholar-rich-text p {
    margin-bottom: 1.25rem;
    line-height: 1.8;
}

.scholar-rich-text p:last-child {
    margin-bottom: 0;
}

.scholar-rich-text h1,
.scholar-rich-text h2,
.scholar-rich-text h3,
.scholar-rich-text h4,
.scholar-rich-text h5,
.scholar-rich-text h6 {
    font-family: Newsreader, "Cormorant Garamond", Georgia, serif;
    font-weight: 500;
    color: #0f0f10;
    margin-top: 1.75rem;
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.scholar-rich-text h1 {
    font-size: 1.5rem;
}

.scholar-rich-text h2 {
    font-size: 1.35rem;
}

.scholar-rich-text h3 {
    font-size: 1.2rem;
}

.scholar-rich-text h4 {
    font-size: 1.05rem;
}

.scholar-rich-text ul {
    list-style-type: disc;
    padding-left: 1.5rem;
    margin-top: 0.75rem;
    margin-bottom: 1.25rem;
}

.scholar-rich-text ol {
    list-style-type: decimal;
    padding-left: 1.5rem;
    margin-top: 0.75rem;
    margin-bottom: 1.25rem;
}

.scholar-rich-text li {
    margin-bottom: 0.5rem;
    line-height: 1.7;
    color: #4a4843;
}

.scholar-rich-text blockquote {
    border-left: 3px solid #b83220;
    padding: 0.75rem 1.25rem;
    margin: 1.25rem 0;
    font-style: italic;
    color: #4a4843;
    background-color: #fafaf9;
    border-radius: 0 0.5rem 0.5rem 0;
}

.scholar-rich-text a {
    color: #b83220;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.15s ease;
}

.scholar-rich-text a:hover {
    color: #992819;
}

.scholar-rich-text strong,
.scholar-rich-text b {
    font-weight: 600;
    color: #0f0f10;
}

.scholar-rich-text em,
.scholar-rich-text i {
    font-style: italic;
}

.scholar-rich-text u {
    text-decoration: underline;
    text-underline-offset: 2px;
}

.scholar-rich-text s,
.scholar-rich-text del,
.scholar-rich-text strike {
    text-decoration: line-through;
}

.scholar-rich-text hr {
    border: none;
    border-top: 1px solid #e5e4de;
    margin: 1.75rem 0;
}

.scholar-rich-text table {
    width: 100%;
    margin: 1.25rem 0;
    border-collapse: collapse;
    border: 1px solid #e5e4de;
    font-size: 0.875rem;
}

.scholar-rich-text th,
.scholar-rich-text td {
    padding: 0.6rem 0.85rem;
    border: 1px solid #e5e4de;
    text-align: left;
}

.scholar-rich-text th {
    background-color: #fafaf9;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.75rem;
    text-transform: uppercase;
    font-weight: 600;
}

.scholar-rich-text img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1.25rem 0;
    border: 1px solid #e5e4de;
}

.scholar-rich-text code {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85em;
    background: #fafaf9;
    padding: 0.15rem 0.35rem;
    border-radius: 0.25rem;
    border: 1px solid #e5e4de;
}

.scholar-rich-text pre {
    background: #fafaf9;
    padding: 1rem;
    border-radius: 0.5rem;
    border: 1px solid #e5e4de;
    overflow-x: auto;
    margin: 1.25rem 0;
}

.scholar-rich-text pre code {
    background: transparent;
    padding: 0;
    border: none;
}
</style>
