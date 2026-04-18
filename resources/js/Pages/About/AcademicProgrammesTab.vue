<script setup>
import { computed } from 'vue';

const props = defineProps({
    content: {
        type: Object,
        required: true,
    },
});

const programmes = computed(() => props.content.programmes ?? []);

const hoverBgClasses = {
    'bg-sage': 'group-hover:bg-sage',
    'bg-ember': 'group-hover:bg-ember',
    'bg-gold': 'group-hover:bg-gold',
    'bg-crimson': 'group-hover:bg-crimson',
    'bg-espresso': 'group-hover:bg-espresso',
};
</script>

<template>
    <div>
        <!-- Intro — left-aligned -->
        <div class="max-w-2xl mb-10 sm:mb-14">
            <p class="text-xs font-sans font-medium text-ember uppercase tracking-widest mb-3">
                {{ content.introEyebrow }}
            </p>
            <h3
                class="font-display font-semibold text-espresso mb-4"
                style="font-size: clamp(1.6rem, 2.8vw, 2.1rem); line-height: 1.2;"
            >
                {{ content.introHeading }}
            </h3>
            <p class="text-neutral-600 leading-relaxed max-w-xl">
                {{ content.introBody }}
            </p>
        </div>

        <!-- Empty state -->
        <p v-if="!programmes.length" class="text-neutral-500 text-sm py-10">
            No programmes are currently listed. Please check back soon.
        </p>

        <!-- Programme navigation list -->
        <div v-else class="divide-y divide-neutral-200">
            <a
                v-for="(programme, index) in programmes"
                :key="programme.title"
                :href="programme.href"
                class="flex items-start gap-5 sm:gap-8 py-6 sm:py-8 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-espresso focus-visible:ring-offset-2 rounded-sm"
            >
                <!-- Ordinal — accent colour, faded at rest -->
                <span
                    class="font-display font-bold shrink-0 leading-none select-none transition-opacity duration-300"
                    :class="[programme.accentText, 'opacity-25 group-hover:opacity-100']"
                    style="font-size: clamp(1.75rem, 3.5vw, 2.75rem);"
                    aria-hidden="true"
                >{{ String(index + 1).padStart(2, '0') }}</span>

                <!-- Title + description -->
                <div class="flex-1 min-w-0 pt-0.5">
                    <p class="text-xs font-sans font-medium text-neutral-500 uppercase tracking-widest mb-1.5">
                        {{ programme.eyebrow }}
                    </p>
                    <h4
                        class="font-display font-bold text-espresso group-hover:text-espresso/80 transition-colors duration-200"
                        style="font-size: clamp(1.1rem, 2vw, 1.35rem); line-height: 1.25;"
                    >{{ programme.title }}</h4>
                    <p class="text-sm text-neutral-500 mt-1.5 leading-relaxed">
                        {{ programme.description }}
                    </p>
                    <p class="text-xs text-neutral-400 mt-2 font-sans">
                        Full details on the Programmes page
                    </p>
                </div>

                <!-- Navigation arrow -->
                <span
                    class="shrink-0 mt-1 w-8 h-8 rounded-full border border-neutral-200 flex items-center justify-center text-neutral-400 transition-all duration-300 group-hover:border-transparent group-hover:text-white"
                    :class="hoverBgClasses[programme.accentColor]"
                    aria-hidden="true"
                >
                    <svg
                        class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-0.5"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </a>
        </div>

        <!-- Full programmes page link -->
        <div class="mt-10 sm:mt-12">
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
    </div>
</template>
