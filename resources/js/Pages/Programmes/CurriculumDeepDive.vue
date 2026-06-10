<script setup>
import { ref } from 'vue';

defineProps({
    deepDive: {
        type: Object,
        required: true,
    },
});

const openSubjects = ref({});

function toggleSubject(key) {
    openSubjects.value[key] = !openSubjects.value[key];
}
</script>

<template>
    <section
        id="curriculum-deep-dive"
        class="bg-white py-20 sm:py-28"
        aria-labelledby="deepdive-heading"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section header -->
            <div class="text-center max-w-2xl mx-auto mb-16 sm:mb-20">
                <p class="text-xs font-sans font-medium text-purple-gray-500 uppercase tracking-widest mb-3">
                    {{ deepDive.eyebrow }}
                </p>
                <h2
                    id="deepdive-heading"
                    class="font-display font-semibold text-purple-gray-800 mb-4"
                    style="font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;"
                >
                    {{ deepDive.heading }}
                </h2>
                <p class="text-purple-gray-600 leading-relaxed">
                    {{ deepDive.intro }}
                </p>
            </div>

            <div class="space-y-24 sm:space-y-32">
                <div
                    v-for="(programme, index) in deepDive.programmes"
                    :key="programme.id"
                    :id="programme.id"
                    class="deepdive-row scroll-mt-24"
                >
                    <!-- ── Hero pair: image + intro ──────────────────── -->
                    <div
                        class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start"
                        :class="index % 2 === 0 ? '' : 'lg:[&>*:first-child]:order-2'"
                    >
                        <!-- Image column -->
                        <div
                            :class="[
                                'deepdive-image relative rounded-2xl overflow-hidden shadow-lg',
                                index % 2 === 0 ? 'deepdive-image-left' : 'deepdive-image-right',
                            ]"
                            style="aspect-ratio: 4/3;"
                        >
                            <img
                                :src="programme.image"
                                :alt="programme.imageAlt"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            />
                            <div
                                class="absolute inset-0"
                                :style="`background: linear-gradient(135deg, ${programme.overlayColor}33 0%, transparent 60%);`"
                                aria-hidden="true"
                            />
                            <!-- Qualification badge -->
                            <div class="absolute bottom-5 left-5 bg-white/95 backdrop-blur-sm rounded-xl px-4 py-3 shadow-lg max-w-[calc(100%-2.5rem)]">
                                <p class="text-xs text-purple-gray-500 font-sans mb-0.5">{{ deepDive.qualificationLabel }}</p>
                                <p :class="['font-display font-bold text-sm', programme.accentText]">{{ programme.qualification }}</p>
                                <p v-if="programme.qualificationNote" class="text-xs text-purple-gray-400 leading-snug mt-1">
                                    {{ programme.qualificationNote }}
                                </p>
                            </div>
                            <!-- Corner accent -->
                            <div
                                :class="['absolute top-0 right-0 w-20 h-20 rounded-bl-[3rem]', programme.accentBg]"
                                style="opacity: 0.15;"
                                aria-hidden="true"
                            />
                        </div>

                        <!-- Intro column -->
                        <div
                            :class="[
                                'deepdive-content pt-2 lg:pt-4',
                                index % 2 === 0 ? 'deepdive-content-right' : 'deepdive-content-left',
                            ]"
                        >
                            <div class="flex items-center gap-3 mb-5">
                                <span :class="['inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold text-white', programme.accentBg]">
                                    <span v-html="programme.icon" class="w-3.5 h-3.5" />
                                    {{ programme.eyebrow }}
                                </span>
                            </div>
                            <h3
                                class="font-display font-bold text-purple-gray-800 mb-4"
                                style="font-size: clamp(1.5rem, 2.5vw, 2rem); line-height: 1.2;"
                            >
                                {{ programme.title }}
                            </h3>
                            <p class="text-purple-gray-600 leading-relaxed text-base">
                                {{ programme.overview }}
                            </p>
                        </div>
                    </div>

                    <!-- ── Full-width curriculum detail ──────────────── -->
                    <div class="mt-10 lg:mt-12 pt-10 lg:pt-12 border-t border-purple-gray-100">
                        <div class="grid grid-cols-1 lg:grid-cols-[1fr_280px] gap-10 lg:gap-16 items-start">

                            <!-- Subjects accordion -->
                            <div>
                                <h4 class="text-xs font-sans font-semibold text-purple-gray-500 uppercase tracking-widest mb-5">
                                    {{ deepDive.curriculumHeading }}
                                </h4>
                                <div class="divide-y divide-purple-gray-100">
                                    <div
                                        v-for="(subject, sIndex) in programme.subjects"
                                        :key="subject.name"
                                    >
                                        <button
                                            type="button"
                                            class="w-full flex items-center justify-between gap-4 py-4 text-left cursor-pointer group"
                                            :aria-expanded="!!openSubjects[`${programme.id}-${sIndex}`]"
                                            @click="toggleSubject(`${programme.id}-${sIndex}`)"
                                        >
                                            <span class="flex items-center gap-3 min-w-0">
                                                <span
                                                    :class="['w-2 h-2 rounded-full shrink-0', programme.accentBg]"
                                                    aria-hidden="true"
                                                />
                                                <span class="text-sm font-semibold text-purple-gray-800 group-hover:text-purple-gray-900 transition-colors duration-150">
                                                    {{ subject.name }}
                                                </span>
                                            </span>
                                            <svg
                                                class="w-4 h-4 text-purple-gray-400 shrink-0 transition-transform duration-300 ease-out"
                                                :class="{ 'rotate-180': openSubjects[`${programme.id}-${sIndex}`] }"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                aria-hidden="true"
                                            >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <!-- Animated reveal via grid-template-rows (no layout property animation) -->
                                        <div
                                            class="grid transition-[grid-template-rows] duration-300 ease-out"
                                            :style="openSubjects[`${programme.id}-${sIndex}`] ? 'grid-template-rows: 1fr' : 'grid-template-rows: 0fr'"
                                        >
                                            <div class="overflow-hidden">
                                                <p class="text-sm text-purple-gray-600 leading-relaxed pb-5 pl-5">
                                                    {{ subject.desc }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Electives note — no border accent -->
                                <p v-if="programme.subjectNote" class="mt-5 text-xs text-purple-gray-500 leading-relaxed italic">
                                    * {{ programme.subjectNote }}
                                </p>
                            </div>

                            <!-- Outcomes + CTA -->
                            <div>
                                <h4 class="text-xs font-sans font-semibold text-purple-gray-500 uppercase tracking-widest mb-5">
                                    {{ deepDive.outcomesHeading }}
                                </h4>
                                <ul class="space-y-3 mb-8" role="list">
                                    <li
                                        v-for="outcome in programme.outcomes"
                                        :key="outcome"
                                        class="flex items-start gap-3 text-sm text-purple-gray-700 leading-snug"
                                    >
                                        <span
                                            :class="['w-5 h-5 rounded-full flex items-center justify-center text-white shrink-0 mt-0.5', programme.accentBg]"
                                            aria-hidden="true"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        {{ outcome }}
                                    </li>
                                </ul>
                                <a
                                    :href="programme.contactHref"
                                    :class="['inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:opacity-90 hover:-translate-y-0.5 shadow-md min-h-[44px]', programme.accentBg]"
                                >
                                    {{ deepDive.enquireCta }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>
