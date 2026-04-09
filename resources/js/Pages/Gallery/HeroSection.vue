<template>
    <section
        class="relative flex items-center bg-espresso overflow-hidden"
        style="min-height: 40vh;"
        aria-labelledby="gallery-hero-heading"
    >
        <div class="absolute inset-0" aria-hidden="true">
            <img
                src="/images/class-4.jpg"
                alt=""
                class="w-full h-full object-cover object-center"
                loading="eager"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-espresso/85 via-espresso/60 to-espresso/30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-espresso/50 via-transparent to-transparent"></div>
        </div>

        <!-- Decorative radial glow -->
        <div
            class="absolute right-0 top-1/2 -translate-y-1/2 w-[500px] h-[500px] rounded-full opacity-10 pointer-events-none"
            style="background: radial-gradient(circle, #CE7815 0%, transparent 70%);"
            aria-hidden="true"
        ></div>

        <!-- Decorative scattered dots -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute top-16 right-1/3 w-1.5 h-1.5 rounded-full bg-gold/30"></div>
            <div class="absolute top-1/3 right-1/4 w-1 h-1 rounded-full bg-gold/20"></div>
            <div class="absolute bottom-1/4 right-1/2 w-2 h-2 rounded-full bg-ember/20"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-16">
            <div class="max-w-2xl">
                <p class="gallery-hero-eyebrow section-eyebrow mb-4" aria-hidden="true">
                    School Life
                </p>

                <h1
                    id="gallery-hero-heading"
                    class="gallery-hero-title font-display font-bold text-neutral-50 leading-tight mb-5"
                    style="font-size: clamp(2rem, 4vw, 2.8rem); line-height: 1.15;"
                >
                    A Window into Our <em class="text-gold not-italic">World</em>
                </h1>

                <p
                    class="gallery-hero-subtitle text-base sm:text-lg text-white/70 leading-relaxed max-w-xl"
                    style="font-size: clamp(0.95rem, 1.8vw, 1.1rem);"
                >
                    Explore the vibrant life at Aletheia Resource Center — from the energy of our classrooms
                    and sports fields to the warmth of community events and our world-class facilities.
                </p>
            </div>
        </div>
    </section>
</template>
