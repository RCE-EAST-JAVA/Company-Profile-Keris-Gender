<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Mail, Lock, Eye, EyeOff, ArrowLeft, ShieldCheck } from 'lucide-vue-next';

defineProps({
    status: {
        type: String,
        default: null,
    },
});

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen bg-[#fbfaf7] text-neutral-900 flex flex-col justify-between selection:bg-terracotta/20 selection:text-terracotta relative overflow-hidden font-sans">
        <Head title="Sign In — Center for Gender and International Relations Studies (GInRe)" />

        <!-- Atmospheric Ambient Glows -->
        <div class="pointer-events-none absolute -top-32 -left-32 w-96 h-96 bg-terracotta/10 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-32 -right-32 w-96 h-96 bg-amber-600/10 rounded-full blur-3xl"></div>

        <!-- Top Navigation -->
        <header class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 sm:pt-8 flex items-center justify-between relative z-10">
            <Link
                href="/"
                class="inline-flex items-center gap-2 text-xs sm:text-sm font-medium text-neutral-600 hover:text-terracotta transition-colors group"
            >
                <ArrowLeft class="w-4 h-4 transition-transform group-hover:-translate-x-1" />
                <span>Back to GIntRe Homepage</span>
            </Link>

            <div class="flex items-center gap-2 font-mono text-[11px] uppercase tracking-wider text-neutral-500 bg-neutral-100/80 backdrop-blur-xs px-3 py-1 rounded-full border border-neutral-200">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>System Operational</span>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 flex items-center justify-center relative z-10 my-auto">
            <div class="w-full grid grid-cols-1 lg:grid-cols-12 rounded-2xl sm:rounded-3xl border border-neutral-200/90 bg-white shadow-xl shadow-neutral-900/5 overflow-hidden">
                
                <!-- Left Column: Institutional Brand & Manifesto (Hidden on Small, Visible on LG) -->
                <div class="lg:col-span-5 bg-neutral-950 text-white p-8 sm:p-10 lg:p-12 flex flex-col justify-between relative overflow-hidden">
                    <!-- Subtle Geometric Glow Background -->
                    <div class="pointer-events-none absolute top-0 right-0 w-80 h-80 bg-terracotta/15 rounded-full blur-2xl"></div>
                    <div class="pointer-events-none absolute bottom-0 left-0 w-64 h-64 bg-amber-700/15 rounded-full blur-2xl"></div>

                    <!-- Top Emblem & Title -->
                    <div class="relative z-10">
                        <Link href="/" class="inline-flex items-center gap-3 group mb-8">
                            <div class="flex flex-col max-w-lg">
                            <span class="font-sans font-black text-2xl sm:text-[28px] text-[#e03a18] tracking-tight leading-none">
                                GIntRe
                            </span>
                            <span class="font-sans font-bold text-[8.5px] sm:text-[10px] text-white tracking-wider uppercase leading-none mt-1">
                                Center for Gender and International Relations Studies
                            </span>
                        </div>
                        </Link>

                      

                        <h2 class="font-serif text-2xl sm:text-3xl text-white font-light leading-snug tracking-tight mb-4">
                            Advancing rigorous gender scholarship & policy advocacy.
                        </h2>

                        <p class="text-xs sm:text-sm text-neutral-400 font-light leading-relaxed">
                            Authorized workspace for research fellows, editorial committee members, and administrative staff of GIntRe East Java.
                        </p>
                    </div>

                    <!-- Bottom Guarantee / Institutional Notice -->
                    <div class="relative z-10 pt-8 mt-8 border-t border-white/10">
                        <div class="flex items-start gap-3 text-neutral-400">
                            <ShieldCheck class="w-5 h-5 text-terracotta shrink-0 mt-0.5" />
                            <div class="text-xs font-light leading-relaxed">
                                <span class="text-neutral-200 font-medium block">Secure Administrative Portal</span>
                                Access is restricted to verified institution personnel. All sessions are monitored for safety and integrity.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Authentication Form -->
                <div class="lg:col-span-7 p-8 sm:p-10 lg:p-14 bg-white flex flex-col justify-center">
                    <div class="max-w-md w-full mx-auto">
                        
                        <!-- Header -->
                        <div class="mb-8">
                            <div class="flex items-center gap-2 font-mono text-xs text-terracotta uppercase tracking-wider mb-2">
                                <span>AUTHENTICATION</span>
                            </div>
                            <h1 class="font-serif text-3xl sm:text-4xl text-neutral-900 font-normal tracking-tight">
                                Sign in to Portal
                            </h1>
                            <p class="mt-2 text-sm text-neutral-500 font-light leading-relaxed">
                                Enter your institutional credentials to manage publications, programs, and staff records.
                            </p>
                        </div>

                        <!-- Status Message (e.g., session message) -->
                        <div
                            v-if="status"
                            class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-xs sm:text-sm text-emerald-800 flex items-center gap-2"
                        >
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>{{ status }}</span>
                        </div>

                        <!-- Form -->
                        <form @submit.prevent="submit" class="space-y-5">
                            <!-- Email Input -->
                            <div>
                                <label for="email" class="block font-mono text-[11px] uppercase tracking-wider text-neutral-600 font-semibold mb-1.5">
                                    Email
                                </label>
                                <div class="relative rounded-xl shadow-2xs">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-neutral-400">
                                        <Mail class="h-4 w-4" />
                                    </div>
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        placeholder="user@ginre.or.id"
                                        :class="[
                                            'w-full rounded-xl border pl-10 pr-4 py-3 text-sm transition-colors duration-200 placeholder:text-neutral-400 focus:outline-hidden',
                                            form.errors.email
                                                ? 'border-rose-300 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20'
                                                : 'border-neutral-200 hover:border-neutral-300 focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 bg-neutral-50/50 focus:bg-white'
                                        ]"
                                    />
                                </div>
                                <p v-if="form.errors.email" class="mt-1.5 text-xs text-rose-600 font-medium">
                                    {{ form.errors.email }}
                                </p>
                            </div>

                            <!-- Password Input -->
                            <div>
                                <label for="password" class="block font-mono text-[11px] uppercase tracking-wider text-neutral-600 font-semibold mb-1.5">
                                    Password
                                </label>
                                <div class="relative rounded-xl shadow-2xs">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-neutral-400">
                                        <Lock class="h-4 w-4" />
                                    </div>
                                    <input
                                        id="password"
                                        v-model="form.password"
                                        :type="showPassword ? 'text' : 'password'"
                                        required
                                        autocomplete="current-password"
                                        placeholder="••••••••••••"
                                        :class="[
                                            'w-full rounded-xl border pl-10 pr-11 py-3 text-sm transition-colors duration-200 placeholder:text-neutral-400 focus:outline-hidden',
                                            form.errors.password
                                                ? 'border-rose-300 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20'
                                                : 'border-neutral-200 hover:border-neutral-300 focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 bg-neutral-50/50 focus:bg-white'
                                        ]"
                                    />
                                    <button
                                        type="button"
                                        @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-neutral-400 hover:text-neutral-700 transition-colors focus:outline-hidden"
                                        :title="showPassword ? 'Hide password' : 'Show password'"
                                    >
                                        <EyeOff v-if="showPassword" class="h-4 w-4" />
                                        <Eye v-else class="h-4 w-4" />
                                    </button>
                                </div>
                                <p v-if="form.errors.password" class="mt-1.5 text-xs text-rose-600 font-medium">
                                    {{ form.errors.password }}
                                </p>
                            </div>

                            <!-- Remember Session Checkbox (No Forgot Password link) -->
                            <div class="flex items-center justify-between pt-1">
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input
                                        v-model="form.remember"
                                        type="checkbox"
                                        class="w-4 h-4 rounded border-neutral-300 text-terracotta focus:ring-terracotta/20 focus:ring-offset-0 transition"
                                    />
                                    <span class="text-xs sm:text-sm text-neutral-600 font-light">Keep me signed in</span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full flex items-center justify-center gap-2 bg-neutral-900 hover:bg-terracotta text-white font-medium text-sm py-3.5 px-6 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md hover:shadow-terracotta/20 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
                                >
                                    <span v-if="form.processing" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                                    <span>{{ form.processing ? 'Verifying Credentials...' : 'Sign In to Dashboard' }}</span>
                                </button>
                            </div>
                        </form>

                        <!-- Institutional Notice -->
                        <div class="mt-8 pt-6 border-t border-neutral-100 text-center">
                            <p class="text-[11px] text-neutral-400 font-light leading-relaxed">
                                Center for Gender and International Relations Studies &copy; {{ new Date().getFullYear() }}<br>
                                Need administrative assistance? Contact the system administrator.
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </main>

        <!-- Minimal Clean Footer -->
        <footer class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-6 text-center text-xs text-neutral-400 font-light relative z-10">
            <span>Faculty of Social & Political Sciences · Research & Community Service Gateway</span>
        </footer>
    </div>
</template>
