<script setup>
defineProps({
    hero: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <section
        class="relative flex items-center bg-espresso overflow-hidden"
        style="min-height: 60vh;"
        aria-labelledby="programmes-hero-heading"
    >
        <div class="absolute inset-0" aria-hidden="true">
            <img
                :src="hero.image"
                alt=""
                class="w-full h-full object-cover object-center"
                loading="eager"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-espresso/90 via-espresso/65 to-espresso/30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-espresso/60 via-transparent to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20">
            <div class="max-w-3xl">
                <p class="programmes-hero-eyebrow section-eyebrow mb-4" aria-hidden="true">
                    {{ hero.eyebrow }}
                </p>

                <h1
                    id="programmes-hero-heading"
                    class="programmes-hero-title font-display font-bold text-neutral-50 mb-6"
                    style="font-size: clamp(2.2rem, 4.5vw, 3.2rem); line-height: 1.1;"
                >
                    {{ hero.titleLine1 }}
                    <em class="text-gold not-italic block sm:inline"> {{ hero.titleEmphasis }}</em>
                </h1>

                <p
                    class="programmes-hero-subtitle text-white/70 leading-relaxed max-w-2xl mb-8"
                    style="font-size: clamp(1rem, 1.8vw, 1.15rem);"
                >
                    {{ hero.subtitle }}
                </p>

                <div class="programmes-hero-ctas flex flex-wrap gap-3 sm:gap-4">
                    <a :href="hero.primaryCta.href" class="btn-cta">
                        {{ hero.primaryCta.label }}
                    </a>
                    <a
                        :href="hero.secondaryCta.href"
                        class="btn-ghost-light"
                    >
                        {{ hero.secondaryCta.label }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                </div>

                <div class="programmes-hero-pills flex flex-wrap gap-2 mt-10">
                    <span class="text-xs text-white/40 uppercase tracking-widest self-center mr-1">{{ hero.jumpToLabel }}</span>
                    <a
                        v-for="(pill, pi) in hero.pills"
                        :key="pi"
                        :href="pill.href"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-white/10 text-white/70 hover:text-white border border-white/10 transition-all duration-200"
                        :class="[
                            pi === 0 ? 'hover:bg-sage/30 hover:border-sage/50' : '',
                            pi === 1 ? 'hover:bg-ember/30 hover:border-ember/50' : '',
                            pi === 2 ? 'hover:bg-gold/30 hover:border-gold/50' : '',
                        ]"
                    >
                        <span :class="['w-2 h-2 rounded-full shrink-0', pill.dotClass]" aria-hidden="true"></span>
                        {{ pill.label }}
                    </a>
                </div>
            </div>
        </div>

        <div
            class="programmes-scroll-indicator absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1.5"
            aria-hidden="true"
        >
            <span class="text-white/30 text-xs tracking-widest uppercase">{{ hero.scrollLabel }}</span>
            <div class="w-px h-8 bg-gradient-to-b from-white/30 to-transparent"></div>
        </div>
    </section>
</template>
