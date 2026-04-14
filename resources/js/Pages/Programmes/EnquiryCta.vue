<script setup>
defineProps({
    cta: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <section
        id="programmes-enquiry-cta"
        class="relative overflow-hidden py-20 sm:py-24"
        aria-labelledby="cta-heading"
        style="background-color: #1E0D08;"
    >
        <!-- Warm crimson bloom — top right, conversion energy -->
        <div
            class="absolute pointer-events-none"
            style="
                top: -10%; right: -5%;
                width: 55vw; max-width: 600px; height: 55vw; max-height: 600px;
                background: radial-gradient(ellipse at center, oklch(35% 0.18 10 / 0.28) 0%, transparent 65%);
            "
            aria-hidden="true"
        ></div>
        <!-- Gold warmth — bottom left, aspiration -->
        <div
            class="absolute pointer-events-none"
            style="
                bottom: -15%; left: -8%;
                width: 45vw; max-width: 500px; height: 45vw; max-height: 500px;
                background: radial-gradient(ellipse at center, oklch(55% 0.14 55 / 0.18) 0%, transparent 65%);
            "
            aria-hidden="true"
        ></div>
        <!-- Thin gold rule at top -->
        <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-gold/40 to-transparent" aria-hidden="true"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center cta-content">
            <p class="text-xs font-sans font-medium text-gold uppercase tracking-widest mb-4">
                {{ cta.eyebrow }}
            </p>

            <h2
                id="cta-heading"
                class="font-display font-bold text-neutral-50 mb-5"
                style="font-size: clamp(1.8rem, 3.5vw, 2.6rem); line-height: 1.15;"
            >
                {{ cta.titleLine1 }}
                <em class="text-gold not-italic"> {{ cta.titleEmphasis }}</em>
            </h2>

            <p class="text-white/75 leading-relaxed max-w-2xl mx-auto mb-10 text-base">
                {{ cta.body }}
            </p>

            <!-- Two primary CTAs only -->
            <div class="flex flex-wrap items-center justify-center gap-4 mb-8">
                <a
                    :href="cta.whatsapp.href"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:opacity-90 hover:-translate-y-0.5 shadow-lg min-h-[44px]"
                    style="background-color: #25D366;"
                    :aria-label="cta.whatsapp.ariaLabel"
                >
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    {{ cta.whatsapp.label }}
                </a>

                <a :href="cta.contact.href" class="btn-cta shadow-lg hover:-translate-y-0.5">
                    {{ cta.contact.label }}
                </a>
            </div>

            <!-- Secondary link — text only, not a full button -->
            <a
                :href="cta.about.href"
                class="inline-flex items-center gap-1.5 text-sm text-white/40 hover:text-white/70 transition-colors duration-200"
            >
                {{ cta.about.label }}
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- Trust indicators -->
            <div class="mt-10 pt-8 border-t border-white/10 flex flex-wrap items-center justify-center gap-6">
                <div
                    v-for="(line, ti) in cta.trust"
                    :key="ti"
                    class="flex items-center gap-2 text-white/40 text-xs"
                >
                    <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                    {{ line }}
                </div>
            </div>
        </div>
    </section>
</template>
