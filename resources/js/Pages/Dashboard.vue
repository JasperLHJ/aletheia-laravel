<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Card from 'primevue/card';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                    Dashboard
                </h2>
                <p class="mt-2 max-w-2xl text-slate-600 dark:text-slate-400">
                    Manage blog posts, testimonials, educator profiles, and static site JSON for the public
                    site.
                </p>
            </div>
        </template>

        <div class="px-4 py-10 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-7xl">
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4">
                    <Link :href="route('blogs.index')" class="group block">
                        <Card
                            class="h-full border border-transparent transition duration-200 hover:-translate-y-0.5 hover:border-blue-200/80 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:border-blue-500/30 dark:hover:shadow-none"
                        >
                            <template #header>
                                <div class="flex items-start gap-5 p-6 sm:p-7">
                                    <span
                                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-500/10 text-blue-600 dark:bg-blue-400/15 dark:text-blue-400"
                                    >
                                        <i class="pi pi-file-edit text-2xl" aria-hidden="true" />
                                    </span>
                                    <div class="min-w-0 pt-0.5">
                                        <h3
                                            class="font-semibold text-slate-900 dark:text-slate-100"
                                        >
                                            Blog
                                        </h3>
                                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                            Create and publish articles, set categories and featured posts.
                                        </p>
                                        <span
                                            class="mt-4 inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400"
                                        >
                                            Open
                                            <i
                                                class="pi pi-arrow-right ms-2 text-xs transition-transform group-hover:translate-x-0.5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </div>
                                </div>
                            </template>
                        </Card>
                    </Link>
                    <Link :href="route('testimonials.index')" class="group block">
                        <Card
                            class="h-full border border-transparent transition duration-200 hover:-translate-y-0.5 hover:border-amber-200/80 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:border-amber-500/30 dark:hover:shadow-none"
                        >
                            <template #header>
                                <div class="flex items-start gap-5 p-6 sm:p-7">
                                    <span
                                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 text-amber-700 dark:bg-amber-400/15 dark:text-amber-300"
                                    >
                                        <i class="pi pi-comments text-2xl" aria-hidden="true" />
                                    </span>
                                    <div class="min-w-0 pt-0.5">
                                        <h3
                                            class="font-semibold text-slate-900 dark:text-slate-100"
                                        >
                                            Testimonials
                                        </h3>
                                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                            Edit quotes for the home page and About tab; mark featured for the carousel.
                                        </p>
                                        <span
                                            class="mt-4 inline-flex items-center text-sm font-medium text-amber-700 dark:text-amber-300"
                                        >
                                            Open
                                            <i
                                                class="pi pi-arrow-right ms-2 text-xs transition-transform group-hover:translate-x-0.5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </div>
                                </div>
                            </template>
                        </Card>
                    </Link>
                    <Link :href="route('educators.index')" class="group block">
                        <Card
                            class="h-full border border-transparent transition duration-200 hover:-translate-y-0.5 hover:border-emerald-200/80 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:border-emerald-500/30 dark:hover:shadow-none"
                        >
                            <template #header>
                                <div class="flex items-start gap-5 p-6 sm:p-7">
                                    <span
                                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-700 dark:bg-emerald-400/15 dark:text-emerald-300"
                                    >
                                        <i class="pi pi-users text-2xl" aria-hidden="true" />
                                    </span>
                                    <div class="min-w-0 pt-0.5">
                                        <h3
                                            class="font-semibold text-slate-900 dark:text-slate-100"
                                        >
                                            Educators
                                        </h3>
                                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                            Principal spotlight and teacher profiles on the About page.
                                        </p>
                                        <span
                                            class="mt-4 inline-flex items-center text-sm font-medium text-emerald-700 dark:text-emerald-300"
                                        >
                                            Open
                                            <i
                                                class="pi pi-arrow-right ms-2 text-xs transition-transform group-hover:translate-x-0.5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </div>
                                </div>
                            </template>
                        </Card>
                    </Link>
                    <Link :href="route('site-content.index')" class="group block">
                        <Card
                            class="h-full border border-transparent transition duration-200 hover:-translate-y-0.5 hover:border-violet-200/80 hover:shadow-lg hover:shadow-slate-200/60 dark:hover:border-violet-500/30 dark:hover:shadow-none"
                        >
                            <template #header>
                                <div class="flex items-start gap-5 p-6 sm:p-7">
                                    <span
                                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-violet-500/10 text-violet-700 dark:bg-violet-400/15 dark:text-violet-300"
                                    >
                                        <i class="pi pi-database text-2xl" aria-hidden="true" />
                                    </span>
                                    <div class="min-w-0 pt-0.5">
                                        <h3
                                            class="font-semibold text-slate-900 dark:text-slate-100"
                                        >
                                            Site content
                                        </h3>
                                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                            Simple forms for page text — photos and links stay as set by your team.
                                        </p>
                                        <span
                                            class="mt-4 inline-flex items-center text-sm font-medium text-violet-700 dark:text-violet-300"
                                        >
                                            Open
                                            <i
                                                class="pi pi-arrow-right ms-2 text-xs transition-transform group-hover:translate-x-0.5"
                                                aria-hidden="true"
                                            />
                                        </span>
                                    </div>
                                </div>
                            </template>
                        </Card>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
