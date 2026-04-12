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

const form = useForm({
    quote: '',
    author: '',
    role: '',
    initials: '',
    sort_order: 0,
    is_featured: false,
    status: 'draft',
});

function submit() {
    form
        .transform((data) => ({
            ...data,
            initials: data.initials || null,
            sort_order: data.sort_order ?? 0,
        }))
        .post(route('testimonials.store'));
}
</script>

<template>
    <Head title="Create testimonial" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center gap-4">
                <Button
                    icon="pi pi-arrow-left"
                    text
                    rounded
                    aria-label="Back to testimonials"
                    @click="router.visit(route('testimonials.index'))"
                />
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        Create testimonial
                    </h2>
                    <p class="mt-1 text-slate-600 dark:text-slate-400">
                        Featured testimonials appear in the home carousel; all published testimonials appear on About.
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
                                <InputLabel for="quote" value="Quote" />
                                <Textarea
                                    id="quote"
                                    v-model="form.quote"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.quote }"
                                    rows="6"
                                    required
                                    autofocus
                                />
                                <InputError :message="form.errors.quote" />
                            </div>
                            <div>
                                <InputLabel for="author" value="Author" />
                                <InputText
                                    id="author"
                                    v-model="form.author"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.author }"
                                    required
                                />
                                <InputError :message="form.errors.author" />
                            </div>
                            <div>
                                <InputLabel for="role" value="Role / label" />
                                <InputText
                                    id="role"
                                    v-model="form.role"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.role }"
                                    required
                                />
                                <InputError :message="form.errors.role" />
                            </div>
                            <div>
                                <InputLabel for="initials" value="Initials (optional — auto from author if empty)" />
                                <InputText
                                    id="initials"
                                    v-model="form.initials"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.initials }"
                                    maxlength="20"
                                />
                                <InputError :message="form.errors.initials" />
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
                                <Checkbox v-model="form.is_featured" input-id="is_featured" binary />
                                <InputLabel for="is_featured" value="Featured on home (carousel)" class="mb-0" />
                            </div>
                            <InputError :message="form.errors.is_featured" />
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
                                <Button type="submit" label="Create" :loading="form.processing" />
                                <Button
                                    type="button"
                                    label="Cancel"
                                    severity="secondary"
                                    @click="router.visit(route('testimonials.index'))"
                                />
                            </div>
                        </form>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
