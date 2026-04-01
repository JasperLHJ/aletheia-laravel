<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
    icon: {
        type: String,
        default: null,
    },
});

const classes = computed(() =>
    props.active
        ? 'flex items-center gap-3 rounded-xl bg-blue-500/15 px-4 py-3 text-sm font-medium text-white ring-1 ring-blue-400/30'
        : 'flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <i
            v-if="icon"
            :class="[icon, 'text-lg opacity-90 shrink-0']"
            aria-hidden="true"
        />
        <span><slot /></span>
    </Link>
</template>
