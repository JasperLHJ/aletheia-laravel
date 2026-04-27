<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Card from 'primevue/card';

defineProps({
    documents: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Site content" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                    Site content
                </h2>
                <p class="mt-2 max-w-2xl text-slate-600 dark:text-slate-400">
                    Update headings, paragraphs, and labels for the public site. Photos and links are
                    unchanged from here.
                </p>
            </div>
        </template>

        <div class="px-4 py-10 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-7xl">
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="doc in documents"
                        :key="doc.slug"
                        :href="route('site-content.edit', doc.slug)"
                        class="group block"
                    >
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
                                            {{ doc.label }}
                                        </h3>
                                        <p
                                            class="mt-2 font-mono text-xs text-slate-500 dark:text-slate-400"
                                        >
                                            {{ doc.slug }}.json
                                        </p>
                                        <span
                                            class="mt-4 inline-flex items-center text-sm font-medium text-violet-700 dark:text-violet-300"
                                        >
                                            Edit
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
