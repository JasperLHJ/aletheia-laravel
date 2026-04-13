<template>
    <Link :href="route" class="block">
        <Card :href="linkRoute" class="h-full transition hover:shadow-md">
            <template #header>
                <div class="flex items-center gap-3 p-4">
                    <span
                        class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10"
                    >
                        <i :class="icon" class="text-2xl text-primary"></i>
                    </span>
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-slate-100">
                            {{ title }}
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ description }}
                        </p>
                    </div>
                </div>
            </template>
        </Card>
    </Link>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: String,
    description: { type: String, default: 'No description' },
    icon: { type: String, default: 'pi pi-tags' },
    route: { type: String, required: true },
});

const linkRoute = computed(() => {
    return route(props.route);
});
</script>
