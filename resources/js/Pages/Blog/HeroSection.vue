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
        style="min-height: 40vh;"
        aria-labelledby="blog-hero-heading"
    >
        <div class="absolute inset-0" aria-hidden="true">
            <img
                :src="hero.image"
                alt=""
                class="w-full h-full object-cover object-center"
                loading="eager"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-espresso/85 via-espresso/60 to-espresso/30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-espresso/50 via-transparent to-transparent"></div>
        </div>

        <div
            class="absolute right-0 top-1/2 -translate-y-1/2 w-[500px] h-[500px] rounded-full opacity-10 pointer-events-none"
            style="background: radial-gradient(circle, #A74B1A 0%, transparent 70%);"
            aria-hidden="true"
        ></div>

        <div
            class="absolute left-1/4 bottom-0 w-[300px] h-[300px] rounded-full opacity-5 pointer-events-none"
            style="background: radial-gradient(circle, #CE7815 0%, transparent 70%);"
            aria-hidden="true"
        ></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-16">
            <div class="max-w-2xl">
                <p class="blog-hero-eyebrow section-eyebrow mb-4" aria-hidden="true">
                    {{ hero.eyebrow }}
                </p>

                <h1
                    id="blog-hero-heading"
                    class="blog-hero-title font-display font-bold text-neutral-50 leading-tight mb-5"
                    style="font-size: clamp(2rem, 4vw, 2.8rem); line-height: 1.15;"
                    v-html="hero.titleHtml"
                ></h1>

                <p
                    class="blog-hero-subtitle text-base sm:text-lg text-white/70 leading-relaxed max-w-xl"
                    style="font-size: clamp(0.95rem, 1.8vw, 1.1rem);"
                >
                    {{ hero.subtitle }}
                </p>

                <div class="blog-hero-pills mt-6 flex flex-wrap gap-2">
                    <span
                        v-for="(pill, pi) in hero.pills"
                        :key="pi"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-white/10 text-white/70 border border-white/20"
                    >
                        <span :class="['w-1.5 h-1.5 rounded-full shrink-0', pill.dotClass]" aria-hidden="true"></span>
                        {{ pill.label }}
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>
