<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    content: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <section
        id="highlights"
        class="bg-neutral-50 py-14 sm:py-20"
        aria-labelledby="highlights-heading"
    >
        <div id="highlights-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 lg:mb-12">
                <p class="section-eyebrow mb-3">{{ content.eyebrow }}</p>
                <h2
                    id="highlights-heading"
                    class="font-display font-semibold text-espresso mb-4"
                    style="font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;"
                >
                    {{ content.heading }}
                </h2>
                <p class="text-neutral-600 leading-relaxed max-w-xl">
                    {{ content.intro }}
                </p>
            </div>

            <div class="border-t border-neutral-200 divide-y divide-neutral-200">
                <article
                    v-for="(card, index) in content.cards"
                    :key="card.title"
                    class="highlight-card grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 py-8 lg:py-10"
                >
                    <div
                        class="relative overflow-hidden rounded-lg aspect-[16/9] lg:aspect-auto lg:min-h-[300px]"
                        :class="index % 2 === 1 ? 'lg:order-2' : ''"
                    >
                        <img
                            :src="card.image"
                            :alt="card.imageAlt"
                            class="absolute inset-0 w-full h-full object-cover"
                            loading="lazy"
                        />
                        <div
                            class="absolute inset-0 pointer-events-none"
                            :style="`background: linear-gradient(to top, ${card.accentColor}cc 0%, transparent 55%);`"
                            aria-hidden="true"
                        ></div>
                    </div>

                    <div
                        class="flex flex-col justify-center"
                        :class="index % 2 === 1 ? 'lg:order-1' : ''"
                    >
                        <p
                            class="text-xs font-medium uppercase tracking-wider mb-4"
                            :style="`color: ${card.accentColor}`"
                        >
                            {{ card.eyebrow }}
                        </p>
                        <h3
                            class="font-display font-semibold text-espresso mb-4"
                            style="font-size: clamp(1.25rem, 2.2vw, 1.875rem); line-height: 1.25;"
                        >
                            {{ card.title }}
                        </h3>
                        <p class="text-neutral-600 leading-relaxed mb-6">
                            {{ card.body }}
                        </p>
                        <div v-if="card.href">
                            <Link
                                :href="card.href"
                                class="inline-flex items-center gap-2 text-sm font-medium text-ember hover:text-ember-dark transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson rounded-sm"
                                :aria-label="`${card.linkText} — ${card.title}`"
                            >
                                {{ card.linkText }}
                                <span aria-hidden="true">→</span>
                            </Link>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
