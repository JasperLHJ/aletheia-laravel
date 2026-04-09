<template>
    <section
        class="relative flex items-center bg-espresso overflow-hidden"
        style="min-height: 60vh;"
        aria-labelledby="programmes-hero-heading"
    >
        <!-- Background Image -->
        <div class="absolute inset-0" aria-hidden="true">
            <img
                src="/images/class-1.jpg"
                alt=""
                class="w-full h-full object-cover object-center"
                loading="eager"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-espresso/90 via-espresso/65 to-espresso/30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-espresso/60 via-transparent to-transparent"></div>
        </div>

        <!-- Decorative gold glow -->
        <div
            class="absolute right-0 top-1/2 -translate-y-1/2 w-[500px] h-[500px] rounded-full opacity-10 pointer-events-none"
            style="background: radial-gradient(circle, #CE7815 0%, transparent 70%);"
            aria-hidden="true"
        ></div>

        <!-- Decorative sage glow bottom-left -->
        <div
            class="absolute -left-24 bottom-0 w-[350px] h-[350px] rounded-full opacity-8 pointer-events-none"
            style="background: radial-gradient(circle, #95B91F 0%, transparent 70%); opacity: 0.06;"
            aria-hidden="true"
        ></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20">
            <div class="max-w-3xl">
                <!-- Eyebrow -->
                <p class="programmes-hero-eyebrow section-eyebrow mb-4" aria-hidden="true">
                    Our Academic Pathways
                </p>

                <!-- Heading -->
                <h1
                    id="programmes-hero-heading"
                    class="programmes-hero-title font-display font-bold text-neutral-50 mb-6"
                    style="font-size: clamp(2.2rem, 4.5vw, 3.2rem); line-height: 1.1;"
                >
                    Programmes Designed to
                    <em class="text-gold not-italic block sm:inline"> Ignite Potential</em>
                </h1>

                <!-- Subtitle -->
                <p
                    class="programmes-hero-subtitle text-white/70 leading-relaxed max-w-2xl mb-8"
                    style="font-size: clamp(1rem, 1.8vw, 1.15rem);"
                >
                    From primary through pre-university, our Cambridge-aligned curriculum nurtures
                    critical thinkers, confident communicators, and principled leaders ready for a
                    rapidly changing world.
                </p>

                <!-- CTAs -->
                <div class="programmes-hero-ctas flex flex-wrap gap-3 sm:gap-4">
                    <a href="/contact" class="btn-cta">
                        Enquire Now
                    </a>
                    <a
                        href="#programme-overview"
                        class="btn-ghost-light"
                    >
                        Explore Programmes
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                </div>

                <!-- Programme quick-nav pills -->
                <div class="programmes-hero-pills flex flex-wrap gap-2 mt-10">
                    <span class="text-xs text-white/40 uppercase tracking-widest self-center mr-1">Jump to:</span>
                    <a
                        href="#primary-programme"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-white/10 text-white/70 hover:bg-sage/30 hover:text-white border border-white/10 hover:border-sage/50 transition-all duration-200"
                    >
                        <span class="w-2 h-2 rounded-full bg-sage shrink-0" aria-hidden="true"></span>
                        Primary
                    </a>
                    <a
                        href="#secondary-programme"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-white/10 text-white/70 hover:bg-ember/30 hover:text-white border border-white/10 hover:border-ember/50 transition-all duration-200"
                    >
                        <span class="w-2 h-2 rounded-full bg-ember shrink-0" aria-hidden="true"></span>
                        Secondary
                    </a>
                    <a
                        href="#preuniversity-programme"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-white/10 text-white/70 hover:bg-gold/30 hover:text-white border border-white/10 hover:border-gold/50 transition-all duration-200"
                    >
                        <span class="w-2 h-2 rounded-full bg-gold shrink-0" aria-hidden="true"></span>
                        Pre-University
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div
            class="programmes-scroll-indicator absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1.5"
            aria-hidden="true"
        >
            <span class="text-white/30 text-xs tracking-widest uppercase">Scroll</span>
            <div class="w-px h-8 bg-gradient-to-b from-white/30 to-transparent"></div>
        </div>
    </section>
</template>
