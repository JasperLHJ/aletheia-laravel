<script setup>
import { computed, onMounted, ref } from 'vue';
import Button from 'primevue/button';
import { toggleTheme } from '@/utils/appearance';

const props = defineProps({
    /** Navy sidebar (light icon) vs guest pages (muted icon on gray bg) */
    tone: {
        type: String,
        default: 'sidebar',
        validator: (v) => ['sidebar', 'guest'].includes(v),
    },
});

const isDark = ref(false);

const toneClass = computed(() =>
    props.tone === 'guest'
        ? '!text-slate-600 hover:!bg-slate-200/90 dark:!text-slate-200 dark:hover:!bg-white/10'
        : '!text-slate-300 hover:!bg-white/10',
);

onMounted(() => {
    isDark.value = document.documentElement.classList.contains('dark');
});

function onClick() {
    toggleTheme();
    isDark.value = document.documentElement.classList.contains('dark');
}
</script>

<template>
    <Button
        type="button"
        :icon="isDark ? 'pi pi-sun' : 'pi pi-moon'"
        text
        rounded
        :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
        :class="toneClass"
        @click="onClick"
    />
</template>
