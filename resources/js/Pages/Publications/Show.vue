<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    article: Object,
    authorStaff: Object,
    relatedArticles: Array,
});

const formatRichText = (content) => {
    if (!content) return '';

    let raw = content;

    // Decode HTML entities if stored encoded (e.g. &lt;p&gt;...&lt;/p&gt;)
    if (raw.includes('&lt;') && raw.includes('&gt;') && !raw.includes('<')) {
        raw = raw
            .replace(/&lt;/g, '<')
            .replace(/&gt;/g, '>')
            .replace(/&amp;/g, '&')
            .replace(/&quot;/g, '"')
            .replace(/&#039;/g, "'")
            .replace(/&nbsp;/g, ' ');
    }

    // If it already contains HTML tags (from rich text editor)
    if (/<[a-z][\s\S]*>/i.test(raw)) {
        return raw;
    }

    // If it is plain text, convert paragraph breaks into <p> tags and line breaks into <br />
    return raw
        .split(/\n\s*\n/)
        .map((paragraph) => `<p>${paragraph.replace(/\n/g, '<br />')}</p>`)
        .join('');
};

const formattedContent = computed(() => formatRichText(props.article?.body));
const formattedExcerpt = computed(() => formatRichText(props.article?.excerpt));

const formatDate = (dateStr) => {
    if (!dateStr) return '';
    return new Date(dateStr).toLocaleDateString('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric',
    });
};
</script>

