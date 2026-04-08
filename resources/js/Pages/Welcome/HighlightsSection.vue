<script setup>
const highlights = [
    {
        eyebrow: 'Academic Excellence',
        title: 'World-Class Curriculum',
        body: 'A rigorous programme designed to nurture critical thinkers, equipping students for leading universities worldwide.',
        image: '/images/class-1.jpg',
        imageAlt: 'Students engaged in classroom learning',
        accentColor: '#382016',
        linkText: 'Explore Academics',
    },
    {
        eyebrow: 'Achievements',
        title: 'A Legacy of Success',
        body: 'Our students consistently rank among the top in national and international examinations, earning merit scholarships year after year.',
        image: '/images/class-2.jpg',
        imageAlt: 'Students celebrating academic achievements',
        accentColor: '#9A5A0E',
        linkText: 'Our Achievements',
    },
    {
        eyebrow: 'Co-curricular',
        title: 'Holistic Environment',
        body: 'From orchestra and debate to robotics and sports, our campus fosters well-rounded growth beyond the classroom.',
        image: '/images/class-3.jpg',
        imageAlt: 'Students participating in co-curricular activities',
        accentColor: '#6B870F',
        linkText: 'Discover Campus Life',
    },
];
</script>

<template>
    <section
        id="highlights"
        class="bg-neutral-50 py-20 sm:py-28"
        aria-labelledby="highlights-heading"
    >
        <div id="highlights-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="section-eyebrow mb-3">Why Aletheia Resource Center</p>
                <h2
                    id="highlights-heading"
                    class="font-display font-semibold text-espresso mb-4"
                    style="font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;"
                >
                    An Education That Stays With You
                </h2>
                <p class="text-neutral-600 leading-relaxed">
                    We believe education is more than examination results. It is character, curiosity, and the courage to lead.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <article
                    v-for="card in highlights"
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
