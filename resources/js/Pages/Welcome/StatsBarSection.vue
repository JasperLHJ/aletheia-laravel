<script setup>
import { reactive, watch } from 'vue';

const props = defineProps({
    content: {
        type: Object,
        required: true,
    },
});

const display = reactive([]);

watch(
    () => props.content.items,
    (items) => {
        display.splice(0, display.length, ...items.map(() => ({ value: 0 })));
    },
    { immediate: true },
);

defineExpose({
    get stats() {
        return props.content.items;
    },
    display,
});
</script>

<template>
    <section
        id="stats-section"
        class="bg-purple-gray-100 border-y border-purple-gray-200"
        :aria-label="content.sectionAriaLabel"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-8 sm:gap-4 divide-y sm:divide-y-0 sm:divide-x divide-purple-gray-200">
                <div
                    v-for="(stat, i) in content.items"
                    :key="stat.label"
                    class="stat-item flex flex-col items-center text-center pt-8 sm:pt-0 first:pt-0 sm:px-8"
                >
                    <dt class="order-2 mt-2 text-sm font-sans font-medium text-purple-gray-600">
                        {{ stat.label }}
                        <span class="block text-xs text-purple-gray-500 mt-0.5 font-normal">{{ stat.description }}</span>
                    </dt>
                    <dd
                        class="order-1 font-display font-bold text-purple-gray-800 tabular-nums"
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
