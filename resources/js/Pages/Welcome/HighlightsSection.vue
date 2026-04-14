<script setup>
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
        class="bg-neutral-50 py-20 sm:py-28"
        aria-labelledby="highlights-heading"
    >
        <div id="highlights-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="section-eyebrow mb-3">{{ content.eyebrow }}</p>
                <h2
                    id="highlights-heading"
                    class="font-display font-semibold text-espresso mb-4"
                    style="font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;"
                >
                    {{ content.heading }}
                </h2>
                <p class="text-neutral-600 leading-relaxed">
                    {{ content.intro }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <article
                    v-for="card in content.cards"
                    :key="card.title"
                    class="highlight-card group bg-white rounded-xl overflow-hidden border border-neutral-200 shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col"
                >
                    <div class="relative h-48 overflow-hidden">
                        <img
                            :src="card.image"
                            :alt="card.imageAlt"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                        />
                        <div
                            class="absolute inset-0"
                            :style="`background: linear-gradient(to top, ${card.accentColor}cc 0%, transparent 60%);`"
                            aria-hidden="true"
                        ></div>
                    </div>

                    <div class="p-6 flex flex-col flex-1">
                        <p class="text-xs font-sans font-medium text-ember uppercase tracking-widest mb-2">
                            {{ card.eyebrow }}
                        </p>
                        <h3
                            class="font-display font-semibold text-espresso mb-3"
                            style="font-size: 1.25rem; line-height: 1.3;"
                        >
                            {{ card.title }}
                        </h3>
                        <p class="text-sm text-neutral-600 leading-relaxed flex-1">
                            {{ card.body }}
                        </p>
                    </div>

                    <div class="px-6 pb-5 border-t border-neutral-100 pt-4 flex items-center justify-between">
                        <a
                            href="#"
                            class="text-sm font-medium text-ember hover:text-ember-dark transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson rounded-sm"
                            :aria-label="`${card.linkText} — ${card.title}`"
                        >
                            {{ card.linkText }} →
                        </a>
                        <div class="w-2 h-2 rounded-full bg-sage" aria-hidden="true"></div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
