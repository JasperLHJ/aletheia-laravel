<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';

const form = useForm({
    name: '',
    slug: '',
    description: '',
});
</script>

<template>
    <Head title="Create Category" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center gap-4">
                <Button
                    icon="pi pi-arrow-left"
                    text
                    rounded
                    aria-label="Back to categories"
                    @click="router.visit(route('categories.index'))"
                />
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        Create Category
                    </h2>
                    <p class="mt-1 text-slate-600 dark:text-slate-400">
                        Name, slug, and an optional description.
                    </p>
                </div>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-2xl">
                <Card>
                    <template #content>
                        <form
                            @submit.prevent="form.post(route('categories.store'))"
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
                                <InputLabel for="slug" value="Slug (optional - auto-generated from name)" />
                                <InputText
                                    id="slug"
                                    v-model="form.slug"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.slug }"
                                />
                                <InputError :message="form.errors.slug" />
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
                                    @click="router.visit(route('categories.index'))"
                                />
                            </div>
                        </form>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
