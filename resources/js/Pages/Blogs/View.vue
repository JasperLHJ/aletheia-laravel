<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Tag from 'primevue/tag';

defineProps({
    post: Object,
});
</script>

<template>
    <Head :title="post.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-6 lg:flex-row lg:flex-wrap lg:items-center lg:justify-between">
                <div class="flex flex-wrap items-center gap-4">
                    <Button
                        icon="pi pi-arrow-left"
                        text
                        rounded
                        aria-label="Back to blog"
                        @click="router.visit(route('blogs.index'))"
                    />
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        {{ post.title }}
                    </h2>
                    <Tag
                        :value="post.status"
                        :severity="
                            post.status === 'published'
                                ? 'success'
                                : post.status === 'draft'
                                  ? 'warn'
                                  : 'secondary'
                        "
                    />
                </div>
                <Button
                    label="Edit"
                    icon="pi pi-pencil"
                    class="shrink-0"
                    @click="router.visit(route('blogs.edit', post.id))"
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
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ post.title }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Slug</dt>
                                <dd class="mt-2 font-mono text-slate-900 dark:text-slate-100">{{ post.slug }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Status</dt>
                                <dd class="mt-2">
                                    <Tag
                                        :value="post.status"
                                        :severity="
                                            post.status === 'published'
                                                ? 'success'
                                                : post.status === 'draft'
                                                  ? 'warn'
                                                  : 'secondary'
                                        "
                                    />
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Category</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ post.category || '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Featured</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ post.is_featured ? 'Yes' : 'No' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Author</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ post.user?.name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Excerpt</dt>
                                <dd class="mt-2 whitespace-pre-wrap leading-relaxed text-slate-900 dark:text-slate-100">{{ post.excerpt || '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Featured image</dt>
                                <dd class="mt-2 font-mono text-sm text-slate-900 dark:text-slate-100">{{ post.featured_image || '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Reading time (minutes)</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ post.reading_time_minutes ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Published at</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">
                                    {{ post.published_at ? new Date(post.published_at).toLocaleString() : '—' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Body preview (HTML)</dt>
                                <dd class="mt-2 rounded-lg border border-slate-200 bg-white p-4 text-sm leading-relaxed text-slate-800 dark:border-slate-600 dark:bg-slate-950 dark:text-slate-200">
                                    <div class="blog-admin-body" v-html="post.body" />
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Created</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ new Date(post.created_at).toLocaleString() }}</dd>
                            </div>
                        </dl>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
