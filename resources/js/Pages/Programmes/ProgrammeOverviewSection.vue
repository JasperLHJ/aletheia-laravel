<script setup>
defineProps({
    overview: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <section
        id="programme-overview"
        class="bg-neutral-50 py-20 sm:py-28"
        aria-labelledby="overview-heading"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Left-aligned header with contrast to other centred sections -->
            <div class="max-w-2xl mb-14">
                <p class="text-xs font-sans font-medium text-ember uppercase tracking-widest mb-3">
                    {{ overview.eyebrow }}
                </p>
                <h2
                    id="overview-heading"
                    class="font-display font-semibold text-espresso mb-4"
                    style="font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;"
                >
                    {{ overview.heading }}
                </h2>
                <p class="text-neutral-600 leading-relaxed">
                    {{ overview.intro }}
                </p>
            </div>

            <!-- Programme cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mb-14">
                <article
                    v-for="programme in overview.programmes"
                    :key="programme.title"
                    class="programme-overview-card group bg-white rounded-2xl overflow-hidden border border-neutral-200/90 shadow-sm flex flex-col transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-xl hover:border-transparent"
                    :class="programme.hoverRing"
                >
                    <!-- Top accent bar -->
                    <div :class="[programme.accentBg, 'h-1.5 w-full shrink-0']" aria-hidden="true"></div>

                    <!-- Image area -->
                    <div class="relative h-44 overflow-hidden">
                        <img
                            :src="programme.image"
                            :alt="programme.imageAlt"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                        />
                        <div
                            class="absolute inset-0"
                            :style="`background: linear-gradient(to top, ${programme.overlayColor}cc 0%, transparent 55%);`"
                            aria-hidden="true"
                        ></div>
                        <!-- Age badge -->
                        <div class="absolute bottom-3 left-4">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold text-white"
                                :style="`background-color: ${programme.overlayColor}; opacity: 0.92;`"
                            >
                                {{ programme.eyebrow }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 sm:p-7 flex flex-col flex-1">
                        <div class="flex items-start gap-3 mb-3">
                            <div
                                :class="[programme.accentBg, 'w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 transition-transform duration-300 group-hover:scale-110']"
                                v-html="programme.icon"
                            ></div>
                            <h3
                                class="font-display font-bold text-espresso pt-1"
                                style="font-size: 1.2rem; line-height: 1.25;"
                            >
                                {{ programme.title }}
                            </h3>
                        </div>

                        <p class="text-sm text-neutral-600 leading-relaxed flex-1 mb-4">
                            {{ programme.description }}
                        </p>

                        <!-- Highlights -->
                        <div class="flex flex-wrap gap-1.5 mb-5">
                            <span
                                v-for="tag in programme.highlights"
                                :key="tag"
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-neutral-100 text-neutral-700"
                            >
                                {{ tag }}
                            </span>
                        </div>

                        <div class="mt-auto pt-4 border-t border-neutral-100">
                            <a
                                :href="programme.anchor"
                                :class="['flex items-center justify-between text-sm font-semibold font-sans transition-colors duration-200', programme.accentText]"
                                :aria-label="`Explore the ${programme.title}`"
                            >
                                {{ overview.exploreLabel }}
                                <span
                                    :class="['flex items-center justify-center w-7 h-7 rounded-full transition-all duration-300 group-hover:translate-x-0.5', programme.accentBg]"
                                    aria-hidden="true"
                                >
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- At-a-glance comparison table -->
            <div class="bg-white rounded-2xl border border-neutral-200/90 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100">
                    <p class="text-xs font-sans font-semibold text-neutral-500 uppercase tracking-widest">
                        {{ overview.comparisonHeading }}
                    </p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm" role="table" :aria-label="overview.comparisonAriaLabel">
                        <thead>
                            <tr class="border-b border-neutral-100">
                                <th class="text-left px-6 py-3 text-xs font-semibold font-sans text-neutral-400 uppercase tracking-wider w-32" scope="col">
                                    {{ overview.comparisonRowLabel }}
                                </th>
                                <th
                                    v-for="col in overview.comparisonCols"
                                    :key="col.title"
                                    class="text-left px-6 py-3 text-xs font-semibold font-sans uppercase tracking-wider"
                                    :class="col.headingClass"
                                    scope="col"
                                >
                                    {{ col.title }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, ri) in overview.comparisonRows"
                                :key="row.label"
                                :class="ri % 2 === 0 ? 'bg-neutral-50/60' : 'bg-white'"
                            >
                                <td class="px-6 py-3 text-xs font-semibold font-sans text-neutral-500 uppercase tracking-wider whitespace-nowrap">
                                    {{ row.label }}
                                </td>
                                <td
                                    v-for="cell in row.cells"
                                    :key="cell"
                                    class="px-6 py-3 text-neutral-700 leading-snug"
                                >
                                    {{ cell }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>
