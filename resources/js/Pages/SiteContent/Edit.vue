<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import { computed } from 'vue';

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
    intro: {
        type: String,
        default: '',
    },
});

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

function submit() {
    form.put(route('site-content.update', props.document));
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
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                        {{ label }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                        {{ fieldCount }} text fields · Photos and links stay as they are on the site
                    </p>
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

                <form class="space-y-8" @submit.prevent="submit">
                    <Card v-for="section in sections" :key="section.key">
                        <template #title>
                            <span class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                {{ section.title }}
                            </span>
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
