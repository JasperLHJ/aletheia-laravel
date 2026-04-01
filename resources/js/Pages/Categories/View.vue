<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';

defineProps({
    category: Object,
});
</script>

<template>
    <Head :title="`Category: ${category.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-6 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between">
                <div class="flex flex-wrap items-center gap-4">
                    <Button
                        icon="pi pi-arrow-left"
                        text
                        rounded
                        aria-label="Back to categories"
                        @click="router.visit(route('categories.index'))"
                    />
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        {{ category.name }}
                    </h2>
                </div>
                <Button
                    label="Edit"
                    icon="pi pi-pencil"
                    class="shrink-0"
                    @click="router.visit(route('categories.edit', category.id))"
                />
            </div>
        </template>

        <div class="px-4 py-8 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-3xl">
                <Card>
                    <template #content>
                        <dl class="space-y-8">
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Name</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ category.name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Slug</dt>
                                <dd class="mt-2 font-mono text-slate-900 dark:text-slate-100">{{ category.slug }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Description</dt>
                                <dd class="mt-2 leading-relaxed text-slate-900 dark:text-slate-100">{{ category.description || '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Posts</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ category.posts_count }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Products</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ category.products_count }}</dd>
                            </div>
                        </dl>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
