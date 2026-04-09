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
    post: Object,
});

function publishedAtLocal(iso) {
    if (!iso) return '';
    return String(iso).slice(0, 16);
}

const form = useForm({
    title: props.post.title,
    slug: props.post.slug,
    excerpt: props.post.excerpt ?? '',
    featured_image: props.post.featured_image ?? '',
    reading_time_minutes: props.post.reading_time_minutes ?? null,
    is_featured: !!props.post.is_featured,
    category: props.post.category ?? '',
    published_at: publishedAtLocal(props.post.published_at),
    body: props.post.body,
    status: props.post.status,
});

function submit() {
    form
        .transform((data) => ({
            ...data,
            published_at: data.published_at || null,
            reading_time_minutes: data.reading_time_minutes ?? null,
        }))
        .put(route('blogs.update', props.post.id));
}
</script>

<template>
    <Head :title="`Edit: ${post.title}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center gap-4">
                <Button
                    icon="pi pi-arrow-left"
                    text
                    rounded
                    aria-label="Back to blog"
                    @click="router.visit(route('blogs.index'))"
                />
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        Edit blog post
                    </h2>
                    <p class="mt-1 text-slate-600 dark:text-slate-400">
                        Body is rendered as HTML on the public site.
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
                                <InputLabel for="title" value="Title" />
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
                                <InputLabel for="slug" value="Slug" />
                                <InputText
                                    id="slug"
                                    v-model="form.slug"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.slug }"
                                />
                                <InputError :message="form.errors.slug" />
                            </div>
                            <div>
                                <InputLabel for="excerpt" value="Excerpt" />
                                <Textarea
                                    id="excerpt"
                                    v-model="form.excerpt"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.excerpt }"
                                    rows="3"
                                />
                                <InputError :message="form.errors.excerpt" />
                            </div>
                            <div>
                                <InputLabel for="featured_image" value="Featured image URL or path" />
                                <InputText
                                    id="featured_image"
                                    v-model="form.featured_image"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.featured_image }"
                                />
                                <InputError :message="form.errors.featured_image" />
                            </div>
                            <div>
                                <InputLabel for="reading_time_minutes" value="Reading time (minutes, optional)" />
                                <InputNumber
                                    id="reading_time_minutes"
                                    v-model="form.reading_time_minutes"
                                    class="mt-2 w-full"
                                    input-class="w-full"
                                    :min="1"
                                    :max="1440"
                                    :show-buttons="false"
                                    :class="{ 'p-invalid': form.errors.reading_time_minutes }"
                                />
                                <InputError :message="form.errors.reading_time_minutes" />
                            </div>
                            <div>
                                <InputLabel for="category" value="Category label" />
                                <InputText
                                    id="category"
                                    v-model="form.category"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.category }"
                                />
                                <InputError :message="form.errors.category" />
                            </div>
                            <div>
                                <InputLabel for="published_at" value="Publish date (optional)" />
                                <InputText
                                    id="published_at"
                                    v-model="form.published_at"
                                    type="datetime-local"
                                    class="mt-2 block w-full"
                                    :class="{ 'p-invalid': form.errors.published_at }"
                                />
                                <InputError :message="form.errors.published_at" />
                            </div>
                            <div class="flex items-center gap-2">
                                <Checkbox v-model="form.is_featured" input-id="is_featured" binary />
                                <InputLabel for="is_featured" value="Featured on blog home" class="mb-0" />
                            </div>
                            <InputError :message="form.errors.is_featured" />
                            <div>
                                <InputLabel for="body" value="Body (HTML)" />
                                <Textarea
                                    id="body"
                                    v-model="form.body"
                                    class="mt-2 block w-full font-mono text-sm"
                                    :class="{ 'p-invalid': form.errors.body }"
                                    rows="12"
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
                                    @click="router.visit(route('blogs.index'))"
                                />
                            </div>
                        </form>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
