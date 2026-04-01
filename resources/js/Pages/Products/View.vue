<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Tag from 'primevue/tag';

defineProps({
    product: Object,
});
</script>

<template>
    <Head :title="product.name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-6 lg:flex-row lg:flex-wrap lg:items-center lg:justify-between">
                <div class="flex flex-wrap items-center gap-4">
                    <Button
                        icon="pi pi-arrow-left"
                        text
                        rounded
                        aria-label="Back to products"
                        @click="router.visit(route('products.index'))"
                    />
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        {{ product.name }}
                    </h2>
                    <Tag
                        :value="product.status"
                        :severity="product.status === 'active' ? 'success' : 'warn'"
                    />
                </div>
                <Button
                    label="Edit"
                    icon="pi pi-pencil"
                    class="shrink-0"
                    @click="router.visit(route('products.edit', product.id))"
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
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ product.name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">SKU</dt>
                                <dd class="mt-2 font-mono text-slate-900 dark:text-slate-100">{{ product.sku }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Description</dt>
                                <dd class="mt-2 whitespace-pre-wrap leading-relaxed text-slate-900 dark:text-slate-100">{{ product.description || '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Price</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">
                                    {{ Number(product.price).toLocaleString('en-US', { style: 'currency', currency: 'USD' }) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Stock</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ product.stock }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Status</dt>
                                <dd class="mt-2">
                                    <Tag
                                        :value="product.status"
                                        :severity="product.status === 'active' ? 'success' : 'warn'"
                                    />
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Category</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">
                                    <template v-if="product.category">
                                        <Link
                                            :href="route('categories.show', product.category.id)"
                                            class="font-medium text-blue-600 underline-offset-2 hover:underline dark:text-blue-400"
                                        >
                                            {{ product.category.name }}
                                        </Link>
                                    </template>
                                    <template v-else>—</template>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Updated</dt>
                                <dd class="mt-2 text-slate-900 dark:text-slate-100">{{ new Date(product.updated_at).toLocaleString() }}</dd>
                            </div>
                        </dl>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
