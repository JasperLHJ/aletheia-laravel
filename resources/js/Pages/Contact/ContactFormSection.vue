<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    formContent: {
        type: Object,
        required: true,
    },
});

const submitted = ref(false);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    year_level: '',
    message: '',
});

function submit() {
    form.post(route('contact.send'), {
        preserveScroll: true,
        onSuccess: () => {
            submitted.value = true;
            form.reset();
        },
    });
}

function resetForm() {
    submitted.value = false;
    form.reset();
    form.clearErrors();
}
</script>

<template>
    <section
        id="contact-form-section"
        class="bg-purple-gray-50 py-16 sm:py-24"
        aria-labelledby="contact-form-heading"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 lg:gap-16 items-start max-w-6xl mx-auto">

                <!-- Left: Sidebar copy -->
                <div class="lg:col-span-2 lg:sticky lg:top-28">
                    <p class="text-xs font-sans font-medium uppercase tracking-widest text-purple-gray-400 mb-3" aria-hidden="true">
                        {{ formContent.sidebarEyebrow }}
                    </p>
                    <h2
                        id="contact-form-heading"
                        class="font-display font-bold text-purple-gray-800 mb-4"
                        style="font-size: clamp(1.6rem, 3vw, 2.2rem);"
                    >
                        {{ formContent.heading }}
                    </h2>
                    <p class="text-purple-gray-600 text-sm sm:text-base leading-relaxed mb-8" v-html="formContent.introHtml"></p>

                    <div class="space-y-4">
                        <div
                            v-for="(item, ti) in formContent.trust"
                            :key="ti"
                            class="flex items-start gap-3"
                        >
                            <div class="flex-shrink-0 mt-0.5 w-8 h-8 rounded-full bg-purple-gray-800/10 flex items-center justify-center">
                                <svg
                                    v-if="ti === 0"
                                    class="w-4 h-4 text-purple-gray-800"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg
                                    v-else-if="ti === 1"
                                    class="w-4 h-4 text-purple-gray-800"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                <svg
                                    v-else
                                    class="w-4 h-4 text-purple-gray-800"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-purple-gray-700">{{ item.title }}</p>
                                <p v-if="item.body" class="text-xs text-purple-gray-500 mt-0.5">{{ item.body }}</p>
                                <a
                                    v-if="item.whatsappHref"
                                    :href="item.whatsappHref"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="text-xs text-purple-gray-400 hover:text-purple-gray-600 font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-purple-gray-500 rounded-sm mt-0.5 inline-block"
                                >
                                    {{ item.whatsappText }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Form -->
                <div class="lg:col-span-3">

                    <!-- Success state -->
                    <div
                        v-if="submitted"
                        class="flex flex-col items-center text-center py-16 px-8 rounded-2xl bg-white border border-purple-gray-200 shadow-sm"
                        role="alert"
                        aria-live="polite"
                    >
                        <div class="w-16 h-16 rounded-full bg-sage/20 flex items-center justify-center mb-5">
                            <svg class="w-8 h-8 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-purple-gray-800 text-xl mb-2">{{ formContent.successTitle }}</h3>
                        <p class="text-purple-gray-600 text-sm leading-relaxed max-w-sm mb-6">
                            {{ formContent.successBody }}
                        </p>
                        <button
                            type="button"
                            class="btn-primary text-sm px-5 py-2.5"
                            @click="resetForm"
                        >
                            {{ formContent.sendAnother }}
                        </button>
                    </div>

                    <!-- Form -->
                    <form
                        v-else
                        novalidate
                        class="bg-white rounded-2xl border border-purple-gray-200 shadow-sm p-7 sm:p-10 space-y-6"
                        aria-label="Contact enquiry form"
                        @submit.prevent="submit"
                    >
                        <!-- General error banner -->
                        <div
                            v-if="form.hasErrors"
                            class="flex items-start gap-3 p-4 rounded-xl bg-crimson/5 border border-crimson/20 text-sm text-crimson"
                            role="alert"
                            aria-live="assertive"
                        >
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <p>{{ formContent.generalError }}</p>
                        </div>

                        <!-- Row: Name + Email -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Name -->
                            <div>
                                <label
                                    for="contact-name"
                                    class="block text-sm font-medium text-purple-gray-700 mb-1.5"
                                >
                                    {{ formContent.labels.name }} <span class="text-crimson" aria-label="required">*</span>
                                </label>
                                <input
                                    id="contact-name"
                                    v-model="form.name"
                                    type="text"
                                    name="name"
                                    autocomplete="name"
                                    :placeholder="formContent.placeholders.name"
                                    required
                                    :aria-invalid="!!form.errors.name"
                                    :aria-describedby="form.errors.name ? 'name-error' : undefined"
                                    class="block w-full rounded-lg border px-4 py-3 text-sm text-purple-gray-800 placeholder-purple-gray-400 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-purple-gray-500 focus:border-transparent min-h-[44px]"
                                    :class="form.errors.name
                                        ? 'border-crimson bg-crimson/5'
                                        : 'border-purple-gray-300 bg-white hover:border-purple-gray-400'"
                                />
                                <p
                                    v-if="form.errors.name"
                                    id="name-error"
                                    role="alert"
                                    class="mt-1.5 text-xs text-crimson"
                                >
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label
                                    for="contact-email"
                                    class="block text-sm font-medium text-purple-gray-700 mb-1.5"
                                >
                                    {{ formContent.labels.email }} <span class="text-crimson" aria-label="required">*</span>
                                </label>
                                <input
                                    id="contact-email"
                                    v-model="form.email"
                                    type="email"
                                    name="email"
                                    autocomplete="email"
                                    :placeholder="formContent.placeholders.email"
                                    required
                                    :aria-invalid="!!form.errors.email"
                                    :aria-describedby="form.errors.email ? 'email-error' : undefined"
                                    class="block w-full rounded-lg border px-4 py-3 text-sm text-purple-gray-800 placeholder-purple-gray-400 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-purple-gray-500 focus:border-transparent min-h-[44px]"
                                    :class="form.errors.email
                                        ? 'border-crimson bg-crimson/5'
                                        : 'border-purple-gray-300 bg-white hover:border-purple-gray-400'"
                                />
                                <p
                                    v-if="form.errors.email"
                                    id="email-error"
                                    role="alert"
                                    class="mt-1.5 text-xs text-crimson"
                                >
                                    {{ form.errors.email }}
                                </p>
                            </div>
                        </div>

                        <!-- Row: Phone + Year Level -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Phone -->
                            <div>
                                <label
                                    for="contact-phone"
                                    class="block text-sm font-medium text-purple-gray-700 mb-1.5"
                                >
                                    {{ formContent.labels.phone }}
                                    <span class="text-purple-gray-400 font-normal text-xs ml-1">{{ formContent.labels.phoneOptional }}</span>
                                </label>
                                <input
                                    id="contact-phone"
                                    v-model="form.phone"
                                    type="tel"
                                    name="phone"
                                    autocomplete="tel"
                                    :placeholder="formContent.placeholders.phone"
                                    :aria-invalid="!!form.errors.phone"
                                    :aria-describedby="form.errors.phone ? 'phone-error' : undefined"
                                    class="block w-full rounded-lg border px-4 py-3 text-sm text-purple-gray-800 placeholder-purple-gray-400 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-purple-gray-500 focus:border-transparent min-h-[44px]"
                                    :class="form.errors.phone
                                        ? 'border-crimson bg-crimson/5'
                                        : 'border-purple-gray-300 bg-white hover:border-purple-gray-400'"
                                />
                                <p
                                    v-if="form.errors.phone"
                                    id="phone-error"
                                    role="alert"
                                    class="mt-1.5 text-xs text-crimson"
                                >
                                    {{ form.errors.phone }}
                                </p>
                            </div>

                            <!-- Year Level -->
                            <div>
                                <label
                                    for="contact-year-level"
                                    class="block text-sm font-medium text-purple-gray-700 mb-1.5"
                                >
                                    {{ formContent.labels.yearLevel }}
                                    <span class="text-purple-gray-400 font-normal text-xs ml-1">{{ formContent.labels.yearLevelOptional }}</span>
                                </label>
                                <select
                                    id="contact-year-level"
                                    v-model="form.year_level"
                                    name="year_level"
                                    :aria-invalid="!!form.errors.year_level"
                                    :aria-describedby="form.errors.year_level ? 'year-level-error' : undefined"
                                    class="select-field"
                                    :class="form.errors.year_level
                                        ? 'border-crimson bg-crimson/5'
                                        : 'border-purple-gray-300 bg-white hover:border-purple-gray-400'"
                                >
                                    <option value="" disabled>{{ formContent.placeholders.yearLevel }}</option>
                                    <option
                                        v-for="level in formContent.yearLevels"
                                        :key="level"
                                        :value="level"
                                    >
                                        {{ level }}
                                    </option>
                                </select>
                                <p
                                    v-if="form.errors.year_level"
                                    id="year-level-error"
                                    role="alert"
                                    class="mt-1.5 text-xs text-crimson"
                                >
                                    {{ form.errors.year_level }}
                                </p>
                            </div>
                        </div>

                        <!-- Message -->
                        <div>
                            <label
                                for="contact-message"
                                class="block text-sm font-medium text-purple-gray-700 mb-1.5"
                            >
                                {{ formContent.labels.message }} <span class="text-crimson" aria-label="required">*</span>
                            </label>
                            <textarea
                                id="contact-message"
                                v-model="form.message"
                                name="message"
                                rows="5"
                                :placeholder="formContent.placeholders.message"
                                required
                                :aria-invalid="!!form.errors.message"
                                :aria-describedby="form.errors.message ? 'message-error' : undefined"
                                class="block w-full rounded-lg border px-4 py-3 text-sm text-purple-gray-800 placeholder-purple-gray-400 resize-y transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-purple-gray-500 focus:border-transparent"
                                :class="form.errors.message
                                    ? 'border-crimson bg-crimson/5'
                                    : 'border-purple-gray-300 bg-white hover:border-purple-gray-400'"
                            ></textarea>
                            <p
                                v-if="form.errors.message"
                                id="message-error"
                                role="alert"
                                class="mt-1.5 text-xs text-crimson"
                            >
                                {{ form.errors.message }}
                            </p>
                        </div>

                        <!-- Submit -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-2">
                            <p class="text-xs text-purple-gray-400 leading-relaxed max-w-xs" v-html="formContent.privacyHtml"></p>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="btn-cta min-w-[160px] relative"
                                :aria-label="form.processing ? formContent.submitAriaSending : formContent.submitAriaIdle"
                            >
                                <span v-if="form.processing" class="flex items-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    {{ formContent.submitting }}
                                </span>
                                <span v-else class="flex items-center gap-2">
                                    {{ formContent.submit }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                </span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.select-field {
    display: block;
    width: 100%;
    border-radius: 0.5rem;
    border-width: 1px;
    padding: 0.75rem 2.5rem 0.75rem 1rem;
    font-size: 0.875rem;
    color: #27262b;
    min-height: 44px;
    appearance: none;
    transition: border-color 150ms, background-color 150ms;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 20px;
}

.select-field:focus {
    outline: none;
    border-color: transparent;
    box-shadow: 0 0 0 2px #63616e;
}
</style>
