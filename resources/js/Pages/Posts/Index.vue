<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTableActions from '@/Components/DataTableActions.vue';
import { Head, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Tag from 'primevue/tag';

defineProps({
    posts: Array,
});
</script>

<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        Posts
                    </h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        Draft and published articles, with categories and authors.
                    </p>
                </div>
                <Button
                    label="Add Post"
                    icon="pi pi-plus"
                    class="shrink-0"
                    @click="router.visit(route('posts.create'))"
                />
            </div>
        </template>

        <div class="px-4 py-8 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-7xl">
                <div
                    class="overflow-hidden rounded-xl border border-slate-200/90 bg-white shadow-sm dark:border-slate-700/80 dark:bg-slate-900/60"
                >
                    <DataTable
                        :value="posts"
                        stripedRows
                        tableClass="min-w-full"
                    >
                        <Column field="title" header="Title" sortable />
                        <Column field="status" header="Status">
                            <template #body="{ data }">
                                <Tag
                                    :value="data.status"
                                    :severity="
                                        data.status === 'published'
                                            ? 'success'
                                            : data.status === 'draft'
                                              ? 'warn'
                                              : 'secondary'
                                    "
                                />
                            </template>
                        </Column>
                        <Column field="category.name" header="Category" />
                        <Column field="user.name" header="Author" />
                        <Column field="created_at" header="Created">
                            <template #body="{ data }">
                                {{ new Date(data.created_at).toLocaleDateString() }}
                            </template>
                        </Column>
                        <Column header="Actions" style="min-width: 10.5rem">
                            <template #body="{ data }">
                                <DataTableActions
                                    :view-route="route('posts.show', data.id)"
                                    :edit-route="route('posts.edit', data.id)"
                                    :delete-route="route('posts.destroy', data.id)"
                                    :item-id="data.id"
                                    :item-name="data.title"
                                />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
