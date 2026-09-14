<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    principalInvestigators: Array,
    researchAssistants: Array,
    allStaff: Array,
});

const activeTab = ref('all');

const displayedStaff = computed(() => {
    if (activeTab.value === 'Researchers') {
        return props.principalInvestigators || [];
    }
    if (activeTab.value === 'Research Assistants') {
        return props.researchAssistants || [];
    }
    return props.allStaff || [];
});

const getStaffMeta = (staff) => {
    if (staff.name.includes('Amanda Dewi')) {
        return {
            badge: '● PI · THEORY',
            id: 'KG-2021-01',
            hIndex: 'Scopus h-index: 18',
            roleCategory: 'DIRECTOR OF RESEARCH',
            linkText: 'ORCID Dossier →',
            monographsCount: '42 Monographs & Papers',
        };
    }
    if (staff.name.includes('Hendra Wibowo')) {
        return {
            badge: '● PI · HUMAN RIGHTS',
            id: 'KG-2021-02',
            hIndex: 'Scopus h-index: 14',
            roleCategory: 'DIVISION HEAD',
            linkText: 'Jurisprudence Index →',
            monographsCount: '29 Policy Briefs',
        };
    }
    if (staff.name.includes('Kartika Rahayu')) {
        return {
            badge: '● PI · ECOLOGY',
            id: 'KG-2022-05',
            hIndex: 'Scopus h-index: 12',
            roleCategory: 'SENIOR FELLOW',
            linkText: 'Ecology Corpus →',
            monographsCount: '21 Scientific Publications',
        };
    }
    return {
        badge: '● RESEARCH SCHOLAR',
        id: `KG-2024-0${staff.id}`,
        hIndex: 'Fellow Scholar',
        roleCategory: staff.category.toUpperCase(),
        linkText: 'Scholar Profile →',
        monographsCount: 'Field Contributor',
    };
};
</script>

