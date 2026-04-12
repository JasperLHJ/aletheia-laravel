<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTableActions from '@/Components/DataTableActions.vue';
import { Head, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Tag from 'primevue/tag';

defineProps({
    testimonials: Array,
});

function quotePreview(quote) {
    if (!quote) return '';
    const t = String(quote).trim();
    if (t.length <= 80) return t;
    return `${t.slice(0, 80)}…`;
}
</script>

<template>
    <Head title="Testimonials" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        Testimonials
                    </h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        Manage quotes for the public home and About pages.
                    </p>
                </div>
                <Button
                    label="Add testimonial"
                    icon="pi pi-plus"
                    class="shrink-0"
                    @click="router.visit(route('testimonials.create'))"
                />
            </div>
        </template>

        <div class="px-4 py-8 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-7xl">
                <div
                    class="overflow-hidden rounded-xl border border-slate-200/90 bg-white shadow-sm dark:border-slate-700/80 dark:bg-slate-900/60"
                >
                    <DataTable
                        :value="testimonials"
                        stripedRows
                        tableClass="min-w-full"
                    >
                        <Column header="Quote">
                            <template #body="{ data }">
                                <span class="line-clamp-2 text-slate-800 dark:text-slate-200">
                                    {{ quotePreview(data.quote) }}
                                </span>
                            </template>
                        </Column>
                        <Column field="author" header="Author" sortable />
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
                        <Column field="is_featured" header="Featured (home)">
                            <template #body="{ data }">
                                <Tag
                                    v-if="data.is_featured"
                                    value="Yes"
                                    severity="info"
                                />
                                <span v-else class="text-slate-400">—</span>
                            </template>
                        </Column>
                        <Column field="sort_order" header="Order" sortable />
                        <Column header="Actions" style="min-width: 10.5rem">
                            <template #body="{ data }">
                                <DataTableActions
                                    :view-route="route('testimonials.show', data.id)"
                                    :edit-route="route('testimonials.edit', data.id)"
                                    :delete-route="route('testimonials.destroy', data.id)"
                                    :item-id="data.id"
                                    :item-name="data.author"
                                />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
