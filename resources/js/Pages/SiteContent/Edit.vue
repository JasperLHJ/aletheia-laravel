<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import { computed, reactive, ref } from 'vue';

const props = defineProps({
    document: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    sections: {
        type: Array,
        required: true,
    },
    imageSections: {
        type: Array,
        default: () => [],
    },
    intro: {
        type: String,
        default: '',
    },
    pageUrl: {
        type: String,
        default: null,
    },
    albums: {
        type: Array,
        default: null,
    },
});

const page = usePage();

const initialFields = {};
for (const section of props.sections) {
    for (const field of section.fields) {
        initialFields[field.path] = field.value ?? '';
    }
}

const form = useForm({
    fields: initialFields,
});

const fieldCount = computed(() =>
    props.sections.reduce((n, s) => n + s.fields.length, 0),
);

const imageCount = computed(() =>
    props.imageSections.reduce((n, s) => n + s.fields.length, 0),
);

function submit() {
    form.put(route('site-content.update', props.document));
}

// Image upload state keyed by field path
const imagePreviews = reactive({});
const imageUploading = reactive({});
const imageErrors = reactive({});

// Initialise previews from current field values
for (const section of props.imageSections) {
    for (const field of section.fields) {
        imagePreviews[field.path] = field.value ?? null;
    }
}

const fileInputRefs = ref({});

function triggerFileInput(path) {
    fileInputRefs.value[path]?.click();
}

async function handleImageChange(path, event) {
    const file = event.target.files?.[0];
    if (!file) return;

    imageErrors[path] = null;
    imageUploading[path] = true;

    const formData = new FormData();
    formData.append('path', path);
    formData.append('file', file);
    formData.append('_method', 'POST');

    try {
        const response = await fetch(route('site-content.images.store', props.document), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': page.props.csrf_token,
                'Accept': 'application/json',
            },
            body: formData,
        });

        if (!response.ok) {
            const data = await response.json().catch(() => ({}));
            throw new Error(data?.message ?? `Upload failed (${response.status})`);
        }

        const data = await response.json();
        imagePreviews[path] = data.url;
    } catch (err) {
        imageErrors[path] = err.message ?? 'Upload failed. Please try again.';
    } finally {
        imageUploading[path] = false;
        // Reset input so the same file can be re-selected after an error
        event.target.value = '';
    }
}

// ── Gallery album management ─────────────────────────────────────────────────
const albumList = ref(props.albums ? [...props.albums] : []);
const albumForm = reactive({ albumUrl: '', title: '' });
const albumAdding = ref(false);
const albumAddError = ref(null);
const albumDeleteLoading = reactive({});
const albumDeleteErrors = reactive({});

async function addAlbum() {
    albumAddError.value = null;
    albumAdding.value = true;

    try {
        const response = await fetch(route('gallery.albums.store'), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': page.props.csrf_token,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ albumUrl: albumForm.albumUrl, title: albumForm.title }),
        });

        const data = await response.json().catch(() => ({}));

        if (!response.ok) {
            throw new Error(data?.message ?? `Failed (${response.status})`);
        }

        albumList.value.push(data.album);
        albumForm.albumUrl = '';
        albumForm.title = '';
    } catch (err) {
        albumAddError.value = err.message ?? 'Something went wrong. Please try again.';
    } finally {
        albumAdding.value = false;
    }
}

async function deleteAlbum(index) {
    albumDeleteErrors[index] = null;
    albumDeleteLoading[index] = true;

    try {
        const response = await fetch(route('gallery.albums.destroy', index), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': page.props.csrf_token,
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            const data = await response.json().catch(() => ({}));
            throw new Error(data?.message ?? `Failed (${response.status})`);
        }

        albumList.value.splice(index, 1);
    } catch (err) {
        albumDeleteErrors[index] = err.message ?? 'Could not remove album. Try again.';
    } finally {
        albumDeleteLoading[index] = false;
    }
}
</script>

