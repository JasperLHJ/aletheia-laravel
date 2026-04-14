<script setup>
defineProps({
    why: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <section
        id="why-aletheia"
        class="bg-espresso py-20 sm:py-28 relative overflow-hidden"
        aria-labelledby="why-heading"
    >
        <!-- Subtle grid texture only — no repeated orbs -->
        <div
            class="absolute inset-0 pointer-events-none opacity-[0.03]"
            style="background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 48px 48px;"
            aria-hidden="true"
        ></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Editorial header — left-aligned, not centred -->
            <div class="max-w-xl mb-14 sm:mb-16">
                <p class="text-xs font-sans font-medium text-gold uppercase tracking-widest mb-3">
                    {{ why.eyebrow }}
                </p>
                <h2
                    id="why-heading"
                    class="font-display font-bold text-neutral-50 mb-4"
                    style="font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;"
                >
                    {{ why.heading }}
                </h2>
            </div>

            <!-- Editorial layout: standout card (pastoral) + supporting grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 lg:gap-6">

                <!-- Hero feature — spans 5 cols, taller, leads with the most human differentiator -->
                <div
                    class="why-card lg:col-span-5 relative bg-white/8 border border-white/10 rounded-2xl p-7 sm:p-9 flex flex-col justify-between overflow-hidden"
                >
                    <!-- Large decorative quote mark -->
                    <span
                        class="absolute top-4 right-6 font-display text-[8rem] leading-none text-white/5 select-none pointer-events-none"
                        aria-hidden="true"
                    >"</span>

                    <div>
                        <div
                            :class="['w-12 h-12 rounded-xl flex items-center justify-center mb-6', why.features[5].iconBg]"
                        >
                            <span class="text-white" v-html="why.features[5].icon"></span>
                        </div>

                        <blockquote class="font-display font-semibold text-neutral-50 mb-4" style="font-size: clamp(1.2rem, 2vw, 1.5rem); line-height: 1.35;">
                            "{{ why.features[5].title }}"
                        </blockquote>

                        <p class="text-sm text-white/60 leading-relaxed">
                            {{ why.features[5].body }}
                        </p>
                    </div>

                    <!-- Inline stat: class size proof -->
                    <div class="mt-8 pt-6 border-t border-white/10 flex items-baseline gap-3">
                        <span class="font-display font-bold text-gold" style="font-size: 2rem;">{{ why.stats[2].value }}</span>
                        <span class="text-xs text-white/50 uppercase tracking-wider leading-tight">{{ why.stats[2].label }}</span>
                    </div>
                </div>

                <!-- Right column: 2×2 grid of supporting features -->
                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-5 lg:gap-6">
                    <div
                        v-for="(feature, i) in why.features.slice(0, 4)"
                        :key="feature.title"
                        class="why-card group relative bg-white/5 border border-white/10 rounded-2xl p-6 hover:bg-white/10 hover:border-white/20 transition-all duration-300"
                    >
                        <div
                            :class="['w-10 h-10 rounded-xl flex items-center justify-center mb-4 transition-transform duration-300 group-hover:scale-110', feature.iconBg]"
                        >
                            <span class="text-white" v-html="feature.icon"></span>
                        </div>

                        <h3
                            class="font-display font-semibold text-neutral-50 mb-2"
                            style="font-size: 1.05rem; line-height: 1.3;"
                        >
                            {{ feature.title }}
                        </h3>

                        <p class="text-sm text-white/55 leading-relaxed">
                            {{ feature.body }}
                        </p>

                        <!-- Inline proof stat for university counselling card -->
                        <p
                            v-if="i === 3"
                            class="mt-3 text-xs font-semibold text-gold"
                        >{{ why.stats[1].value }} {{ why.stats[1].label }}</p>
                    </div>
                </div>

                <!-- Full-width bottom card: University Counselling with 75+ years stat -->
                <div
                    class="why-card lg:col-span-12 relative bg-white/5 border border-white/10 rounded-2xl p-6 sm:p-7 flex flex-col sm:flex-row sm:items-center gap-6 hover:bg-white/10 hover:border-white/20 transition-all duration-300 overflow-hidden"
                >
                    <div
                        :class="['w-12 h-12 rounded-xl flex items-center justify-center shrink-0', why.features[4].iconBg]"
                    >
                        <span class="text-white" v-html="why.features[4].icon"></span>
                    </div>

                    <div class="flex-1 min-w-0">
                        <h3
                            class="font-display font-semibold text-neutral-50 mb-1"
                            style="font-size: 1.1rem; line-height: 1.3;"
                        >
                            {{ why.features[4].title }}
                        </h3>
                        <p class="text-sm text-white/55 leading-relaxed">{{ why.features[4].body }}</p>
                    </div>

                    <!-- Inline stats: years of excellence + CCAs -->
                    <div class="flex gap-8 sm:gap-10 shrink-0 sm:border-l sm:border-white/10 sm:pl-8">
                        <div class="text-center sm:text-left">
                            <p class="font-display font-bold text-gold" style="font-size: 1.6rem;">{{ why.stats[0].value }}</p>
                            <p class="text-xs text-white/50 uppercase tracking-wider mt-0.5">{{ why.stats[0].label }}</p>
                        </div>
                        <div class="text-center sm:text-left">
                            <p class="font-display font-bold text-gold" style="font-size: 1.6rem;">{{ why.stats[3].value }}</p>
                            <p class="text-xs text-white/50 uppercase tracking-wider mt-0.5">{{ why.stats[3].label }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
