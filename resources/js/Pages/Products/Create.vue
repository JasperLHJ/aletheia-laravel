<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import InputNumber from 'primevue/inputnumber';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import Textarea from 'primevue/textarea';

const props = defineProps({
    categories: Array,
});

const form = useForm({
    name: '',
    sku: '',
    description: '',
    price: 0,
    stock: 0,
    status: 'active',
    category_id: null,
});
</script>

<template>
    <Head title="Create Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center gap-4">
                <Button
                    icon="pi pi-arrow-left"
                    text
                    rounded
                    aria-label="Back to products"
                    @click="router.visit(route('products.index'))"
                />
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        Create Product
                    </h2>
                    <p class="mt-1 text-slate-600 dark:text-slate-400">
                        Catalog details, pricing, and availability.
                    </p>
                </div>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-2xl">
                <Card>
                    <template #content>
                        <form
                            @submit.prevent="form.post(route('products.store'))"
                            class="space-y-6"
                        >
                            <div>
                                <InputLabel for="name" value="Name" />
                                <InputText
                                    id="name"
                                    v-model="form.name"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.name }"
                                    required
                                    autofocus
                                />
                                <InputError :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="sku" value="SKU" />
                                <InputText
                                    id="sku"
                                    v-model="form.sku"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.sku }"
                                    required
                                />
                                <InputError :message="form.errors.sku" />
                            </div>
                            <div>
                                <InputLabel for="description" value="Description" />
                                <Textarea
                                    id="description"
                                    v-model="form.description"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.description }"
                                    rows="3"
                                />
                                <InputError :message="form.errors.description" />
                            </div>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <InputLabel for="price" value="Price" />
                                    <InputNumber
                                        id="price"
                                        v-model="form.price"
                                        class="mt-2 block w-full"
                                        :class="{ 'p-invalid': form.errors.price }"
                                        mode="decimal"
                                        :min-fraction-digits="2"
                                        :max-fraction-digits="2"
                                        :min="0"
                                    />
                                    <InputError :message="form.errors.price" />
                                </div>
                                <div>
                                    <InputLabel for="stock" value="Stock" />
                                    <InputNumber
                                        id="stock"
                                        v-model="form.stock"
                                        class="mt-2 block w-full"
                                        :class="{ 'p-invalid': form.errors.stock }"
                                        :min="0"
                                        integer-only
                                    />
                                    <InputError :message="form.errors.stock" />
                                </div>
                            </div>
                            <div>
                                <InputLabel for="status" value="Status" />
                                <Select
                                    id="status"
                                    v-model="form.status"
                                    :options="[
                                        { label: 'Active', value: 'active' },
                                        { label: 'Inactive', value: 'inactive' },
                                    ]"
                                    optionLabel="label"
                                    optionValue="value"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.status }"
                                />
                                <InputError :message="form.errors.status" />
                            </div>
                            <div>
                                <InputLabel for="category_id" value="Category" />
                                <Select
                                    id="category_id"
                                    v-model="form.category_id"
                                    :options="[{ id: null, name: '— None —' }, ...categories]"
                                    optionLabel="name"
                                    optionValue="id"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.category_id }"
                                />
                                <InputError :message="form.errors.category_id" />
                            </div>
                            <div class="flex flex-wrap gap-3 pt-2">
                                <Button
                                    type="submit"
                                    label="Create"
                                    :loading="form.processing"
                                />
                                <Button
                                    type="button"
                                    label="Cancel"
                                    severity="secondary"
                                    @click="router.visit(route('products.index'))"
                                />
                            </div>
                        </form>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
