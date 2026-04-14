<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    content: {
        type: Object,
        required: true,
    },
});

const programmes = computed(() => props.content.programmes);

const activeDialogIndex = ref(null);

function openDialog(index) {
    activeDialogIndex.value = index;
    document.body.style.overflow = 'hidden';
}

function closeDialog() {
    activeDialogIndex.value = null;
    document.body.style.overflow = '';
}

function handleBackdropClick(event) {
    if (event.target === event.currentTarget) closeDialog();
}

function handleDialogKeydown(event) {
    if (event.key === 'Escape') closeDialog();
}
</script>

<template>
    <div>
        <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
            <p class="text-xs font-sans font-medium text-ember uppercase tracking-widest mb-3">
                {{ content.introEyebrow }}
            </p>
            <h3
                class="font-display font-semibold text-espresso mb-4"
                style="font-size: clamp(1.6rem, 2.8vw, 2.1rem); line-height: 1.2;"
            >
                {{ content.introHeading }}
            </h3>
            <p class="text-neutral-600 leading-relaxed">
                {{ content.introBody }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-7">
            <article
                v-for="(programme, index) in programmes"
                :key="programme.title"
                tabindex="0"
                role="button"
                class="programme-card group relative bg-white rounded-2xl overflow-hidden border border-neutral-200/90 shadow-sm flex flex-col cursor-pointer outline-none transition-[transform,box-shadow,border-color,ring-color] duration-300 ease-out hover:-translate-y-1 hover:shadow-xl hover:border-transparent hover:ring-2 hover:ring-offset-2 hover:ring-offset-white focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-espresso focus-visible:ring-offset-white"
                :class="programme.hoverRing"
                @click="openDialog(index)"
                @keydown.enter.prevent="openDialog(index)"
                @keydown.space.prevent="openDialog(index)"
                :aria-label="`View full details for ${programme.title}`"
            >
                <!-- Accent bar -->
                <div :class="[programme.accentColor, 'h-1 w-full shrink-0']" aria-hidden="true"></div>

                <div class="p-6 sm:p-7 flex flex-col flex-1">
                    <!-- Icon + eyebrow -->
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            :class="[programme.accentColor, 'w-11 h-11 rounded-xl flex items-center justify-center text-white shrink-0 transition-transform duration-300 group-hover:scale-105']"
                            v-html="programme.icon"
                        ></div>
                        <p class="text-xs font-sans font-semibold text-neutral-500 uppercase tracking-widest">
                            {{ programme.eyebrow }}
                        </p>
                    </div>

                    <h4
                        class="font-display font-bold text-espresso mb-2.5"
                        style="font-size: 1.25rem; line-height: 1.3;"
                    >
                        {{ programme.title }}
                    </h4>

                    <p class="text-sm text-neutral-600 leading-relaxed flex-1 mb-4">
                        {{ programme.description }}
                    </p>

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2 mb-5">
                        <span
                            v-for="tag in programme.highlights"
                            :key="tag"
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-neutral-100 text-neutral-700"
                        >
                            {{ tag }}
                        </span>
                    </div>

                    <!-- Bottom CTA label -->
                    <div
                        class="mt-auto pt-4 border-t border-neutral-100 flex items-center justify-between gap-3 transition-colors duration-300 group-hover:border-neutral-200/80"
                    >
                        <span
                            :class="['text-sm font-semibold font-sans tracking-tight', programme.accentText]"
                        >
                            {{ content.viewDetailsCta }}
                        </span>
                        <span
                            class="inline-flex items-center justify-center rounded-full p-1.5 text-neutral-400 transition-all duration-300 group-hover:text-current"
                            :class="programme.accentText"
                            aria-hidden="true"
                        >
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </div>
            </article>
        </div>

        <!-- View Full Programmes Page link -->
        <div class="mt-10 text-center">
            <a
                :href="content.fullPageLink.href"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-espresso/20 text-sm font-semibold font-sans text-espresso hover:bg-espresso hover:text-cream-50 hover:border-espresso transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson focus-visible:ring-offset-2 min-h-[44px]"
            >
                {{ content.fullPageLink.label }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- Dialogs -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition-opacity duration-200 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-150 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="activeDialogIndex !== null"
                    class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center p-3 sm:p-6 pb-[max(0.75rem,env(safe-area-inset-bottom))]"
                    style="background-color: rgba(0,0,0,0.55); backdrop-filter: blur(2px);"
                    @click="handleBackdropClick"
                    @keydown="handleDialogKeydown"
                    tabindex="-1"
                    role="dialog"
                    aria-modal="true"
                    :aria-labelledby="`dialog-title-${activeDialogIndex}`"
                >
                    <Transition
                        enter-active-class="transition-all duration-250 ease-out"
                        enter-from-class="opacity-0 translate-y-4 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="transition-all duration-150 ease-in"
                        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-4 sm:scale-95"
                        appear
                    >
                        <div
                            v-if="activeDialogIndex !== null"
                            class="bg-white w-full sm:max-w-2xl rounded-2xl sm:rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[min(90dvh,calc(100vh-1.5rem))] sm:max-h-[min(85vh,calc(100vh-3rem))]"
                        >
                            <!-- Dialog Header -->
                            <div :class="[programmes[activeDialogIndex].accentColor, 'px-6 sm:px-8 pt-6 sm:pt-7 pb-4 sm:pb-5 shrink-0']">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-11 h-11 rounded-xl bg-white/20 flex items-center justify-center text-white shrink-0"
                                            v-html="programmes[activeDialogIndex].icon"
                                        ></div>
                                        <div>
                                            <p class="text-xs font-sans font-semibold text-white/75 uppercase tracking-widest mb-0.5">
                                                {{ programmes[activeDialogIndex].eyebrow }}
                                            </p>
                                            <h4
                                                :id="`dialog-title-${activeDialogIndex}`"
                                                class="font-display font-bold text-white"
                                                style="font-size: 1.35rem; line-height: 1.25;"
                                            >
                                                {{ programmes[activeDialogIndex].title }}
                                            </h4>
                                        </div>
                                    </div>
                                    <button
                                        class="shrink-0 w-9 h-9 rounded-full bg-white/15 hover:bg-white/25 flex items-center justify-center text-white transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white"
                                        @click="closeDialog"
                                        :aria-label="content.dialog.closeDialogAria"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Dialog Body (scrollable) -->
                            <div class="overflow-y-auto flex-1 min-h-0 overscroll-contain px-6 sm:px-8 py-5 sm:py-6 space-y-5 sm:space-y-6">
                                <!-- Overview -->
                                <div class="space-y-0">
                                    <p class="text-neutral-700 leading-relaxed text-[0.9375rem] sm:text-base">
                                        {{ programmes[activeDialogIndex].detail.overview }}
                                    </p>
                                </div>

                                <!-- Subjects -->
                                <div class="space-y-3 sm:space-y-4">
                                    <h5 class="font-display font-semibold text-espresso" style="font-size: 1.05rem;">
                                        {{ content.dialog.curriculumAreasHeading }}
                                    </h5>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-3.5">
                                        <div
                                            v-for="item in programmes[activeDialogIndex].detail.curriculum"
                                            :key="item.subject"
                                            class="flex gap-3 p-3.5 sm:p-4 bg-neutral-50 rounded-xl border border-neutral-100"
                                        >
                                            <div :class="[programmes[activeDialogIndex].accentColor, 'w-1.5 rounded-full shrink-0 mt-0.5']" aria-hidden="true"></div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold font-sans text-espresso mb-0.5">{{ item.subject }}</p>
                                                <p class="text-xs text-neutral-600 leading-relaxed">{{ item.desc }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Assessment -->
                                <div class="bg-neutral-50 rounded-xl border border-neutral-100 p-4 sm:p-5 space-y-2">
                                    <h5 class="font-display font-semibold text-espresso" style="font-size: 1rem;">
                                        {{ content.dialog.assessmentHeading }}
                                    </h5>
                                    <p class="text-sm text-neutral-600 leading-relaxed">
                                        {{ programmes[activeDialogIndex].detail.assessment }}
                                    </p>
                                </div>

                                <!-- Outcomes -->
                                <div class="space-y-3 sm:space-y-4 pb-1">
                                    <h5 class="font-display font-semibold text-espresso" style="font-size: 1.05rem;">
                                        {{ content.dialog.outcomesHeading }}
                                    </h5>
                                    <ul class="space-y-2 sm:space-y-2.5" role="list">
                                        <li
                                            v-for="outcome in programmes[activeDialogIndex].detail.outcomes"
                                            :key="outcome"
                                            class="flex items-start gap-3 text-sm text-neutral-700"
                                        >
                                            <span :class="[programmes[activeDialogIndex].accentColor, 'w-5 h-5 rounded-full flex items-center justify-center text-white shrink-0 mt-0.5']" aria-hidden="true">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                            {{ outcome }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Dialog Footer -->
                            <div class="px-6 sm:px-8 py-4 sm:py-5 border-t border-neutral-100 bg-neutral-50 flex flex-col sm:flex-row sm:items-center sm:justify-center gap-2.5 sm:gap-3 shrink-0">
                                <a
                                    href="#enquiry"
                                    class="btn-cta w-full sm:w-auto text-center"
                                    @click="closeDialog"
                                >
                                    {{ content.dialog.enquireCta }}
                                </a>
                                <button
                                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-neutral-300 text-sm font-semibold font-sans text-neutral-700 hover:bg-neutral-100 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-espresso focus-visible:ring-offset-2"
                                    @click="closeDialog"
                                >
                                    {{ content.dialog.close }}
                                </button>
                            </div>
                        </div>
                    </Transition>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
