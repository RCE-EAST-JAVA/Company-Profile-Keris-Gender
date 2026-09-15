<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { stripHtml } from '@/Utils/text';

const props = defineProps({
    people: Object,
    allPeople: {
        type: Array,
        default: () => [],
    },
    currentCategory: {
        type: String,
        default: 'all',
    },
    categoryCounts: {
        type: Object,
        default: () => ({ all: 0, Researcher: 0, 'Research Assistant': 0 }),
    },
});

const activeCategory = ref(props.currentCategory || 'all');

const displayPeople = computed(() => {
    if (props.allPeople && props.allPeople.length > 0) {
        if (activeCategory.value === 'all') {
            return props.allPeople;
        }
        return props.allPeople.filter(item => item.category === activeCategory.value);
    }
    return props.people?.data || [];
});

const filterByCategory = (category) => {
    activeCategory.value = category;
    try {
        const url = new URL(window.location.href);
        if (category === 'all') {
            url.searchParams.delete('category');
        } else {
            url.searchParams.set('category', category);
        }
        window.history.replaceState(window.history.state, '', url.toString());
    } catch (e) {
        // fallback
    }
};
</script>

<template>
    <PublicLayout>
        <Head title="People in GInRe — Center for Gender and International Relations Studies" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 sm:pt-16 pb-24">
            <!-- 1. Eyebrow & Title Section -->
            <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-4 animate-fade-in-up animation-delay-75">
                
                <span>PEOPLE IN GINRE · ACADEMIC & RESEARCH COMMUNITY</span>
            </div>

            <div class="max-w-4xl space-y-4 mb-8">
                <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-ink font-normal tracking-tight leading-[1.15] animate-fade-in-up animation-delay-150">
                    People in GInRe
                </h1>
                <p class="text-sm sm:text-base text-ink-muted leading-relaxed max-w-2xl animate-fade-in-up animation-delay-200">
                    Center for Gender and International Relations Studies (GInRe) brings together dedicated researchers, scholars, and assistants committed to gender justice, social policy, and international affairs.
                </p>
            </div>

            <!-- 2. Category Filter Tabs -->
            <div class="flex flex-wrap items-center gap-2 pb-8 border-b border-hairline/80 mb-10 animate-fade-in-up animation-delay-250">
                <button
                    @click="filterByCategory('all')"
                    :class="[
                        'text-xs font-mono px-5 py-2 rounded-full transition-all duration-150 flex items-center gap-2',
                        activeCategory === 'all'
                            ? 'bg-ink text-white font-medium shadow-sm'
                            : 'bg-white hover:bg-paper text-ink-muted hover:text-ink border border-hairline'
                    ]"
                >
                    <span>All People</span>
                    <span v-if="categoryCounts.all" class="text-[10px] opacity-75">({{ categoryCounts.all }})</span>
                </button>
                <button
                    @click="filterByCategory('Researcher')"
                    :class="[
                        'text-xs font-mono px-5 py-2 rounded-full transition-all duration-150 flex items-center gap-2',
                        activeCategory === 'Researcher'
                            ? 'bg-ink text-white font-medium shadow-sm'
                            : 'bg-white hover:bg-paper text-ink-muted hover:text-ink border border-hairline'
                    ]"
                >
                    <span>Researchers</span>
                    <span v-if="categoryCounts.Researcher" class="text-[10px] opacity-75">({{ categoryCounts.Researcher }})</span>
                </button>
                <button
                    @click="filterByCategory('Research Assistant')"
                    :class="[
                        'text-xs font-mono px-5 py-2 rounded-full transition-all duration-150 flex items-center gap-2',
                        activeCategory === 'Research Assistant'
                            ? 'bg-ink text-white font-medium shadow-sm'
                            : 'bg-white hover:bg-paper text-ink-muted hover:text-ink border border-hairline'
                    ]"
                >
                    <span>Research Assistants</span>
                    <span v-if="categoryCounts['Research Assistant']" class="text-[10px] opacity-75">({{ categoryCounts['Research Assistant'] }})</span>
                </button>
            </div>

            <!-- 3. Section Header (Improved from 01 / DIRECTORATE) -->
            <div v-reveal class="flex items-center justify-between mb-8 pb-3 border-b border-hairline">
                <div class="flex items-center gap-3">
                    <h2 class="font-serif text-2xl text-ink font-normal">
                        People in GInRe
                    </h2>
                </div>
                <span class="font-mono text-xs text-ink-subtle uppercase hidden sm:inline-block">
                    RESEARCHERS & RESEARCH ASSISTANTS
                </span>
            </div>

            <!-- 4. Staff Cards Grid (Cleaned up from database, no fake metadata, NO grayscale) -->
            <div v-if="displayPeople && displayPeople.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                <div
                    v-for="(staff, sIdx) in displayPeople"
                    :key="staff.id"
                    v-reveal="{ delay: (sIdx % 3) * 100, direction: 'up' }"
                    class="bg-white rounded-2xl border border-hairline p-5 flex flex-col justify-between hover:border-ink/40 shadow-sm hover:shadow-md transition-all duration-200 group"
                >
                    <div>
                        <!-- Photo Container without grayscale -->
                        <div class="relative aspect-[4/3] rounded-xl overflow-hidden bg-neutral-100 mb-5">
                            <img
                                :src="staff.image || 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop'"
                                :alt="staff.name"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            />

                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3 bg-black/65 backdrop-blur-md px-2.5 py-1 rounded-full text-[10px] font-mono text-white border border-white/20">
                                {{ staff.category }}
                            </div>
                        </div>

                        <!-- Category Eyebrow -->
                        <div class="text-[11px] font-mono text-terracotta font-semibold uppercase mb-1.5">
                            {{ staff.category }}
                        </div>

                        <!-- Name -->
                        <h3 class="font-serif text-xl text-ink font-normal leading-snug mb-1 group-hover:text-terracotta transition-colors">
                            <Link :href="route('people.show', staff.slug || staff.id)">
                                {{ staff.name }}
                            </Link>
                        </h3>

                        <!-- Role -->
                        <div class="text-xs text-ink-muted font-medium mb-3">
                            {{ staff.role }}
                        </div>

                        <!-- Description Bio (Concise from DB) -->
                        <p v-if="staff.description" class="text-xs text-ink-muted leading-relaxed line-clamp-3 mb-4">
                            {{ stripHtml(staff.description) }}
                        </p>

                        <!-- Expertise Pills (from DB) -->
                        <div v-if="staff.expertise" class="flex flex-wrap gap-1.5 mb-4">
                            <span
                                v-for="(tag, idx) in staff.expertise.split(',').slice(0, 3)"
                                :key="idx"
                                class="bg-paper px-2 py-0.5 rounded text-[10px] font-mono text-ink-muted border border-hairline"
                            >
                                {{ tag.trim() }}
                            </span>
                        </div>
                    </div>

                    <!-- Footer Action Row -->
                    <div class="pt-4 border-t border-hairline flex items-center justify-end text-xs font-mono mt-2">
                        <Link
                            :href="route('people.show', staff.slug || staff.id)"
                            class="text-ink hover:text-terracotta font-semibold flex items-center gap-1 transition-colors shrink-0"
                        >
                            <span>View Profile →</span>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="bg-white rounded-2xl border border-hairline p-12 text-center my-8">
                <p class="text-sm font-mono text-ink-muted">No scholars found in this category.</p>
                <button
                    @click="filterByCategory('all')"
                    class="mt-4 text-xs font-mono text-terracotta hover:underline font-semibold"
                >
                    View all people
                </button>
            </div>

            <!-- 5. Pagination (8 items per page) -->
            <div v-if="people.links && people.links.length > 3" class="mt-14 pt-8 border-t border-hairline flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs font-mono text-ink-subtle">
                    Showing <span class="text-ink font-semibold">{{ people.from || 0 }}</span> to <span class="text-ink font-semibold">{{ people.to || 0 }}</span> of <span class="text-ink font-semibold">{{ people.total || 0 }}</span> people
                </div>

                <div class="flex items-center gap-1.5 flex-wrap">
                    <template v-for="(link, index) in people.links" :key="index">
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            :class="[
                                'px-3.5 py-1.5 rounded-lg text-xs font-mono transition-colors',
                                link.active
                                    ? 'bg-ink text-white font-semibold'
                                    : 'bg-white hover:bg-paper text-ink border border-hairline hover:border-ink/40'
                            ]"
                            v-html="link.label"
                            preserve-scroll
                            preserve-state
                        />
                        <span
                            v-else
                            class="px-3 py-1.5 text-xs font-mono text-ink-subtle opacity-50 cursor-not-allowed"
                            v-html="link.label"
                        />
                    </template>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
