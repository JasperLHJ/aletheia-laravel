<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Tag from 'primevue/tag';

defineProps({
    educator: Object,
});
</script>

<template>
    <Head :title="`Educator: ${educator.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-6 lg:flex-row lg:flex-wrap lg:items-center lg:justify-between">
                <div class="flex flex-wrap items-center gap-4">
                    <Button
                        icon="pi pi-arrow-left"
                        text
                        rounded
                        aria-label="Back to educators"
                        @click="router.visit(route('educators.index'))"
                    />
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        {{ educator.name }}
                    </h2>
                    <Tag
                        :value="educator.status"
                        :severity="
                            educator.status === 'published'
                                ? 'success'
                                : educator.status === 'draft'
                                  ? 'warn'
                                  : 'secondary'
                        "
                    />
                </div>
                <Button
                    label="Edit"
                    icon="pi pi-pencil"
                    class="shrink-0"
                    @click="router.visit(route('educators.edit', educator.id))"
                />
            </div>
        </template>

        <div class="px-4 py-8 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-4xl">
                <Card>
                    <template #content>
                        <dl class="space-y-8">
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Title</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ educator.title }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Image URL</dt>
                                <dd class="mt-2 break-all font-mono text-sm text-slate-900 dark:text-slate-100">{{ educator.image || '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Bio</dt>
                                <dd class="mt-2 whitespace-pre-wrap leading-relaxed text-slate-900 dark:text-slate-100">{{ educator.bio }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Full profile</dt>
                                <dd class="mt-2 whitespace-pre-wrap leading-relaxed text-slate-900 dark:text-slate-100">{{ educator.detail }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Principal spotlight</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ educator.is_principal ? 'Yes' : 'No' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Status</dt>
                                <dd class="mt-2">
                                    <Tag
                                        :value="educator.status"
                                        :severity="
                                            educator.status === 'published'
                                                ? 'success'
                                                : educator.status === 'draft'
                                                  ? 'warn'
                                                  : 'secondary'
                                        "
                                    />
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Sort order</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ educator.sort_order }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Created</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ new Date(educator.created_at).toLocaleString() }}</dd>
                            </div>
                        </dl>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
