<template>
    <section
        class="relative flex items-center bg-espresso overflow-hidden"
        style="min-height: 40vh;"
        aria-labelledby="about-hero-heading"
    >
        <div class="absolute inset-0" aria-hidden="true">
            <img
                src="/images/class-2.jpg"
                alt=""
                class="w-full h-full object-cover object-center"
                loading="eager"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-espresso/80 via-espresso/55 to-espresso/25"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-espresso/40 via-transparent to-transparent"></div>
        </div>

        <div
            class="absolute right-0 top-1/2 -translate-y-1/2 w-[400px] h-[400px] rounded-full opacity-10 pointer-events-none"
            style="background: radial-gradient(circle, #CE7815 0%, transparent 70%);"
            aria-hidden="true"
        ></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-16">
            <div class="max-w-2xl">
                <p class="about-hero-eyebrow section-eyebrow mb-4" aria-hidden="true">
                    About Us
                </p>

                <h1
                    id="about-hero-heading"
                    class="about-hero-title font-display font-bold text-neutral-50 leading-tight mb-5"
                    style="font-size: clamp(2rem, 4vw, 2.8rem); line-height: 1.15;"
                >
                    Our Story, <em class="text-gold not-italic">Our People</em>
                </h1>

                <p
                    class="about-hero-subtitle text-base sm:text-lg text-white/70 leading-relaxed max-w-xl"
                    style="font-size: clamp(0.95rem, 1.8vw, 1.1rem);"
                >
                    Discover our academic programmes, meet the educators who shape young minds,
                    and hear from the families who have entrusted us with their children's futures.
                </p>
            </div>
        </div>
    </section>
</template>
