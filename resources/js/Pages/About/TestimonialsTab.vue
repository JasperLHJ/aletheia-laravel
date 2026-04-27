<script setup>
defineProps({
    copy: {
        type: Object,
        required: true,
    },
    testimonials: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <div>
        <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-xs font-sans font-medium text-purple-gray-500 uppercase tracking-widest mb-3">
                {{ copy.introEyebrow }}
            </p>
            <h3
                class="font-display font-semibold text-purple-gray-800 mb-4"
                style="font-size: clamp(1.6rem, 2.8vw, 2.1rem); line-height: 1.2;"
            >
                {{ copy.introHeading }}
            </h3>
            <p class="text-purple-gray-600 leading-relaxed">
                {{ copy.introBody }}
            </p>
        </div>

        <p
            v-if="!testimonials.length"
            class="text-center text-purple-gray-500 font-sans"
        >
            {{ copy.empty }}
        </p>

        <div
            v-else
            class="grid grid-cols-1 md:grid-cols-2 gap-5 lg:gap-6"
        >
            <article
                v-for="testimonial in testimonials"
                :key="testimonial.id"
                class="testimonial-card bg-white rounded-2xl border border-purple-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 p-8 sm:p-10 relative flex flex-col"
            >
                <!-- Decorative quote mark -->
                <div
                    class="absolute top-5 right-7 font-display text-purple-gray-400/12 select-none pointer-events-none"
                    style="font-size: 6rem; line-height: 1;"
                    aria-hidden="true"
                >
                    &ldquo;
                </div>

                <div class="relative flex flex-col flex-1">
                    <blockquote class="flex-1 mb-8">
                        <p class="font-display text-purple-gray-800 leading-relaxed italic" style="font-size: 1.05rem; line-height: 1.75;">
                            &ldquo;{{ testimonial.quote }}&rdquo;
                        </p>
                    </blockquote>

                    <!-- Divider -->
                    <div class="w-10 h-px bg-purple-gray-400/40 mb-5" aria-hidden="true"></div>

                    <footer class="flex items-center gap-4">
                        <div
                            class="w-11 h-11 rounded-full bg-purple-gray-800 flex items-center justify-center shrink-0"
                            aria-hidden="true"
                        >
                            <span class="text-xs font-sans font-semibold text-purple-gray-50 tracking-wide">
                                {{ testimonial.initials }}
                            </span>
                        </div>
                        <div>
                            <cite class="not-italic font-sans font-semibold text-purple-gray-800 text-sm block mb-0.5">
                                {{ testimonial.author }}
                            </cite>
                            <span class="text-purple-gray-500 text-xs font-sans">
                                {{ testimonial.role }}
                            </span>
                        </div>
                    </footer>
                </div>
            </article>
        </div>
    </div>
</template>
