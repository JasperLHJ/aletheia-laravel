<template>
    <section
        class="relative min-h-screen flex items-center bg-espresso overflow-hidden"
        aria-labelledby="hero-heading"
    >
        <div class="absolute inset-0" aria-hidden="true">
            <img
                src="/images/student-1.jpg"
                alt=""
                class="w-full h-full object-cover object-center"
                loading="eager"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-espresso/80 via-espresso/55 to-espresso/25"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-espresso/40 via-transparent to-transparent"></div>
        </div>

        <div
            class="absolute right-0 top-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full opacity-10 pointer-events-none"
            style="background: radial-gradient(circle, #A74B1A 0%, transparent 70%);"
            aria-hidden="true"
        ></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20">
            <div class="max-w-2xl">
                <p class="hero-eyebrow section-eyebrow mb-4" aria-hidden="true">
                    Welcome to Aletheia Resource Center
                </p>

                <h1
                    id="hero-heading"
                    class="hero-title font-display font-bold text-neutral-50 leading-tight mb-6"
                    style="font-size: clamp(2.4rem, 5vw, 3.5rem); line-height: 1.1;"
                >
                    Shaping minds.<br>
                    <em class="text-gold not-italic">Inspiring futures.</em>
                </h1>

                <p class="hero-subtitle text-base sm:text-lg text-white/70 leading-relaxed max-w-xl mb-10" style="font-size: clamp(1rem, 2vw, 1.125rem);">
                    A tradition of academic excellence, nurturing students who think boldly and act with integrity. Enrolment now open for 2026.
                </p>

                <div class="hero-ctas flex flex-wrap gap-4 items-center">
                    <a
                        href="#enquiry"
                        class="btn-cta"
                    >
                        Book an Open Day
                    </a>
                    <a
                        href="#highlights"
                        class="btn-ghost-light"
                    >
                        Explore Our School
                    </a>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-white/10 text-white/70 border border-white/20"
                    >
                        <span class="w-1.5 h-1.5 rounded-full bg-sage shrink-0" aria-hidden="true"></span>
                        Applications Open 2026
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-white/10 text-white/70 border border-white/20"
                    >
                        <span class="w-1.5 h-1.5 rounded-full bg-gold shrink-0" aria-hidden="true"></span>
                        Merit Scholarships Available
                    </span>
                </div>
            </div>
        </div>

        <div
            class="hero-scroll-indicator absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/40"
            aria-hidden="true"
        >
            <span class="text-xs font-sans tracking-widest uppercase" style="font-size: 10px;">Scroll</span>
            <div class="w-px h-10 bg-gradient-to-b from-white/40 to-transparent"></div>
        </div>
    </section>
</template>
