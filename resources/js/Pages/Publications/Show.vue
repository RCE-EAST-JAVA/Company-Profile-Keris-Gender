<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    article: Object,
    authorStaff: Object,
    relatedArticles: Array,
});

const activeCitationTab = ref('APA');
const copied = ref(false);

const formattedContent = computed(() => {
    const raw = props.article?.body || '';
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

const getCitationText = () => {
    const year = new Date(props.article.published_at).getFullYear();
    if (activeCitationTab.value === 'APA') {
        return `${props.article.author} (${year}). ${props.article.title}. Center for Gender and International Relations Studies (GInRe) Policy Repository. https://doi.org/10.22146/ginre.${year}.${props.article.id.toString().padStart(4, '0')}`;
    } else if (activeCitationTab.value === 'BibTeX') {
        return `@article{ginre_${props.article.id},\n  title={${props.article.title}},\n  author={${props.article.author}},\n  year={${year}},\n  publisher={Center for Gender and International Relations Studies (GInRe)},\n  doi={10.22146/ginre.${year}.${props.article.id.toString().padStart(4, '0')}}\n}`;
    } else {
        return `${props.article.author}. "${props.article.title}." Center for Gender and International Relations Studies (GInRe) Policy Repository (${year}).`;
    }
};

const copyCitation = () => {
    navigator.clipboard.writeText(getCitationText());
    copied.value = true;
    setTimeout(() => {
        copied.value = false;
    }, 2000);
};

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
            <div class="flex items-center gap-2 text-xs font-mono text-ink-muted mb-8">
                <Link :href="route('publications.index')" class="hover:text-ink transition-colors">
                    ← Back to All Publications
                </Link>
                <span>/</span>
                <span class="text-ink truncate max-w-xs">{{ article.title }}</span>
            </div>

            <!-- Header -->
            <header class="space-y-4 mb-8 pb-8 border-b border-hairline">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="bg-terracotta/10 text-terracotta font-mono text-xs uppercase px-3 py-1 rounded-full font-semibold">
                        ● {{ article.category }}
                    </span>
                    <span class="bg-paper text-ink-muted font-mono text-xs px-3 py-1 rounded-full border border-hairline">
                        ★ Peer-Reviewed Standard
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

                    <div v-if="article.id" class="ml-auto flex items-center gap-2 font-mono text-xs text-ink-subtle">
                        <span>DOI:</span>
                        <span class="text-terracotta font-medium">
                            10.22146/ginre.{{ new Date(article.published_at || Date.now()).getFullYear() }}.{{ article.id.toString().padStart(4, '0') }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- Featured Photo (ONLY DISPLAYED IF THUMBNAIL EXISTS, NO PLACEHOLDER IF NULL) -->
            <div
                v-if="article.thumbnail"
                class="aspect-[16/9] sm:aspect-[21/9] max-h-[460px] rounded-2xl overflow-hidden border border-hairline shadow-sm mb-10 bg-neutral-100"
            >
                <img
                    :src="article.thumbnail"
                    :alt="article.title"
                    class="w-full h-full object-cover"
                />
            </div>

            <!-- Abstract / Excerpt Block -->
            <div v-if="article.excerpt" class="bg-paper p-6 sm:p-8 rounded-2xl border border-hairline mb-10">
                <span class="font-mono text-xs text-terracotta uppercase tracking-wider block mb-2 font-semibold">
                    ABSTRACT / RINGKASAN EKSEKUTIF
                </span>
                <p class="font-serif text-lg sm:text-xl text-ink font-light leading-relaxed">
                    {{ article.excerpt }}
                </p>
            </div>

            <!-- Citation Generator & Download Actions -->
            <div class="bg-white p-6 rounded-2xl border border-hairline shadow-sm mb-12 space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 font-mono text-xs">
                        <span class="text-ink font-semibold">Cite this Research:</span>
                        <button
                            v-for="tab in ['APA', 'BibTeX', 'Chicago']"
                            :key="tab"
                            @click="activeCitationTab = tab"
                            :class="[
                                'px-2.5 py-1 rounded transition-colors',
                                activeCitationTab === tab ? 'bg-ink text-white font-medium' : 'bg-paper text-ink-muted hover:text-ink'
                            ]"
                        >
                            {{ tab }}
                        </button>
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            @click="copyCitation"
                            class="text-xs font-mono text-terracotta hover:text-terracotta-dark font-medium flex items-center gap-1 transition-colors"
                        >
                            <span>{{ copied ? '✓ Copied to Clipboard' : 'Copy Citation' }}</span>
                        </button>
                        <a
                            href="#"
                            class="bg-ink hover:bg-black text-white text-xs font-medium px-4 py-2 rounded-full transition-colors flex items-center gap-1.5 shadow-sm"
                        >
                            <span>Download PDF</span>
                            <span>⭳</span>
                        </a>
                    </div>
                </div>

                <!-- Citation Box -->
                <pre class="bg-paper p-4 rounded-xl border border-hairline font-mono text-xs text-ink-muted whitespace-pre-wrap leading-relaxed overflow-x-auto">{{ getCitationText() }}</pre>
            </div>

            <!-- Research Paper Body Content with Rich Text Editor Typography -->
            <div class="space-y-4 mb-12">
                <h2 class="font-serif text-2xl text-ink font-normal mb-4">
                    Full Description & Content
                </h2>
                <div
                    v-if="article.body"
                    class="publication-rich-text text-sm sm:text-base leading-relaxed font-sans"
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
            <section v-if="relatedArticles && relatedArticles.length > 0" class="border-t border-hairline pt-12 mt-16">
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
}

.publication-rich-text p {
    margin-bottom: 1.25rem;
    line-height: 1.8;
}

.publication-rich-text p:last-child {
    margin-bottom: 0;
}

.publication-rich-text h1,
.publication-rich-text h2,
.publication-rich-text h3,
.publication-rich-text h4,
.publication-rich-text h5,
.publication-rich-text h6 {
    font-family: Newsreader, "Cormorant Garamond", Georgia, serif;
    font-weight: 500;
    color: #0f0f10;
    margin-top: 2rem;
    margin-bottom: 0.85rem;
    line-height: 1.3;
}

.publication-rich-text h1 {
    font-size: 1.6rem;
}

.publication-rich-text h2 {
    font-size: 1.4rem;
}

.publication-rich-text h3 {
    font-size: 1.25rem;
}

.publication-rich-text h4 {
    font-size: 1.1rem;
}

.publication-rich-text ul {
    list-style-type: disc;
    padding-left: 1.5rem;
    margin-top: 0.75rem;
    margin-bottom: 1.25rem;
}

.publication-rich-text ol {
    list-style-type: decimal;
    padding-left: 1.5rem;
    margin-top: 0.75rem;
    margin-bottom: 1.25rem;
}

.publication-rich-text li {
    margin-bottom: 0.5rem;
    line-height: 1.7;
    color: #2b2a27;
}

.publication-rich-text blockquote {
    border-left: 3px solid #b83220;
    padding: 0.85rem 1.25rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #4a4843;
    background-color: #fafaf9;
    border-radius: 0 0.5rem 0.5rem 0;
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

.publication-rich-text hr {
    border: none;
    border-top: 1px solid #e5e4de;
    margin: 2rem 0;
}

.publication-rich-text table {
    width: 100%;
    margin: 1.5rem 0;
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
    margin: 1.5rem 0;
    border: 1px solid #e5e4de;
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
    padding: 1rem;
    border-radius: 0.5rem;
    border: 1px solid #e5e4de;
    overflow-x: auto;
    margin: 1.25rem 0;
}

.publication-rich-text pre code {
    background: transparent;
    padding: 0;
    border: none;
}
</style>
