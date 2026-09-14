<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    article: Object,
    authorStaff: Object,
    relatedArticles: Array,
});

const activeCitationTab = ref('APA');
const copied = ref(false);

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
</script>

<template>
    <PublicLayout>
        <Head :title="`${article.title} — Center for Gender and International Relations Studies (GInRe) Research Archive`" />

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
            <header class="space-y-4 mb-10 pb-8 border-b border-hairline">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="bg-terracotta/10 text-terracotta font-mono text-xs uppercase px-3 py-1 rounded-full font-semibold">
                        ● {{ article.category }}
                    </span>
                    <span class="bg-paper text-ink-muted font-mono text-xs px-3 py-1 rounded-full border border-hairline">
                        ★ Peer-Reviewed Standard
                    </span>
                    <span class="font-mono text-xs text-ink-subtle ml-auto">
                        Published: {{ new Date(article.published_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) }}
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
                                class="w-full h-full object-cover grayscale"
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
                                {{ authorStaff?.role || 'Principal Investigator · Center for Gender and International Relations Studies (GInRe)' }}
                            </div>
                        </div>
                    </div>

                    <div class="ml-auto flex items-center gap-2 font-mono text-xs text-ink-subtle">
                        <span>DOI:</span>
                        <a href="#" class="text-terracotta hover:underline font-medium">
                            10.22146/ginre.{{ new Date(article.published_at).getFullYear() }}.{{ article.id.toString().padStart(4, '0') }}
                        </a>
                    </div>
                </div>
            </header>

            <!-- Abstract / Excerpt Block -->
            <div class="bg-paper p-6 sm:p-8 rounded-2xl border border-hairline mb-10">
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

            <!-- Research Paper Body Content -->
            <div class="prose max-w-none text-ink text-sm sm:text-base leading-relaxed space-y-6 font-sans">
                <div class="whitespace-pre-line leading-relaxed">
                    {{ article.body }}
                </div>
            </div>

            <!-- Tags -->
            <div v-if="article.tags" class="pt-10 mt-12 border-t border-hairline flex flex-wrap items-center gap-2">
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
