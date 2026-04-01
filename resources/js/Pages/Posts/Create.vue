<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import Textarea from 'primevue/textarea';

const props = defineProps({
    categories: Array,
});

const form = useForm({
    title: '',
    slug: '',
    body: '',
    status: 'draft',
    category_id: null,
});
</script>

<template>
    <Head title="Create Post" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center gap-4">
                <Button
                    icon="pi pi-arrow-left"
                    text
                    rounded
                    aria-label="Back to posts"
                    @click="router.visit(route('posts.index'))"
                />
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        Create Post
                    </h2>
                    <p class="mt-1 text-slate-600 dark:text-slate-400">
                        Add a title, body, and optional category.
                    </p>
                </div>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-2xl">
                <Card>
                    <template #content>
                        <form
                            @submit.prevent="form.post(route('posts.store'))"
                            class="space-y-6"
                        >
                            <div>
                                <InputLabel for="title" value="Title" />
                                <InputText
                                    id="title"
                                    v-model="form.title"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.title }"
                                    required
                                    autofocus
                                />
                                <InputError :message="form.errors.title" />
                            </div>
                            <div>
                                <InputLabel for="slug" value="Slug (optional - auto-generated from title)" />
                                <InputText
                                    id="slug"
                                    v-model="form.slug"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.slug }"
                                />
                                <InputError :message="form.errors.slug" />
                            </div>
                            <div>
                                <InputLabel for="body" value="Body" />
                                <Textarea
                                    id="body"
                                    v-model="form.body"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.body }"
                                    rows="6"
                                    required
                                />
                                <InputError :message="form.errors.body" />
                            </div>
                            <div>
                                <InputLabel for="status" value="Status" />
                                <Select
                                    id="status"
                                    v-model="form.status"
                                    :options="[
                                        { label: 'Draft', value: 'draft' },
                                        { label: 'Published', value: 'published' },
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
                                    @click="router.visit(route('posts.index'))"
                                />
                            </div>
                        </form>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
