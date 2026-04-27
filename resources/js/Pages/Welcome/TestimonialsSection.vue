<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

const props = defineProps({
    testimonials: {
        type: Array,
        default: () => [],
    },
    copy: {
        type: Object,
        required: true,
    },
});

const swiperModules = [Autoplay, Pagination, EffectFade];
</script>

<template>
    <section
        id="testimonial-section"
        class="testimonial-swiper-section bg-purple-gray-800 py-20 sm:py-28 overflow-hidden relative"
        aria-labelledby="testimonial-heading"
    >
        <div
            class="absolute left-0 top-0 w-72 h-72 rounded-full opacity-10 -translate-x-1/2 -translate-y-1/2"
            style="background: #63616e;"
            aria-hidden="true"
        ></div>
        <div
            class="absolute right-0 bottom-0 w-96 h-96 rounded-full opacity-5 translate-x-1/3 translate-y-1/3"
            style="background: #a09ead;"
            aria-hidden="true"
        ></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="section-eyebrow text-purple-gray-400 mb-4" v-html="props.copy.eyebrowHtml">
            </p>
            <h2 id="testimonial-heading" class="sr-only">{{ props.copy.headingSrOnly }}</h2>

            <Swiper
                v-if="props.testimonials.length"
                :modules="swiperModules"
                :slides-per-view="1"
                :space-between="40"
                :loop="true"
                :speed="700"
                effect="fade"
                :fade-effect="{ crossFade: true }"
                :autoplay="{ delay: 5500, disableOnInteraction: false, pauseOnMouseEnter: true }"
                :pagination="{ clickable: true, el: '.testimonial-pagination' }"
                class="testimonial-swiper"
            >
                <SwiperSlide
                    v-for="t in props.testimonials"
                    :key="t.id"
                >
                    <div class="testimonial-content pb-4" aria-live="polite" aria-atomic="true">
                        <blockquote class="mb-8">
                            <p
                                class="font-display text-white/90 leading-relaxed italic"
                                style="font-size: clamp(1.1rem, 2.5vw, 1.5rem); line-height: 1.6;"
                            >
                                "{{ t.quote }}"
                            </p>
                        </blockquote>
                        <footer class="flex flex-col items-center gap-1">
                            <cite class="not-italic font-sans font-medium text-purple-gray-400 text-sm">
                                {{ t.author }}
                            </cite>
                            <span class="text-white/40 text-xs font-sans">
                                {{ t.role }}
                            </span>
                        </footer>
                    </div>
                </SwiperSlide>
            </Swiper>
            <p
                v-else
                class="font-sans text-white/50 text-sm"
            >
                {{ props.copy.emptyMessage }}
            </p>

            <div v-if="props.testimonials.length" class="testimonial-pagination mt-8"></div>
        </div>
    </section>
</template>

<style scoped>
.testimonial-swiper {
    overflow: visible;
}

.testimonial-swiper :deep(.swiper-slide) {
    opacity: 0 !important;
    transition: opacity 0.7s ease;
}

.testimonial-swiper :deep(.swiper-slide-active) {
    opacity: 1 !important;
}
</style>

<style>
.testimonial-swiper-section .testimonial-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
}

.testimonial-swiper-section .testimonial-pagination .swiper-pagination-bullet {
    width: 8px;
    height: 8px;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.25);
    opacity: 1;
    transition: all 0.3s ease;
    cursor: pointer;
}

.testimonial-swiper-section .testimonial-pagination .swiper-pagination-bullet:hover {
    background: rgba(255, 255, 255, 0.5);
}

.testimonial-swiper-section .testimonial-pagination .swiper-pagination-bullet-active {
    width: 32px;
    background: #a09ead;
}
</style>