<template>
    <Head :title="`Site content: ${label}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center gap-4">
                <Button
                    icon="pi pi-arrow-left"
                    text
                    rounded
                    aria-label="Back to site content"
                    @click="router.visit(route('site-content.index'))"
                />
                <div class="flex flex-1 flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                            {{ label }}
                        </h2>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                            {{ fieldCount }} text field{{ fieldCount !== 1 ? 's' : '' }}
                            <template v-if="imageCount > 0">
                                · {{ imageCount }} image{{ imageCount !== 1 ? 's' : '' }}
                            </template>
                        </p>
                    </div>
                    <a
                        v-if="pageUrl"
                        :href="pageUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-violet-700 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:text-violet-300"
                    >
                        <i class="pi pi-external-link text-xs" aria-hidden="true" />
                        View page
                    </a>
                </div>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-3xl space-y-8">
                <p
                    v-if="intro"
                    class="rounded-xl border border-slate-200/90 bg-white/80 px-4 py-3 text-sm leading-relaxed text-slate-600 shadow-sm dark:border-slate-600/60 dark:bg-slate-900/40 dark:text-slate-300"
                >
                    {{ intro }}
                </p>

                <!-- Gallery album manager (gallery document only) -->
                <template v-if="document === 'gallery' && albums !== null">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Photo Albums</span>
                        <div class="h-px flex-1 bg-slate-200 dark:bg-slate-700" />
                    </div>

                    <Card>
                        <template #title>
                            <span class="text-lg font-semibold text-slate-900 dark:text-slate-100">Google Photos Albums</span>
                            <p class="mt-1 text-sm font-normal text-slate-500 dark:text-slate-400">
                                Paste a public Google Photos shared album link. The cover image is fetched automatically.
                            </p>
                        </template>
                        <template #content>
                            <!-- Add album form -->
                            <div class="space-y-4 mb-8">
                                <div class="grid gap-3 sm:grid-cols-[1fr_auto] sm:items-end">
                                    <div class="space-y-2">
                                        <InputLabel value="Album title" for="album-title" />
                                        <InputText
                                            id="album-title"
                                            v-model="albumForm.title"
                                            placeholder="e.g. Sports Day 2025"
                                            class="w-full"
                                            :disabled="albumAdding"
                                        />
                                    </div>
                                    <div class="space-y-2">
                                        <InputLabel value="Google Photos URL" for="album-url" />
                                        <InputText
                                            id="album-url"
                                            v-model="albumForm.albumUrl"
                                            placeholder="https://photos.app.goo.gl/…"
                                            class="w-full sm:w-80"
                                            :disabled="albumAdding"
                                        />
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <Button
                                        type="button"
                                        label="Add Album"
                                        icon="pi pi-plus"
                                        :loading="albumAdding"
                                        :disabled="albumAdding || !albumForm.albumUrl.trim() || !albumForm.title.trim()"
                                        @click="addAlbum"
                                    />
                                    <p v-if="albumAdding" class="text-sm text-slate-500 dark:text-slate-400">
                                        Fetching cover image…
                                    </p>
                                </div>
                                <p v-if="albumAddError" class="text-sm text-red-600 dark:text-red-400">
                                    {{ albumAddError }}
                                </p>
                            </div>

                            <!-- Album list -->
                            <div v-if="albumList.length > 0" class="space-y-3">
                                <div
                                    v-for="(album, index) in albumList"
                                    :key="album.albumUrl + index"
                                    class="flex items-center gap-4 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800/50"
                                >
                                    <img
                                        :src="album.coverUrl"
                                        :alt="album.alt || album.title"
                                        class="h-16 w-24 shrink-0 rounded-lg object-cover border border-slate-200 dark:border-slate-700"
                                    />
                                    <div class="min-w-0 flex-1">
                                        <p class="font-medium text-sm text-slate-900 dark:text-slate-100 truncate">{{ album.title }}</p>
                                        <a
                                            :href="album.albumUrl"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-xs text-violet-600 hover:underline dark:text-violet-400 truncate block max-w-xs"
                                        >
                                            {{ album.albumUrl }}
                                        </a>
                                        <p v-if="albumDeleteErrors[index]" class="text-xs text-red-600 dark:text-red-400 mt-1">
                                            {{ albumDeleteErrors[index] }}
                                        </p>
                                    </div>
                                    <Button
                                        type="button"
                                        icon="pi pi-trash"
                                        severity="danger"
                                        text
                                        rounded
                                        :loading="albumDeleteLoading[index]"
                                        :disabled="albumDeleteLoading[index]"
                                        aria-label="Remove album"
                                        @click="deleteAlbum(index)"
                                    />
                                </div>
                            </div>
                            <p v-else class="text-sm text-slate-400 dark:text-slate-500 italic">
                                No albums added yet.
                            </p>
                        </template>
                    </Card>
                </template>

                <!-- Image upload section -->
                <template v-if="imageSections.length > 0">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Images</span>
                        <div class="h-px flex-1 bg-slate-200 dark:bg-slate-700" />
                    </div>

                    <Card v-for="section in imageSections" :key="`img-${section.key}`">
                        <template #title>
                            <div>
                                <span class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                    {{ section.title }}
                                </span>
                                <p
                                    v-if="section.description"
                                    class="mt-1 text-sm font-normal text-slate-500 dark:text-slate-400"
                                >
                                    {{ section.description }}
                                </p>
                            </div>
                        </template>
                        <template #content>
                            <div class="space-y-8">
                                <div v-for="field in section.fields" :key="field.path" class="space-y-3">
                                    <InputLabel :value="field.label" />

                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                                        <!-- Preview -->
                                        <div class="relative h-36 w-full shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-slate-100 sm:w-56 dark:border-slate-700 dark:bg-slate-800">
                                            <img
                                                v-if="imagePreviews[field.path]"
                                                :src="imagePreviews[field.path]"
                                                :alt="field.label"
                                                class="h-full w-full object-cover"
                                            />
                                            <div
                                                v-else
                                                class="flex h-full w-full items-center justify-center"
                                            >
                                                <i class="pi pi-image text-3xl text-slate-300 dark:text-slate-600" aria-hidden="true" />
                                            </div>
                                            <!-- Upload overlay spinner -->
                                            <div
                                                v-if="imageUploading[field.path]"
                                                class="absolute inset-0 flex items-center justify-center bg-white/70 dark:bg-slate-900/70"
                                            >
                                                <i class="pi pi-spin pi-spinner text-2xl text-violet-600" aria-hidden="true" />
                                            </div>
                                        </div>

                                        <div class="flex flex-col gap-2">
                                            <Button
                                                type="button"
                                                :label="imageUploading[field.path] ? 'Uploading…' : 'Replace image'"
                                                icon="pi pi-upload"
                                                severity="secondary"
                                                :loading="imageUploading[field.path]"
                                                :disabled="imageUploading[field.path]"
                                                @click="triggerFileInput(field.path)"
                                            />
                                            <p class="text-xs text-slate-400 dark:text-slate-500">
                                                JPG, PNG, WebP or GIF · max 5 MB
                                            </p>
                                            <p
                                                v-if="imagePreviews[field.path]"
                                                class="break-all text-xs text-slate-500 dark:text-slate-400"
                                            >
                                                {{ imagePreviews[field.path] }}
                                            </p>
                                            <p
                                                v-if="imageErrors[field.path]"
                                                class="text-xs text-red-600 dark:text-red-400"
                                            >
                                                {{ imageErrors[field.path] }}
                                            </p>
                                        </div>
                                    </div>

                                    <input
                                        :ref="el => { if (el) fileInputRefs[field.path] = el }"
                                        type="file"
                                        accept="image/*"
                                        class="sr-only"
                                        :aria-label="`Upload image for ${field.label}`"
                                        @change="handleImageChange(field.path, $event)"
                                    />
                                </div>
                            </div>
                        </template>
                    </Card>

                    <div class="flex items-center gap-3">
                        <span class="text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Text</span>
                        <div class="h-px flex-1 bg-slate-200 dark:bg-slate-700" />
                    </div>
                </template>

                <!-- Text fields form -->
                <form class="space-y-8" @submit.prevent="submit">
                    <Card v-for="section in sections" :key="section.key">
                        <template #title>
                            <div>
                                <span class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                    {{ section.title }}
                                </span>
                                <p
                                    v-if="section.description"
                                    class="mt-1 text-sm font-normal text-slate-500 dark:text-slate-400"
                                >
                                    {{ section.description }}
                                </p>
                            </div>
                        </template>
                        <template #content>
                            <div class="space-y-6">
                                <div v-for="field in section.fields" :key="field.path" class="space-y-2">
                                    <InputLabel :for="`field-${field.path}`" :value="field.label" />
                                    <p
                                        v-if="field.help"
                                        class="text-xs text-slate-500 dark:text-slate-400"
                                    >
                                        {{ field.help }}
                                    </p>
                                    <InputText
                                        v-if="field.control === 'text'"
                                        :id="`field-${field.path}`"
                                        v-model="form.fields[field.path]"
                                        class="w-full"
                                        :class="{ 'p-invalid': form.errors[`fields.${field.path}`] }"
                                        :aria-invalid="!!form.errors[`fields.${field.path}`]"
                                    />
                                    <Textarea
                                        v-else
                                        :id="`field-${field.path}`"
                                        v-model="form.fields[field.path]"
                                        class="w-full text-sm leading-relaxed"
                                        :class="{ 'p-invalid': form.errors[`fields.${field.path}`] }"
                                        :aria-invalid="!!form.errors[`fields.${field.path}`]"
                                        rows="4"
                                        auto-resize
                                    />
                                    <InputError
                                        :message="form.errors[`fields.${field.path}`]"
                                    />
                                </div>
                            </div>
                        </template>
                    </Card>

                    <InputError :message="form.errors.fields" />

                    <div class="flex flex-wrap gap-3 pb-12">
                        <Button
                            type="submit"
                            label="Save changes"
                            icon="pi pi-check"
                            :loading="form.processing"
                            :disabled="form.processing"
                        />
                        <Button
                            type="button"
                            label="Cancel"
                            severity="secondary"
                            text
                            @click="router.visit(route('site-content.index'))"
                        />
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