<template>
    <PublicLayout>
        <Head title="Collective of Academics, Researchers, and Advocacy Fellows — Center for Gender and International Relations Studies (GInRe)" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 sm:pt-16 pb-24">
            <!-- 1. Eyebrow & Title Section -->
            <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-4">
                <span>●</span>
                <span>RESEARCH BOARD & SCHOLARS · ACADEMIC YEAR 2026</span>
            </div>

            <div class="max-w-4xl space-y-4 mb-8">
                <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-ink font-normal tracking-tight leading-[1.15]">
                    Collective of Academics,<br />
                    Researchers, and Advocacy<br />
                    Fellows
                </h1>
                <p class="text-sm sm:text-base text-ink-muted leading-relaxed max-w-2xl">
                    Center for Gender and International Relations Studies (GInRe) operates at the intersection of constitutional law, structural sociology, feminist international relations, political ecology, and economics. We combine empirical rigor with ethical commitment to systemic justice.
                </p>
            </div>

            <!-- 2. Filter Tabs (Matches Screenshot 1) -->
            <div class="flex flex-wrap items-center gap-2 pb-8 border-b border-hairline/80 mb-12">
                <button
                    @click="activeTab = 'all'"
                    :class="[
                        'text-xs font-mono px-5 py-2 rounded-full transition-all duration-150',
                        activeTab === 'all'
                            ? 'bg-ink text-white font-medium shadow-sm'
                            : 'bg-white hover:bg-paper text-ink-muted hover:text-ink border border-hairline'
                    ]"
                >
                    All Researchers
                </button>
                <button
                    @click="activeTab = 'Researchers'"
                    :class="[
                        'text-xs font-mono px-5 py-2 rounded-full transition-all duration-150',
                        activeTab === 'Researchers'
                            ? 'bg-ink text-white font-medium shadow-sm'
                            : 'bg-white hover:bg-paper text-ink-muted hover:text-ink border border-hairline'
                    ]"
                >
                    Researchers
                </button>
                <button
                    @click="activeTab = 'Research Assistants'"
                    :class="[
                        'text-xs font-mono px-5 py-2 rounded-full transition-all duration-150',
                        activeTab === 'Research Assistants'
                            ? 'bg-ink text-white font-medium shadow-sm'
                            : 'bg-white hover:bg-paper text-ink-muted hover:text-ink border border-hairline'
                    ]"
                >
                    Research Assistants
                </button>
            </div>

            <!-- 3. Section Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-2 font-serif text-2xl text-ink font-normal">
                    <span class="font-mono text-xs text-terracotta uppercase">01 / DIRECTORATE</span>
                    <span>Principal Investigators</span>
                </div>
                <span class="font-mono text-xs text-ink-subtle uppercase">
                    CORE RESEARCH LEADERSHIP
                </span>
            </div>

            <!-- 4. Staff Cards Grid (Matches Screenshot 1) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    v-for="staff in displayedStaff"
                    :key="staff.id"
                    class="bg-white rounded-2xl border border-hairline p-5 flex flex-col justify-between hover:border-ink/40 shadow-sm transition-all duration-200 group"
                >
                    <div>
                        <!-- Photo Container with Badges -->
                        <div class="relative aspect-[4/3] rounded-xl overflow-hidden bg-neutral-900 mb-6">
                            <img
                                :src="staff.image || 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop'"
                                :alt="staff.name"
                                class="w-full h-full object-cover grayscale contrast-105 group-hover:scale-105 transition-transform duration-700"
                            />

                            <!-- Top Floating Badge -->
                            <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md px-2.5 py-1 rounded-full text-[10px] font-mono text-white flex items-center gap-1.5 border border-white/20">
                                <span>{{ getStaffMeta(staff).badge }}</span>
                            </div>

                            <!-- Bottom Right Scopus h-index Badge -->
                            <div class="absolute bottom-3 right-3 bg-black/70 backdrop-blur-md px-2.5 py-1 rounded-md text-[10px] font-mono text-white/90 border border-white/10">
                                {{ getStaffMeta(staff).hIndex }}
                            </div>
                        </div>

                        <!-- Role Category & ID -->
                        <div class="flex items-center justify-between text-[11px] font-mono mb-2">
                            <span class="text-terracotta font-semibold uppercase">
                                {{ getStaffMeta(staff).roleCategory }}
                            </span>
                            <span class="text-ink-subtle">
                                ID: {{ getStaffMeta(staff).id }}
                            </span>
                        </div>

                        <!-- Name -->
                        <h3 class="font-serif text-2xl text-ink font-normal leading-snug mb-1 group-hover:text-terracotta transition-colors">
                            <Link :href="route('people.show', staff.slug || staff.id)">
                                {{ staff.name }}
                            </Link>
                        </h3>

                        <!-- Role Subtitle -->
                        <div class="text-xs text-ink-muted mb-4 font-medium">
                            {{ staff.role }}
                        </div>

                        <!-- Description Bio -->
                        <p class="text-xs text-ink-muted leading-relaxed line-clamp-3 mb-6">
                            {{ staff.description }}
                        </p>

                        <!-- Expertise Pills -->
                        <div v-if="staff.expertise" class="flex flex-wrap gap-1.5 mb-6">
                            <span
                                v-for="(tag, idx) in staff.expertise.split(',')"
                                :key="idx"
                                class="bg-paper px-2.5 py-1 rounded-md border border-hairline text-[10px] font-mono text-ink-muted"
                            >
                                {{ tag.trim() }}
                            </span>
                        </div>
                    </div>

                    <!-- Footer Row -->
                    <div class="pt-4 border-t border-hairline flex items-center justify-between text-xs font-mono">
                        <span class="text-ink-subtle">
                            {{ getStaffMeta(staff).monographsCount }}
                        </span>
                        <Link
                            :href="route('people.show', staff.slug || staff.id)"
                            class="text-ink hover:text-terracotta font-semibold flex items-center gap-1 transition-colors"
                        >
                            <span>{{ getStaffMeta(staff).linkText }}</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