<template>
    <PublicLayout>
        <Head :title="`${article.title} — Center for Gender and International Relations Studies (GInRe)`" />

        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 sm:pt-14 pb-24">
            <!-- Breadcrumbs -->
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs font-mono text-ink-muted mb-8 animate-fade-in-up animation-delay-75">
                <Link :href="route('publications.index')" class="hover:text-ink transition-colors">
                    ← Back to All Publications
                </Link>
                <span>/</span>
                <span class="text-ink truncate max-w-xs">{{ article.title }}</span>
            </div>

            <!-- Header -->
            <header class="space-y-4 mb-8 pb-8 border-b border-hairline animate-fade-in-up animation-delay-150">
                <div class="flex flex-wrap items-center gap-3">
                    <span
                        v-if="article.is_pinned"
                        class="inline-flex items-center gap-1.5 bg-orange-100 text-terracotta border border-orange-300/80 font-mono text-xs uppercase px-3 py-1 rounded-full font-bold shadow-2xs"
                    >
                        <svg class="w-3.5 h-3.5 text-terracotta fill-current" viewBox="0 0 24 24">
                            <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/>
                        </svg>
                        <span>PINNED PUBLICATION</span>
                    </span>
                    <span class="bg-terracotta/10 text-terracotta font-mono text-xs uppercase px-3 py-1 rounded-full font-semibold">
                        {{ article.category }}
                    </span>
                    <span v-if="article.published_at" class="font-mono text-xs text-ink-subtle ml-auto">
                        Published: {{ formatDate(article.published_at) }}
                    </span>
                </div>

                <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-ink font-normal leading-tight">
                    {{ article.title }}
                </h1>

                <!-- Author & Affiliation -->
                <div class="flex flex-wrap items-center gap-4 pt-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-paper border border-hairline overflow-hidden flex items-center justify-center font-serif text-sm font-semibold text-ink">
                            <img
                                v-if="authorStaff?.image"
                                :src="authorStaff.image"
                                :alt="article.author"
                                class="w-full h-full object-cover"
                            />
                            <span v-else>{{ article.author?.slice(0, 2).toUpperCase() }}</span>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-ink">
                                <Link
                                    v-if="authorStaff"
                                    :href="route('people.show', authorStaff.slug || authorStaff.id)"
                                    class="hover:text-terracotta hover:underline transition-colors"
                                >
                                    {{ article.author }}
                                </Link>
                                <span v-else>{{ article.author }}</span>
                            </div>
                            <div class="text-xs text-ink-muted">
                                {{ authorStaff?.role || 'Center for Gender and International Relations Studies (GInRe)' }}
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            <!-- Featured Photo / Journal Cover (Supports portrait journals, monographs, and landscape banners without cropping) -->
            <div
                v-if="article.thumbnail"
                v-reveal="{ delay: 200 }"
                class="relative rounded-2xl overflow-hidden border border-hairline shadow-sm mb-10 bg-neutral-900/5 backdrop-blur-xs flex items-center justify-center p-4 sm:p-8 min-h-[300px] max-h-[580px]"
            >
                <!-- Ambient blurred background fill for portrait/irregular aspect ratios -->
                <div
                    class="absolute inset-0 bg-cover bg-center blur-2xl opacity-20 scale-110 pointer-events-none"
                    :style="{ backgroundImage: `url(${article.thumbnail})` }"
                ></div>

                <!-- Fully visible, uncropped cover image -->
                <img
                    :src="article.thumbnail"
                    :alt="article.title"
                    class="relative z-10 max-h-[520px] w-auto max-w-full rounded-xl shadow-md object-contain transition-transform duration-300"
                />
            </div>

            <!-- Abstract / Excerpt Block -->
            <div v-if="article.excerpt" v-reveal="{ delay: 100 }" class="bg-paper p-6 sm:p-8 rounded-2xl border border-hairline mb-10">
                <span class="font-mono text-xs text-terracotta uppercase tracking-wider block mb-3 font-semibold">
                    RINGKASAN
                </span>
                <div
                    class="font-serif text-lg sm:text-xl text-ink font-light leading-relaxed publication-rich-text text-justify"
                    v-html="formattedExcerpt"
                />
            </div>

            <!-- Publication Body Content with Rich Text Editor Typography -->
            <div v-reveal="{ delay: 150 }" class="mb-14">
                <div class="flex items-center justify-between pb-3 mb-6 border-b border-hairline">
                    <h2 class="font-serif text-2xl sm:text-3xl text-ink font-normal">
                        Content
                    </h2>
                   
                </div>
                <div
                    v-if="article.body"
                    class="publication-rich-text text-base sm:text-[17px] leading-relaxed font-sans text-justify"
                    v-html="formattedContent"
                />
                <p v-else class="text-xs font-mono text-ink-subtle italic">
                    No description or publication body available.
                </p>
            </div>

            <!-- Tags -->
            <div v-if="article.tags" class="pt-8 border-t border-hairline flex flex-wrap items-center gap-2">
                <span class="font-mono text-xs text-ink-subtle">Keywords:</span>
                <span
                    v-for="(tag, idx) in article.tags.split(',')"
                    :key="idx"
                    class="bg-paper px-3 py-1 rounded-full border border-hairline text-xs font-mono text-ink"
                >
                    {{ tag.trim() }}
                </span>
            </div>

            <!-- Related Articles -->
            <section v-if="relatedArticles && relatedArticles.length > 0" v-reveal class="border-t border-hairline pt-12 mt-16">
                <h3 class="font-serif text-2xl text-ink font-normal mb-6">
                    Related Academic Publications
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        v-for="rel in relatedArticles"
                        :key="rel.id"
                        class="bg-white p-5 rounded-xl border border-hairline flex flex-col justify-between hover:border-ink transition-all"
                    >
                        <div>
                            <span class="font-mono text-[10px] text-terracotta uppercase block mb-1">
                                {{ rel.category }}
                            </span>
                            <h4 class="font-serif text-lg text-ink font-medium leading-snug mb-2">
                                <Link :href="route('publications.show', rel.slug)" class="hover:underline">
                                    {{ rel.title }}
                                </Link>
                            </h4>
                        </div>
                        <Link :href="route('publications.show', rel.slug)" class="font-mono text-xs text-ink hover:text-terracotta font-semibold mt-4">
                            Read Paper →
                        </Link>
                    </div>
                </div>
            </section>
        </article>
    </PublicLayout>
</template>

<style>
/* Rich Content & Text Editor Typography Styles */
.publication-rich-text {
    color: #2b2a27;
    word-break: break-word;
    overflow-wrap: break-word;
}

.publication-rich-text p {
    margin-bottom: 1.5rem;
    line-height: 1.85;
    color: #2b2a27;
}

.publication-rich-text p:last-child {
    margin-bottom: 0;
}

/* Empty paragraphs created by pressing enter in rich text editor */
.publication-rich-text p:empty,
.publication-rich-text p > br:only-child {
    min-height: 1.5rem;
    display: block;
}

/* Text Alignments from Rich Text Editors (Quill, TinyMCE, CKEditor, TipTap, inline) */
.publication-rich-text .text-left,
.publication-rich-text [style*="text-align: left"],
.publication-rich-text [style*="text-align:left"],
.publication-rich-text .ql-align-left {
    text-align: left !important;
}

.publication-rich-text .text-center,
.publication-rich-text [style*="text-align: center"],
.publication-rich-text [style*="text-align:center"],
.publication-rich-text .ql-align-center {
    text-align: center !important;
}

.publication-rich-text .text-right,
.publication-rich-text [style*="text-align: right"],
.publication-rich-text [style*="text-align:right"],
.publication-rich-text .ql-align-right {
    text-align: right !important;
}

