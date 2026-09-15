<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Instagram, Mail } from 'lucide-vue-next';

const props = defineProps({
    transparentHeader: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();
const isMobileMenuOpen = ref(false);
const isScrolled = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 40;
};

onMounted(() => {
    handleScroll();
    window.addEventListener('scroll', handleScroll, { passive: true });
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

const currentPath = computed(() => {
    return page.url;
});

const isCurrent = (path) => {
    if (path === '/') {
        return currentPath.value === '/' || currentPath.value === '';
    }
    return currentPath.value.startsWith(path);
};

const isTransparent = computed(() => {
    return props.transparentHeader && !isScrolled.value;
});
</script>

<template>
    <div class="min-h-screen bg-paper text-ink selection:bg-terracotta selection:text-white flex flex-col font-sans antialiased">
        <!-- Top Sticky / Transparent Header -->
        <header
            :class="[
                'z-50 transition-all duration-300',
                props.transparentHeader ? 'fixed top-0 left-0 right-0' : 'sticky top-0',
                isTransparent
                    ? 'bg-transparent border-b border-transparent shadow-none'
                    : 'bg-paper/95 backdrop-blur-md border-b border-hairline/80 shadow-xs'
            ]"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">
                <!-- Brand / Logo -->
                <Link :href="route('home')" class="flex flex-col justify-center group py-1 shrink-0 transition-opacity hover:opacity-90">
                    <span
                        :class="[
                            'font-sans font-black text-2xl sm:text-[28px] tracking-tight leading-none transition-colors',
                            isTransparent ? 'text-[#ff512f]' : 'text-[#e03a18]'
                        ]"
                    >
                        GinRe
                    </span>
                    <span
                        :class="[
                            'font-sans font-bold text-[8.5px] sm:text-[10px] tracking-wider uppercase leading-none mt-1 transition-colors',
                            isTransparent ? 'text-white/90' : 'text-[#141414]'
                        ]"
                    >
                        Center for Gender and International Relations Studies
                    </span>
                </Link>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8">
                    <Link
                        :href="route('home')"
                        :class="[
                            'text-xs font-mono tracking-widest uppercase transition-colors py-1 relative',
                            isTransparent
                                ? (isCurrent('/') && currentPath === '/'
                                    ? 'text-white font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-white'
                                    : 'text-white/80 hover:text-white')
                                : (isCurrent('/') && currentPath === '/'
                                    ? 'text-ink font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-ink'
                                    : 'text-ink-muted hover:text-ink')
                        ]"
                    >
                        HOME
                    </Link>
                    <Link
                        :href="route('programs.index')"
                        :class="[
                            'text-xs font-mono tracking-widest uppercase transition-colors py-1 relative',
                            isTransparent
                                ? (isCurrent('/programs')
                                    ? 'text-white font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-white'
                                    : 'text-white/80 hover:text-white')
                                : (isCurrent('/programs')
                                    ? 'text-ink font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-ink'
                                    : 'text-ink-muted hover:text-ink')
                        ]"
                    >
                        PROGRAMS
                    </Link>
                    <Link
                        :href="route('publications.index')"
                        :class="[
                            'text-xs font-mono tracking-widest uppercase transition-colors py-1 relative',
                            isTransparent
                                ? (isCurrent('/publications')
                                    ? 'text-white font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-white'
                                    : 'text-white/80 hover:text-white')
                                : (isCurrent('/publications')
                                    ? 'text-ink font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-ink'
                                    : 'text-ink-muted hover:text-ink')
                        ]"
                    >
                        PUBLICATIONS
                    </Link>
                    <Link
                        :href="route('people.index')"
                        :class="[
                            'text-xs font-mono tracking-widest uppercase transition-colors py-1 relative',
                            isTransparent
                                ? (isCurrent('/people')
                                    ? 'text-white font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-white'
                                    : 'text-white/80 hover:text-white')
                                : (isCurrent('/people')
                                    ? 'text-ink font-semibold after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-[2px] after:bg-ink'
                                    : 'text-ink-muted hover:text-ink')
                        ]"
                    >
                        PEOPLE
                    </Link>
                </nav>

                <!-- Mobile Hamburger Menu Button -->
                <button
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                    type="button"
                    aria-label="Toggle Navigation Menu"
                    :class="[
                        'md:hidden flex items-center justify-center w-10 h-10 rounded-lg transition-colors focus:outline-none',
                        isTransparent
                            ? 'text-white hover:bg-white/10'
                            : 'text-black hover:bg-black/5'
                    ]"
                >
                    <svg v-if="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Nav Dropdown Menu -->
            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0 -translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-2"
            >
                <div
                    v-if="isMobileMenuOpen"
                    class="md:hidden border-t border-hairline bg-paper/98 backdrop-blur-lg px-4 py-4 space-y-1 shadow-lg"
                >
                    <Link
                        :href="route('home')"
                        @click="isMobileMenuOpen = false"
                        :class="[
                            'flex items-center justify-between px-4 py-3 rounded-xl text-xs font-mono tracking-widest uppercase transition-colors',
                            isCurrent('/') && currentPath === '/'
                                ? 'bg-ink text-white font-bold'
                                : 'text-ink hover:bg-black/5'
                        ]"
                    >
                        <span>HOME</span>
                        <span v-if="isCurrent('/') && currentPath === '/'" class="text-terracotta text-sm">●</span>
                    </Link>
                    <Link
                        :href="route('programs.index')"
                        @click="isMobileMenuOpen = false"
                        :class="[
                            'flex items-center justify-between px-4 py-3 rounded-xl text-xs font-mono tracking-widest uppercase transition-colors',
                            isCurrent('/programs')
                                ? 'bg-ink text-white font-bold'
                                : 'text-ink hover:bg-black/5'
                        ]"
                    >
                        <span>PROGRAMS</span>
                        <span v-if="isCurrent('/programs')" class="text-terracotta text-sm">●</span>
                    </Link>
                    <Link
                        :href="route('publications.index')"
                        @click="isMobileMenuOpen = false"
                        :class="[
                            'flex items-center justify-between px-4 py-3 rounded-xl text-xs font-mono tracking-widest uppercase transition-colors',
                            isCurrent('/publications')
                                ? 'bg-ink text-white font-bold'
                                : 'text-ink hover:bg-black/5'
                        ]"
                    >
                        <span>PUBLICATIONS</span>
                        <span v-if="isCurrent('/publications')" class="text-terracotta text-sm">●</span>
                    </Link>
                    <Link
                        :href="route('people.index')"
                        @click="isMobileMenuOpen = false"
                        :class="[
                            'flex items-center justify-between px-4 py-3 rounded-xl text-xs font-mono tracking-widest uppercase transition-colors',
                            isCurrent('/people')
                                ? 'bg-ink text-white font-bold'
                                : 'text-ink hover:bg-black/5'
                        ]"
                    >
                        <span>PEOPLE</span>
                        <span v-if="isCurrent('/people')" class="text-terracotta text-sm">●</span>
                    </Link>
                </div>
            </transition>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow">
            <slot />
        </main>

        <!-- Global Editorial Footer -->
        <footer class="bg-[#f2f1ec] border-t border-hairline text-ink pt-16 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 pb-16 border-b border-hairline">
                    <!-- Column 1: Organization Bio -->
                    <div class="lg:col-span-4 space-y-4">
                        <div class="flex flex-col">
                            <span class="font-sans font-black text-2xl sm:text-[28px] text-[#e03a18] tracking-tight leading-none">
                                GinRe
                            </span>
                            <span class="font-sans font-bold text-[8.5px] sm:text-[10px] text-[#141414] tracking-wider uppercase leading-none mt-1">
                                Center for Gender and International Relations Studies
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-ink-muted leading-relaxed max-w-sm">
                            An independent research collective dedicated to deconstructing socio-cultural discourses, structural inequality, and advancing evidence-based gender justice across Southeast Asia.
                        </p>
                        <div class="pt-2 flex items-center gap-2 text-[11px] font-mono text-terracotta font-medium tracking-wide">
                            <span>ACTIVE RESEARCH DIRECTORATE · EAST JAVA</span>
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

                    <!-- Column 4: Contact Information -->
                    <div class="lg:col-span-3 space-y-4">
                        <h4 class="font-mono text-xs font-semibold uppercase tracking-wider text-ink">
                            Contact & Inquiries
                        </h4>
                        <div class="space-y-2.5 text-xs sm:text-sm text-ink-muted leading-relaxed">
                            <p class="flex items-start gap-2">
                                <span>GInRe Directorate Office, East Java, Indonesia</span>
                            </p>
                            
                            <div class="flex items-center gap-2">
                                <Mail class="w-4 h-4 text-terracotta shrink-0" />
                                <a href="mailto:admin@kerisgender.ac.id" class="text-ink hover:text-terracotta font-medium transition-colors hover:underline">
                                    admin@kerisgender.ac.id
                                </a>
                            </div>
                            <div class="flex items-center gap-2">
                                <Instagram class="w-4 h-4 text-terracotta shrink-0" />
                                <a href="" class="text-ink hover:text-terracotta font-medium transition-colors hover:underline">
                                    gintre.unej
                                </a>
                            </div>
                            <!-- <div class="pt-1 text-[11px] font-mono text-ink-subtle">
                                Office: Mon – Fri, 09:00 – 17:00 WIB
                            </div> -->
                        </div>
                    </div>
                </div>

                <!-- Bottom Copyright & Legal links -->
                <div class="pt-8 flex flex-col sm:flex-row items-center justify-center gap-4 text-xs font-mono text-ink-muted">
                    <div>
                        © 2025 Center for Gender and International Relations Studies (GInRe). All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
