<script setup>
const testimonials = [
    {
        quote: 'Aletheia Resource Center gave my daughter not just an outstanding education, but the confidence and character to thrive wherever she goes. The teachers here truly know every child by name.',
        author: 'Mrs. Priya Menon',
        role: 'Parent, Year 10',
        initials: 'PM',
    },
    {
        quote: 'What sets this school apart is the genuine care for every student. My son has grown academically and personally in ways I never expected.',
        author: 'Mr. David Tan',
        role: 'Parent, Year 8',
        initials: 'DT',
    },
    {
        quote: 'From the moment we walked through the doors, we knew this was the right place for our family. The academic rigour combined with a nurturing environment is exactly what we were looking for.',
        author: 'Mrs. Amira Hassan',
        role: 'Parent, Year 6',
        initials: 'AH',
    },
    {
        quote: 'The teachers go above and beyond. My daughter\u2019s love for science was sparked by a teacher here who believed in her potential before she believed in herself.',
        author: 'Mr. Kevin Loh',
        role: 'Parent, Year 11',
        initials: 'KL',
    },
    {
        quote: 'I have never felt more prepared for university. The support from our teachers and the opportunities available here are truly exceptional.',
        author: 'Adam Khalid',
        role: 'Alumni, Class of 2024',
        initials: 'AK',
    },
    {
        quote: 'Three of our children have gone through Aletheia, and each one has had a unique, personalised experience. That speaks volumes about the quality of care here.',
        author: 'Dr. & Mrs. Rajesh Kumar',
        role: 'Parents, Years 7, 9 & 12',
        initials: 'RK',
    },
];
</script>

<template>
    <div>
        <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-xs font-sans font-medium text-ember uppercase tracking-widest mb-3">
                Voices of Our Community
            </p>
            <h3
                class="font-display font-semibold text-espresso mb-4"
                style="font-size: clamp(1.6rem, 2.8vw, 2.1rem); line-height: 1.2;"
            >
                Parent Testimonials
            </h3>
            <p class="text-neutral-600 leading-relaxed">
                Hear from the families who have entrusted us with their children's education
                and watched them flourish.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-6">
            <article
                v-for="testimonial in testimonials"
                :key="testimonial.author"
                class="testimonial-card bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-lg transition-all duration-300 p-8 sm:p-10 relative flex flex-col"
            >
                <!-- Decorative quote mark -->
                <div
                    class="absolute top-5 right-7 font-display text-gold/12 select-none pointer-events-none"
                    style="font-size: 6rem; line-height: 1;"
                    aria-hidden="true"
                >
                    &ldquo;
                </div>

                <div class="relative flex flex-col flex-1">
                    <blockquote class="flex-1 mb-8">
                        <p class="font-display text-espresso leading-relaxed italic" style="font-size: 1.05rem; line-height: 1.75;">
                            &ldquo;{{ testimonial.quote }}&rdquo;
                        </p>
                    </blockquote>

                    <!-- Divider -->
                    <div class="w-10 h-px bg-gold/40 mb-5" aria-hidden="true"></div>

                    <footer class="flex items-center gap-4">
                        <div
                            class="w-11 h-11 rounded-full bg-espresso flex items-center justify-center shrink-0"
                            aria-hidden="true"
                        >
                            <span class="text-xs font-sans font-semibold text-cream-50 tracking-wide">
                                {{ testimonial.initials }}
                            </span>
                        </div>
                        <div>
                            <cite class="not-italic font-sans font-semibold text-espresso text-sm block mb-0.5">
                                {{ testimonial.author }}
                            </cite>
                            <span class="text-neutral-500 text-xs font-sans">
                                {{ testimonial.role }}
                            </span>
                        </div>
                    </footer>
                </div>
            </article>
        </div>
    </div>
</template>
