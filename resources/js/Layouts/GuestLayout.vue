<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ThemeToggle from '@/Components/ThemeToggle.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="relative min-h-screen bg-[#f4f6f9] dark:bg-[#1a1a1a]"
    >
        <div
            class="absolute end-4 top-4 z-10 sm:end-6 sm:top-6"
            aria-label="Color theme"
        >
            <ThemeToggle tone="guest" />
        </div>

        <div
            class="flex min-h-screen flex-col items-center justify-center px-4 pb-12 pt-14 sm:px-6"
        >
            <div class="mb-8">
                <Link
                    href="/"
                    class="block transition hover:opacity-80"
                >
                    <ApplicationLogo
                        class="h-16 w-16 fill-current text-slate-600 dark:text-slate-300 sm:h-20 sm:w-20"
                    />
                </Link>
            </div>

            <div
                class="w-full max-w-md overflow-hidden rounded-2xl border border-slate-200/90 bg-white px-8 py-10 shadow-lg shadow-slate-200/40 dark:border-slate-700/80 dark:bg-slate-900/80 dark:shadow-none sm:px-10 sm:py-11"
            >
                <slot />
            </div>
        </div>
    </div>
</template>
