<template>
    <section
        id="programme-overview"
        class="bg-neutral-50 py-20 sm:py-28"
        aria-labelledby="overview-heading"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="text-xs font-sans font-medium text-ember uppercase tracking-widest mb-3">
                    Our Pathways
                </p>
                <h2
                    id="overview-heading"
                    class="font-display font-semibold text-espresso mb-4"
                    style="font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;"
                >
                    A Complete Education Journey
                </h2>
                <p class="text-neutral-600 leading-relaxed">
                    Three connected Cambridge-aligned programmes forming a seamless pathway
                    from a child's first school years all the way to university admission.
                </p>
            </div>

            <!-- Pathway Connector -->
            <div class="relative mb-12 hidden md:block" aria-hidden="true">
                <div class="absolute inset-y-1/2 left-[16.66%] right-[16.66%] h-px bg-gradient-to-r from-sage via-ember to-gold -translate-y-1/2"></div>
                <div class="flex justify-around">
                    <div class="flex flex-col items-center gap-2 relative z-10">
                        <div class="w-4 h-4 rounded-full bg-sage ring-4 ring-neutral-50"></div>
                        <span class="text-xs font-semibold text-sage uppercase tracking-wider">Ages 5–11</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 relative z-10">
                        <div class="w-4 h-4 rounded-full bg-ember ring-4 ring-neutral-50"></div>
                        <span class="text-xs font-semibold text-ember uppercase tracking-wider">Ages 12–16</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 relative z-10">
                        <div class="w-4 h-4 rounded-full bg-gold ring-4 ring-neutral-50"></div>
                        <span class="text-xs font-semibold text-gold uppercase tracking-wider">Ages 17–18</span>
                    </div>
                </div>
            </div>

            <!-- Programme Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <article
                    v-for="programme in programmes"
                    :key="programme.title"
                    class="programme-overview-card group bg-white rounded-2xl overflow-hidden border border-neutral-200/90 shadow-sm flex flex-col transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-xl hover:border-transparent"
                    :class="programme.hoverRing"
                >
                    <!-- Top accent bar -->
                    <div :class="[programme.accentBg, 'h-1.5 w-full shrink-0']" aria-hidden="true"></div>

                    <!-- Image area -->
                    <div class="relative h-44 overflow-hidden">
                        <img
                            :src="programme.image"
                            :alt="programme.imageAlt"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                        />
                        <div
                            class="absolute inset-0"
                            :style="`background: linear-gradient(to top, ${programme.overlayColor}cc 0%, transparent 55%);`"
                            aria-hidden="true"
                        ></div>
                        <!-- Age badge -->
                        <div class="absolute bottom-3 left-4">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold text-white"
                                :style="`background-color: ${programme.overlayColor}; opacity: 0.92;`"
                            >
                                {{ programme.eyebrow }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 sm:p-7 flex flex-col flex-1">
                        <!-- Icon + Title -->
                        <div class="flex items-start gap-3 mb-3">
                            <div
                                :class="[programme.accentBg, 'w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 transition-transform duration-300 group-hover:scale-110']"
                                v-html="programme.icon"
                            ></div>
                            <h3
                                class="font-display font-bold text-espresso pt-1"
                                style="font-size: 1.2rem; line-height: 1.25;"
                            >
                                {{ programme.title }}
                            </h3>
                        </div>

                        <p class="text-sm text-neutral-600 leading-relaxed flex-1 mb-4">
                            {{ programme.description }}
                        </p>

                        <!-- Highlights -->
                        <div class="flex flex-wrap gap-1.5 mb-5">
                            <span
                                v-for="tag in programme.highlights"
                                :key="tag"
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-neutral-100 text-neutral-700"
                            >
                                {{ tag }}
                            </span>
                        </div>

                        <!-- CTA -->
                        <div class="mt-auto pt-4 border-t border-neutral-100 flex items-center justify-between">
                            <a
                                :href="programme.anchor"
                                :class="['text-sm font-semibold font-sans transition-colors duration-200', programme.accentText]"
                                :aria-label="`Explore the ${programme.title}`"
                            >
                                Explore Programme
                            </a>
                            <span
                                :class="['flex items-center justify-center w-7 h-7 rounded-full transition-all duration-300 group-hover:translate-x-0.5', programme.accentBg]"
                                aria-hidden="true"
                            >
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>

<script setup>
const programmes = [
    {
        eyebrow: 'Ages 5–11',
        title: 'Primary Programme',
        description: 'A strong foundation in literacy, numeracy, and critical thinking through an inquiry-based Cambridge curriculum that nurtures curiosity and builds confidence in every child.',
        highlights: ['Cambridge Primary', 'STEM Integration', 'Character Education', 'Portfolio Assessment'],
        image: '/images/class-3.jpg',
        imageAlt: 'Young students engaged in hands-on learning activities',
        overlayColor: '#6B870F',
        accentBg: 'bg-sage',
        accentText: 'text-sage-dark',
        accentBorder: 'border-sage',
        hoverRing: 'hover:ring-2 hover:ring-offset-2 hover:ring-sage/60',
        anchor: '#primary-programme',
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>`,
    },
    {
        eyebrow: 'Ages 12–16',
        title: 'Secondary Programme',
        description: 'Rigorous academic preparation aligned with Cambridge IGCSE, developing analytical skills and subject mastery to prepare students for advanced study and global opportunities.',
        highlights: ['Cambridge IGCSE', 'Core Sciences', 'Modern Languages', 'Co-Curricular CCA'],
        image: '/images/class-1.jpg',
        imageAlt: 'Secondary students in a science laboratory',
        overlayColor: '#7A3410',
        accentBg: 'bg-ember',
        accentText: 'text-ember-dark',
        accentBorder: 'border-ember',
        hoverRing: 'hover:ring-2 hover:ring-offset-2 hover:ring-ember/60',
        anchor: '#secondary-programme',
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>`,
    },
    {
        eyebrow: 'Ages 17–18',
        title: 'Pre-University',
        description: 'Advanced Cambridge A-Level pathways with personalised mentorship, subject specialisation, and expert university counselling for admission to leading institutions worldwide.',
        highlights: ['Cambridge A-Levels', 'University Counselling', 'Research Projects', 'Leadership'],
        image: '/images/class-2.jpg',
        imageAlt: 'Pre-university students in a discussion seminar',
        overlayColor: '#9A5A0E',
        accentBg: 'bg-gold',
        accentText: 'text-gold-dark',
        accentBorder: 'border-gold',
        hoverRing: 'hover:ring-2 hover:ring-offset-2 hover:ring-gold/60',
        anchor: '#preuniversity-programme',
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" /></svg>`,
    },
];
</script>
