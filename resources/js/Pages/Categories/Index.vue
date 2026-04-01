<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTableActions from '@/Components/DataTableActions.vue';
import { Head, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';

defineProps({
    categories: Array,
});
</script>

<template>
    <Head title="Categories" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        Categories
                    </h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        Labels and structure for posts and products.
                    </p>
                </div>
                <Button
                    label="Add Category"
                    icon="pi pi-plus"
                    class="shrink-0"
                    @click="router.visit(route('categories.create'))"
                />
            </div>
        </template>

        <div class="px-4 py-8 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-7xl">
                <div
                    class="overflow-hidden rounded-xl border border-slate-200/90 bg-white shadow-sm dark:border-slate-700/80 dark:bg-slate-900/60"
                >
                    <DataTable
                        :value="categories"
                        stripedRows
                        tableClass="min-w-full"
                    >
                        <Column field="name" header="Name" sortable />
                        <Column field="slug" header="Slug" />
                        <Column field="description" header="Description">
                            <template #body="{ data }">
                                {{ data.description || '—' }}
                            </template>
                        </Column>
                        <Column header="Actions" style="min-width: 10.5rem">
                            <template #body="{ data }">
                                <DataTableActions
                                    :view-route="route('categories.show', data.id)"
                                    :edit-route="route('categories.edit', data.id)"
                                    :delete-route="route('categories.destroy', data.id)"
                                    :item-id="data.id"
                                    :item-name="data.name"
                                />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
