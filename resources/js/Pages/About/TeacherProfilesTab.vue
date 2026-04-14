<script setup>
import { ref } from 'vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';

defineProps({
    copy: {
        type: Object,
        required: true,
    },
    principal: {
        type: Object,
        default: null,
    },
    teachers: {
        type: Array,
        default: () => [],
    },
});

const dialogVisible = ref(false);
const activeEducator = ref(null);

function openEducator(profile) {
    activeEducator.value = profile;
    dialogVisible.value = true;
}

function onDialogAfterHide() {
    activeEducator.value = null;
}
</script>

<template>
    <div>
        <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-xs font-sans font-medium text-ember uppercase tracking-widest mb-3">
                {{ copy.introEyebrow }}
            </p>
            <h3
                class="font-display font-semibold text-espresso mb-4"
                style="font-size: clamp(1.6rem, 2.8vw, 2.1rem); line-height: 1.2;"
            >
                {{ copy.introHeading }}
            </h3>
            <p class="text-neutral-600 leading-relaxed">
                {{ copy.introBody }}
            </p>
        </div>

        <!-- Principal Spotlight -->
        <article
            v-if="principal"
            class="teacher-card bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden mb-8"
        >
            <div class="flex flex-col md:flex-row">
                <div class="md:w-2/5 lg:w-1/3 relative">
                    <img
                        v-if="principal.image"
                        :src="principal.image"
                        :alt="`Portrait of ${principal.name}`"
                        class="w-full h-64 md:h-full object-cover"
                        loading="lazy"
                    />
                    <div
                        v-else
                        class="flex h-64 w-full items-center justify-center bg-neutral-200 text-sm text-neutral-500 md:h-full md:min-h-[20rem]"
                    >
                        {{ copy.noPhoto }}
                    </div>
                    <div
                        v-if="principal.image"
                        class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-espresso/40 to-transparent"
                        aria-hidden="true"
                    ></div>
                </div>
                <div class="flex-1 p-8 sm:p-10 border-t-4 md:border-t-0 md:border-l-4 border-gold flex flex-col justify-center">
                    <p class="text-xs font-sans font-semibold text-gold uppercase tracking-widest mb-2">
                        {{ principal.title }}
                    </p>
                    <h4
                        class="font-display font-bold text-espresso mb-4"
                        style="font-size: 1.5rem; line-height: 1.25;"
                    >
                        {{ principal.name }}
                    </h4>
                    <p class="text-base text-neutral-600 leading-relaxed mb-6">
                        {{ principal.bio }}
                    </p>
                    <div>
                        <Button
                            type="button"
                            :label="copy.fullProfile"
                            icon="pi pi-arrow-right"
                            iconPos="right"
                            severity="secondary"
                            outlined
                            class="text-espresso border-espresso/30 hover:bg-espresso/5"
                            @click="openEducator(principal)"
                        />
                    </div>
                </div>
            </div>
        </article>

        <!-- Teacher Grid -->
        <div
            v-if="teachers.length"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6"
        >
            <article
                v-for="teacher in teachers"
                :key="teacher.id"
                class="teacher-card group bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col"
            >
                <div class="relative h-48 overflow-hidden shrink-0">
                    <img
                        v-if="teacher.image"
                        :src="teacher.image"
                        :alt="`Portrait of ${teacher.name}`"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy"
                    />
                    <div
                        v-else
                        class="flex h-full w-full items-center justify-center bg-neutral-200 text-sm text-neutral-500"
                    >
                        {{ copy.noPhoto }}
                    </div>
                    <div
                        v-if="teacher.image"
                        class="absolute inset-0 bg-gradient-to-t from-espresso/50 to-transparent"
                        aria-hidden="true"
                    ></div>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <p class="text-xs font-sans font-semibold text-ember uppercase tracking-widest mb-1.5">
                        {{ teacher.title }}
                    </p>
                    <h4
                        class="font-display font-semibold text-espresso mb-3"
                        style="font-size: 1.15rem; line-height: 1.3;"
                    >
                        {{ teacher.name }}
                    </h4>
                    <p class="text-sm text-neutral-600 leading-relaxed flex-1 mb-5">
                        {{ teacher.bio }}
                    </p>
                    <div class="mt-auto">
                        <Button
                            type="button"
                            :label="copy.fullProfile"
                            icon="pi pi-arrow-right"
                            iconPos="right"
                            severity="secondary"
                            outlined
                            size="small"
                            class="w-full sm:w-auto text-espresso border-espresso/30 hover:bg-espresso/5"
                            @click="openEducator(teacher)"
                        />
                    </div>
                </div>
            </article>
        </div>
        <p
            v-else-if="!principal"
            class="text-center text-neutral-600 max-w-xl mx-auto"
        >
            Educator profiles will appear here when they are published in the CMS.
        </p>
        <p
            v-else
            class="text-center text-neutral-600 max-w-xl mx-auto"
        >
            More teacher profiles will appear here when they are published in the CMS.
        </p>

        <Dialog
            v-model:visible="dialogVisible"
            modal
            dismissableMask
            :draggable="false"
            :show-header="false"
            :block-scroll="true"
            content-class="!p-0 !overflow-hidden"
            :style="{ width: 'min(60rem, calc(100vw - 2rem))' }"
            :breakpoints="{ '768px': '95vw' }"
            @after-hide="onDialogAfterHide"
        >
            <div v-if="activeEducator" class="educator-dialog flex flex-col md:flex-row bg-white text-left rounded-[14px] overflow-hidden" role="dialog" aria-modal="true" :aria-labelledby="'educator-dialog-title'">

                <!-- Left: Image Panel -->
                <div class="relative md:w-2/5 shrink-0 overflow-hidden bg-espresso">
                    <img
                        v-if="activeEducator.image"
                        :src="activeEducator.image"
                        :alt="`Portrait of ${activeEducator.name}`"
                        class="w-full h-56 md:h-full object-cover opacity-90"
                    />
                    <div
                        v-else
                        class="flex h-56 w-full items-center justify-center bg-espresso/40 text-sm text-white/80 md:h-full md:min-h-[20rem]"
                    >
                        {{ copy.noPhoto }}
                    </div>
                    <!-- Scrim so name badge reads cleanly over any photo -->
                    <div
                        v-if="activeEducator.image"
                        class="absolute inset-0 bg-gradient-to-t from-espresso/80 via-espresso/20 to-transparent"
                        aria-hidden="true"
                    ></div>

                    <!-- Name badge anchored to bottom of image panel -->
                    <div class="absolute bottom-0 left-0 right-0 px-7 pb-7 pt-12">
                        <span class="inline-block text-[0.65rem] font-sans font-semibold text-gold-light uppercase tracking-[0.14em] mb-2">
                            {{ activeEducator.title }}
                        </span>
                        <h2
                            id="educator-dialog-title"
                            class="font-display font-bold text-white leading-tight"
                            style="font-size: clamp(1.25rem, 3vw, 1.6rem);"
                        >
                            {{ activeEducator.name }}
                        </h2>
                    </div>
                </div>

                <!-- Right: Content Panel -->
                <div class="relative flex flex-col flex-1 bg-neutral-50">

                    <!-- Close button -->
                    <button
                        type="button"
                        class="absolute right-4 top-4 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white text-neutral-500 shadow-sm ring-1 ring-neutral-200 transition hover:bg-neutral-100 hover:text-espresso focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2"
                        aria-label="Close dialog"
                        @click="dialogVisible = false"
                    >
                        <i class="pi pi-times text-xs" aria-hidden="true"></i>
                    </button>

                    <div class="flex flex-col flex-1 px-7 pt-7 pb-8 sm:px-9 sm:pt-8 sm:pb-9 overflow-y-auto">

                        <!-- Bio -->
                        <div class="mb-5">
                            <p class="text-[0.65rem] font-sans font-semibold text-ember uppercase tracking-[0.14em] mb-3">
                                About
                            </p>
                            <p class="text-neutral-700 leading-relaxed text-sm sm:text-[0.95rem]">
                                {{ activeEducator.bio }}
                            </p>
                        </div>

                        <!-- Divider -->
                        <div class="w-10 h-px bg-gold/50 my-1 mb-5" aria-hidden="true"></div>

                        <!-- Detail -->
                        <div>
                            <p class="text-[0.65rem] font-sans font-semibold text-ember uppercase tracking-[0.14em] mb-3">
                                Responsibilities &amp; Focus
                            </p>
                            <p class="text-neutral-600 leading-relaxed text-sm sm:text-[0.95rem]">
                                {{ activeEducator.detail }}
                            </p>
                        </div>

                        <!-- Footer action -->
                        <div class="mt-auto pt-8 flex justify-end">
                            <button
                                type="button"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-sans font-medium bg-espresso text-white shadow-sm transition hover:bg-espresso-light focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2"
                                @click="dialogVisible = false"
                            >
                                Close
                                <i class="pi pi-times text-xs" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Dialog>
    </div>
</template>
