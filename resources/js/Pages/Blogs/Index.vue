<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTableActions from '@/Components/DataTableActions.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Button from 'primevue/button';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Tag from 'primevue/tag';

defineProps({
    posts: Array,
});

const page = usePage();
const flash = computed(() => page.props.flash ?? {});
const syncing = ref(false);

function syncInstagram() {
    syncing.value = true;
    router.post(route('blogs.scrape'), {}, {
        onFinish: () => { syncing.value = false; },
    });
}
</script>

<template>
    <Head title="Blog" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        Blog
                    </h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        Draft and published posts for the public site.
                    </p>
                </div>
                <div class="flex shrink-0 gap-3">
                    <Button
                        label="Sync Instagram"
                        icon="pi pi-instagram"
                        severity="secondary"
                        :loading="syncing"
                        @click="syncInstagram"
                    />
                    <Button
                        label="Add post"
                        icon="pi pi-plus"
                        @click="router.visit(route('blogs.create'))"
                    />
                </div>
            </div>

            <div v-if="flash.success" class="mt-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-950 dark:text-green-300">
                {{ flash.success }}
            </div>
            <div v-if="flash.error" class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-950 dark:text-red-300">
                {{ flash.error }}
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
                        <Column field="category" header="Category" />
                        <Column header="Source">
                            <template #body="{ data }">
                                <Tag
                                    v-if="data.source === 'instagram'"
                                    value="Instagram"
                                    icon="pi pi-instagram"
                                    severity="info"
                                />
                                <span v-else class="text-slate-400">—</span>
                            </template>
                        </Column>
                        <Column field="is_featured" header="Featured">
                            <template #body="{ data }">
                                <Tag
                                    v-if="data.is_featured"
                                    value="Yes"
                                    severity="info"
                                />
                                <span v-else class="text-slate-400">—</span>
                            </template>
                        </Column>
                        <Column field="user.name" header="Author">
                            <template #body="{ data }">
                                <span v-if="data.user">{{ data.user.name }}</span>
                                <span v-else class="text-slate-400">—</span>
                            </template>
                        </Column>
                        <Column field="created_at" header="Created">
                            <template #body="{ data }">
                                {{ new Date(data.created_at).toLocaleDateString() }}
                            </template>
                        </Column>
                        <Column header="Actions" style="min-width: 10.5rem">
                            <template #body="{ data }">
                                <DataTableActions
                                    :view-route="route('blogs.show', data.id)"
                                    :edit-route="route('blogs.edit', data.id)"
                                    :delete-route="route('blogs.destroy', data.id)"
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
