<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Tag from 'primevue/tag';

defineProps({
    testimonial: Object,
});
</script>

<template>
    <Head :title="`Testimonial: ${testimonial.author}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-6 lg:flex-row lg:flex-wrap lg:items-center lg:justify-between">
                <div class="flex flex-wrap items-center gap-4">
                    <Button
                        icon="pi pi-arrow-left"
                        text
                        rounded
                        aria-label="Back to testimonials"
                        @click="router.visit(route('testimonials.index'))"
                    />
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        {{ testimonial.author }}
                    </h2>
                    <Tag
                        :value="testimonial.status"
                        :severity="
                            testimonial.status === 'published'
                                ? 'success'
                                : testimonial.status === 'draft'
                                  ? 'warn'
                                  : 'secondary'
                        "
                    />
                </div>
                <Button
                    label="Edit"
                    icon="pi pi-pencil"
                    class="shrink-0"
                    @click="router.visit(route('testimonials.edit', testimonial.id))"
                />
            </div>
        </template>

        <div class="px-4 py-8 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-4xl">
                <Card>
                    <template #content>
                        <dl class="space-y-8">
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Quote</dt>
                                <dd class="mt-2 whitespace-pre-wrap leading-relaxed text-slate-900 dark:text-slate-100">{{ testimonial.quote }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Author</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ testimonial.author }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Role / label</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ testimonial.role }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Initials</dt>
                                <dd class="mt-2 font-mono text-slate-900 dark:text-slate-100">{{ testimonial.initials || '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Status</dt>
                                <dd class="mt-2">
                                    <Tag
                                        :value="testimonial.status"
                                        :severity="
                                            testimonial.status === 'published'
                                                ? 'success'
                                                : testimonial.status === 'draft'
                                                  ? 'warn'
                                                  : 'secondary'
                                        "
                                    />
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Featured on home</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ testimonial.is_featured ? 'Yes' : 'No' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Sort order</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ testimonial.sort_order }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Created</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ new Date(testimonial.created_at).toLocaleString() }}</dd>
                            </div>
                        </dl>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