.publication-rich-text .text-justify,
.publication-rich-text [style*="text-align: justify"],
.publication-rich-text [style*="text-align:justify"],
.publication-rich-text .ql-align-justify {
    text-align: justify !important;
}

/* Indentations from Rich Text Editors */
.publication-rich-text .ql-indent-1 { padding-left: 2rem; }
.publication-rich-text .ql-indent-2 { padding-left: 4rem; }
.publication-rich-text .ql-indent-3 { padding-left: 6rem; }
.publication-rich-text .ql-indent-4 { padding-left: 8rem; }

.publication-rich-text h1,
.publication-rich-text h2,
.publication-rich-text h3,
.publication-rich-text h4,
.publication-rich-text h5,
.publication-rich-text h6 {
    font-family: Newsreader, "Cormorant Garamond", Georgia, serif;
    font-weight: 500;
    color: #0f0f10;
    margin-top: 2.25rem;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.publication-rich-text h1 {
    font-size: 1.75rem;
}

.publication-rich-text h2 {
    font-size: 1.5rem;
}

.publication-rich-text h3 {
    font-size: 1.3rem;
}

.publication-rich-text h4 {
    font-size: 1.15rem;
}

.publication-rich-text ul {
    list-style-type: disc;
    padding-left: 1.75rem;
    margin-top: 0.75rem;
    margin-bottom: 1.5rem;
}

.publication-rich-text ol {
    list-style-type: decimal;
    padding-left: 1.75rem;
    margin-top: 0.75rem;
    margin-bottom: 1.5rem;
}

.publication-rich-text ul ul,
.publication-rich-text ol ul {
    list-style-type: circle;
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
}

.publication-rich-text ol ol,
.publication-rich-text ul ol {
    list-style-type: lower-alpha;
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
}

.publication-rich-text li {
    margin-bottom: 0.5rem;
    line-height: 1.75;
    color: #2b2a27;
}

.publication-rich-text blockquote {
    border-left: 4px solid #b83220;
    padding: 1rem 1.5rem;
    margin: 1.75rem 0;
    font-style: italic;
    color: #4a4843;
    background-color: #fafaf9;
    border-radius: 0 0.5rem 0.5rem 0;
}

.publication-rich-text blockquote p:last-child {
    margin-bottom: 0;
}

.publication-rich-text a {
    color: #b83220;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.15s ease;
}

.publication-rich-text a:hover {
    color: #992819;
}

.publication-rich-text strong,
.publication-rich-text b {
    font-weight: 600;
    color: #0f0f10;
}

.publication-rich-text em,
.publication-rich-text i {
    font-style: italic;
}

.publication-rich-text u {
    text-decoration: underline;
    text-underline-offset: 2px;
}

.publication-rich-text s,
.publication-rich-text del,
.publication-rich-text strike {
    text-decoration: line-through;
}

.publication-rich-text mark {
    background-color: #fef08a;
    padding: 0.1rem 0.35rem;
    border-radius: 0.2rem;
}

.publication-rich-text sub {
    vertical-align: sub;
    font-size: 0.75em;
}

.publication-rich-text sup {
    vertical-align: super;
    font-size: 0.75em;
}

.publication-rich-text hr {
    border: none;
    border-top: 1px solid #e5e4de;
    margin: 2.25rem 0;
}

.publication-rich-text table {
    width: 100%;
    margin: 1.75rem 0;
    border-collapse: collapse;
    border: 1px solid #e5e4de;
    font-size: 0.875rem;
}

.publication-rich-text th,
.publication-rich-text td {
    padding: 0.75rem 1rem;
    border: 1px solid #e5e4de;
    text-align: left;
}

.publication-rich-text th {
    background-color: #fafaf9;
    font-family: "JetBrains Mono", monospace;
    font-size: 0.75rem;
    text-transform: uppercase;
    font-weight: 600;
}

.publication-rich-text img {
    max-width: 100%;
    height: auto;
    border-radius: 0.75rem;
    margin: 1.75rem 0;
    border: 1px solid #e5e4de;
}

.publication-rich-text iframe,
.publication-rich-text video {
    max-width: 100%;
    border-radius: 0.75rem;
    margin: 1.75rem 0;
}

.publication-rich-text code {
    font-family: "JetBrains Mono", monospace;
    font-size: 0.85em;
    background: #fafaf9;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    border: 1px solid #e5e4de;
}

.publication-rich-text pre {
    background: #fafaf9;
    padding: 1.25rem;
    border-radius: 0.5rem;
    border: 1px solid #e5e4de;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.publication-rich-text pre code {
    background: transparent;
    padding: 0;
    border: none;
}
</style>
