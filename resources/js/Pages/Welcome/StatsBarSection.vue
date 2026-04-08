<script setup>
import { reactive } from 'vue';

const stats = [
    { numericValue: 500, suffix: '+', label: 'Students Enrolled', description: 'Across all year levels' },
    { numericValue: 98, suffix: '%', label: 'University Placement', description: 'Class of 2025' },
    { numericValue: 60, suffix: '+', label: 'Co-curricular Clubs', description: 'Arts, sports & more' },
];

const display = reactive(stats.map(() => ({ value: 0 })));

defineExpose({ stats, display });
</script>

<template>
    <section
        id="stats-section"
        class="bg-neutral-100 border-y border-neutral-200"
        aria-label="School statistics"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-8 sm:gap-4 divide-y sm:divide-y-0 sm:divide-x divide-neutral-200">
                <div
                    v-for="(stat, i) in stats"
                    :key="stat.label"
                    class="stat-item flex flex-col items-center text-center pt-8 sm:pt-0 first:pt-0 sm:px-8"
                >
                    <dt class="order-2 mt-2 text-sm font-sans font-medium text-neutral-600">
                        {{ stat.label }}
                        <span class="block text-xs text-neutral-500 mt-0.5 font-normal">{{ stat.description }}</span>
                    </dt>
                    <dd
                        class="order-1 font-display font-bold text-espresso tabular-nums"
                        style="font-size: 2.75rem; line-height: 1;"
                        :aria-label="`${stat.numericValue}${stat.suffix} ${stat.label}`"
                    >
                        {{ Math.round(display[i].value) }}{{ stat.suffix }}
                    </dd>
                </div>
            </dl>
        </div>
    </section>
</template>
