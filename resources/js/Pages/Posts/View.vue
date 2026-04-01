<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
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
                        aria-label="Back to posts"
                        @click="router.visit(route('posts.index'))"
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
                    @click="router.visit(route('posts.edit', post.id))"
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
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">
                                    <template v-if="post.category">
                                        <Link
                                            :href="route('categories.show', post.category.id)"
                                            class="font-medium text-blue-600 underline-offset-2 hover:underline dark:text-blue-400"
                                        >
                                            {{ post.category.name }}
                                        </Link>
                                    </template>
                                    <template v-else>—</template>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Author</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ post.user?.name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Body</dt>
                                <dd class="mt-2 whitespace-pre-wrap leading-relaxed text-slate-900 dark:text-slate-100">{{ post.body }}</dd>
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
