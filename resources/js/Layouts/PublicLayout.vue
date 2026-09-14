<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();

const currentPath = computed(() => {
    return page.url;
});

const isCurrent = (path) => {
    if (path === '/') {
        return currentPath.value === '/' || currentPath.value === '';
    }
    return currentPath.value.startsWith(path);
};
</script>

<template>
    <div class="min-h-screen bg-paper text-ink selection:bg-terracotta selection:text-white flex flex-col font-sans antialiased">
        <!-- Top Sticky Header -->
        <header class="sticky top-0 z-50 bg-paper/90 backdrop-blur-md border-b border-hairline/70 transition-all">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">
                <!-- Brand / Logo -->
                <Link :href="route('home')" class="flex items-center gap-2.5 group max-w-[360px] sm:max-w-lg lg:max-w-xl shrink-0">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-terracotta transition-transform group-hover:scale-125 shrink-0"></span>
                    <span class="font-mono text-xs sm:text-[13px] font-semibold tracking-wider uppercase text-ink leading-snug">
                        CENTER FOR GENDER AND INTERNATIONAL RELATIONS STUDIES (GInRe)
                    </span>
                </Link>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8">
                    <Link
                        :href="route('home')"
                        :class="[
                            'text-xs font-mono tracking-widest uppercase transition-colors py-1 relative',
                            isCurrent('/') && currentPath === '/'
                                ? 'text-ink font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-ink'
                                : 'text-ink-muted hover:text-ink'
                        ]"
                    >
                        HOME
                    </Link>
                    <Link
                        :href="route('programs.index')"
                        :class="[
                            'text-xs font-mono tracking-widest uppercase transition-colors py-1 relative',
                            isCurrent('/programs')
                                ? 'text-ink font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-ink'
                                : 'text-ink-muted hover:text-ink'
                        ]"
                    >
                        PROGRAMS
                    </Link>
                    <Link
                        :href="route('publications.index')"
                        :class="[
                            'text-xs font-mono tracking-widest uppercase transition-colors py-1 relative',
                            isCurrent('/publications')
                                ? 'text-ink font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-ink'
                                : 'text-ink-muted hover:text-ink'
                        ]"
                    >
                        PUBLICATIONS
                    </Link>
                    <Link
                        :href="route('people.index')"
                        :class="[
                            'text-xs font-mono tracking-widest uppercase transition-colors py-1 relative',
                            isCurrent('/people')
                                ? 'text-ink font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-ink'
                                : 'text-ink-muted hover:text-ink'
                        ]"
                    >
                        PEOPLE
                    </Link>
                </nav>
            </div>

            <!-- Mobile Nav Bar -->
            <div class="md:hidden border-t border-hairline/60 px-4 py-2 flex items-center justify-around bg-paper">
                <Link :href="route('home')" :class="['text-[11px] font-mono uppercase tracking-wider py-1', isCurrent('/') && currentPath === '/' ? 'font-bold text-ink' : 'text-ink-muted']">Home</Link>
                <Link :href="route('programs.index')" :class="['text-[11px] font-mono uppercase tracking-wider py-1', isCurrent('/programs') ? 'font-bold text-ink' : 'text-ink-muted']">Programs</Link>
                <Link :href="route('publications.index')" :class="['text-[11px] font-mono uppercase tracking-wider py-1', isCurrent('/publications') ? 'font-bold text-ink' : 'text-ink-muted']">Publications</Link>
                <Link :href="route('people.index')" :class="['text-[11px] font-mono uppercase tracking-wider py-1', isCurrent('/people') ? 'font-bold text-ink' : 'text-ink-muted']">People</Link>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow">
            <slot />
        </main>

        <!-- Global Editorial Footer -->
        <footer class="bg-[#f2f1ec] border-t border-hairline text-ink pt-16 pb-12 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 pb-16 border-b border-hairline">
                    <!-- Column 1: Organization Bio -->
                    <div class="lg:col-span-4 space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-2 h-2 rounded-full bg-terracotta"></span>
                            <span class="font-mono text-xs font-bold tracking-wider uppercase text-ink">
                                CENTER FOR GENDER AND INTERNATIONAL RELATIONS STUDIES (GInRe)
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-ink-muted leading-relaxed max-w-sm">
                            An independent research collective dedicated to deconstructing socio-cultural discourses, structural inequality, and advancing evidence-based gender justice across Southeast Asia.
                        </p>
                        <div class="pt-2 flex items-center gap-2 text-[11px] font-mono text-terracotta font-medium tracking-wide">
                            <span>●</span>
                            <span>ACTIVE RESEARCH DIRECTORATE · SOUTHEAST ASIA</span>
                        </div>
                    </div>

                    <!-- Column 2: Quick Navigation -->
                    <div class="lg:col-span-2 space-y-4">
                        <h4 class="font-mono text-xs font-semibold uppercase tracking-wider text-ink">
                            Quick Navigation
                        </h4>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-ink-muted">
                            <li><Link :href="route('home')" class="hover:text-ink transition-colors">Home</Link></li>
                            <li><Link :href="route('programs.index')" class="hover:text-ink transition-colors">Programs</Link></li>
                            <li><Link :href="route('publications.index')" class="hover:text-ink transition-colors">Publications</Link></li>
                            <li><Link :href="route('people.index')" class="hover:text-ink transition-colors">People & Team</Link></li>
                        </ul>
                    </div>

                    <!-- Column 3: Research Areas -->
                    <div class="lg:col-span-3 space-y-4">
                        <h4 class="font-mono text-xs font-semibold uppercase tracking-wider text-ink">
                            Research Areas
                        </h4>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-ink-muted">
                            <li><Link :href="route('publications.index', { search: 'Public Policy' })" class="hover:text-ink transition-colors">Public Policy & Legal Reform</Link></li>
                            <li><Link :href="route('publications.index', { search: 'Climate Justice' })" class="hover:text-ink transition-colors">Climate Justice & Labor</Link></li>
                            <li><Link :href="route('publications.index', { search: 'Discourse' })" class="hover:text-ink transition-colors">Cultural & Discourse Analysis</Link></li>
                            <li><Link :href="route('publications.index', { search: 'Human Rights' })" class="hover:text-ink transition-colors">Human Rights & Critical Inclusion</Link></li>
                        </ul>
                    </div>

                    <!-- Column 4: Academic Newsletter -->
                    <div class="lg:col-span-3 space-y-4">
                        <h4 class="font-mono text-xs font-semibold uppercase tracking-wider text-ink">
                            Academic Newsletter
                        </h4>
                        <p class="text-xs sm:text-sm text-ink-muted leading-relaxed">
                            Receive curated policy briefs and monthly academic monographs.
                        </p>
                        <form @submit.prevent class="flex items-center gap-2 pt-1">
                            <input
                                type="email"
                                placeholder="Institutional email"
                                class="w-full text-xs px-3.5 py-2.5 rounded-full border border-hairline bg-white text-ink placeholder-ink-subtle focus:outline-none focus:border-ink transition-colors"
                            />
                            <button
                                type="button"
                                class="bg-ink hover:bg-black text-white text-xs font-medium px-4 py-2.5 rounded-full transition-colors whitespace-nowrap"
                            >
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Bottom Copyright & Legal links -->
                <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-mono text-ink-muted">
                    <div>
                        © 2025 Center for Gender and International Relations Studies (GInRe). All rights reserved.
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="#" class="hover:text-ink transition-colors">Research Ethics</a>
                        <a href="#" class="hover:text-ink transition-colors">Participant Privacy</a>
                        <a href="#" class="hover:text-ink transition-colors">Open Repository</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
