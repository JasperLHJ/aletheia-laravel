<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Checkbox from 'primevue/checkbox';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Select from 'primevue/select';
import Textarea from 'primevue/textarea';

const props = defineProps({
    educator: Object,
});

const form = useForm({
    name: props.educator.name,
    title: props.educator.title,
    image: props.educator.image ?? '',
    bio: props.educator.bio,
    detail: props.educator.detail,
    sort_order: props.educator.sort_order ?? 0,
    is_principal: !!props.educator.is_principal,
    status: props.educator.status,
});

function submit() {
    form
        .transform((data) => ({
            ...data,
            image: data.image || null,
            sort_order: data.sort_order ?? 0,
        }))
        .put(route('educators.update', props.educator.id));
}
</script>

<template>
    <Head :title="`Edit: ${educator.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center gap-4">
                <Button
                    icon="pi pi-arrow-left"
                    text
                    rounded
                    aria-label="Back to educators"
                    @click="router.visit(route('educators.index'))"
                />
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        Edit educator
                    </h2>
                    <p class="mt-1 text-slate-600 dark:text-slate-400">
                        Published profiles appear on the About page; only one principal spotlight is shown.
                    </p>
                </div>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-2xl">
                <Card>
                    <template #content>
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <InputText
                                    id="name"
                                    v-model="form.name"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.name }"
                                    required
                                />
                                <InputError :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="title" value="Title / role" />
                                <InputText
                                    id="title"
                                    v-model="form.title"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.title }"
                                    required
                                />
                                <InputError :message="form.errors.title" />
                            </div>
                            <div>
                                <InputLabel for="image" value="Image URL (optional)" />
                                <InputText
                                    id="image"
                                    v-model="form.image"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.image }"
                                    placeholder="/images/example.jpg"
                                />
                                <InputError :message="form.errors.image" />
                            </div>
                            <div>
                                <InputLabel for="bio" value="Bio (short)" />
                                <Textarea
                                    id="bio"
                                    v-model="form.bio"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.bio }"
                                    rows="4"
                                    required
                                />
                                <InputError :message="form.errors.bio" />
                            </div>
                            <div>
                                <InputLabel for="detail" value="Full profile / responsibilities" />
                                <Textarea
                                    id="detail"
                                    v-model="form.detail"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.detail }"
                                    rows="8"
                                    required
                                />
                                <InputError :message="form.errors.detail" />
                            </div>
                            <div>
                                <InputLabel for="sort_order" value="Sort order" />
                                <InputNumber
                                    id="sort_order"
                                    v-model="form.sort_order"
                                    class="mt-2 w-full"
                                    input-class="w-full"
                                    :min="0"
                                    :max="99999"
                                    :show-buttons="false"
                                    :class="{ 'p-invalid': form.errors.sort_order }"
                                />
                                <InputError :message="form.errors.sort_order" />
                            </div>
                            <div class="flex items-center gap-2">
                                <Checkbox v-model="form.is_principal" input-id="is_principal" binary />
                                <InputLabel for="is_principal" value="Principal spotlight (About page)" class="mb-0" />
                            </div>
                            <InputError :message="form.errors.is_principal" />
                            <div>
                                <InputLabel for="status" value="Status" />
                                <Select
                                    id="status"
                                    v-model="form.status"
                                    :options="[
                                        { label: 'Draft', value: 'draft' },
                                        { label: 'Published', value: 'published' },
                                    ]"
                                    option-label="label"
                                    option-value="value"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.status }"
                                />
                                <InputError :message="form.errors.status" />
                            </div>
                            <div class="flex flex-wrap gap-3 pt-2">
                                <Button type="submit" label="Update" :loading="form.processing" />
                                <Button
                                    type="button"
                                    label="Cancel"
                                    severity="secondary"
                                    @click="router.visit(route('educators.index'))"
                                />
                            </div>
                        </form>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
