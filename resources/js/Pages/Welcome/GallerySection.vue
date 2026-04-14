<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { gsap } from 'gsap';

const props = defineProps({
    content: {
        type: Object,
        required: true,
    },
});

const galleryImages = computed(() => props.content.images);

const activeIndex = ref(0);
const isTransitioning = ref(false);
const trackRef = ref(null);
const carouselReady = ref(false);
let autoplayTimer = null;
let touchStartX = 0;
let touchDelta = 0;

const totalSlides = computed(() => galleryImages.value.length);

function goTo(index, direction = null) {
    if (isTransitioning.value || index === activeIndex.value) return;
    isTransitioning.value = true;

    const prev = activeIndex.value;
    activeIndex.value = index;

    const slides = trackRef.value?.querySelectorAll('.gallery-slide');
    if (!slides) {
        isTransitioning.value = false;
        return;
    }

    const dir = direction ?? (index > prev ? 1 : -1);

    gsap.fromTo(
        slides[prev],
        { scale: 1, opacity: 1 },
        { scale: 0.85, opacity: 0.5, duration: 0.5, ease: 'power3.inOut' },
    );

    gsap.fromTo(
        slides[index],
        { scale: 0.85, opacity: 0.5, x: dir * 40 },
        {
            scale: 1,
            opacity: 1,
            x: 0,
            duration: 0.5,
            ease: 'power3.inOut',
            onComplete: () => { isTransitioning.value = false; },
        },
    );

    resetAutoplay();
}

function next() {
    goTo((activeIndex.value + 1) % totalSlides.value, 1);
}

function prev() {
    goTo((activeIndex.value - 1 + totalSlides.value) % totalSlides.value, -1);
}

function resetAutoplay() {
    clearInterval(autoplayTimer);
    autoplayTimer = setInterval(next, 4500);
}

function onTouchStart(e) {
    touchStartX = e.touches[0].clientX;
    touchDelta = 0;
}

function onTouchMove(e) {
    touchDelta = e.touches[0].clientX - touchStartX;
}

function onTouchEnd() {
    if (Math.abs(touchDelta) > 50) {
        if (touchDelta < 0) next();
        else prev();
    }
    touchDelta = 0;
}

const progressWidth = computed(() => {
    return ((activeIndex.value + 1) / totalSlides.value) * 100;
});

onMounted(() => {
    carouselReady.value = true;
    resetAutoplay();
});

onUnmounted(() => {
    clearInterval(autoplayTimer);
});
</script>

<template>
    <section
        id="gallery"
        class="bg-neutral-100 py-20 sm:py-24 overflow-hidden"
        aria-labelledby="gallery-heading"
    >
        <div id="gallery-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-12 gap-4">
                <div>
                    <p class="section-eyebrow mb-2">{{ content.eyebrow }}</p>
                    <h2
                        id="gallery-heading"
                        class="font-display font-semibold text-espresso"
                        style="font-size: clamp(1.6rem, 3vw, 2.2rem); line-height: 1.2;"
                    >
                        {{ content.heading }}
                    </h2>
                </div>
                <a
                    :href="content.galleryHref"
                    class="text-sm font-medium text-ember hover:text-ember-dark transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson rounded-sm shrink-0"
                    :aria-label="content.viewFullAriaLabel"
                >
                    {{ content.viewFullLabel }}
                </a>
            </div>

            <!-- Carousel -->
            <div
                class="relative"
                @touchstart.passive="onTouchStart"
                @touchmove.passive="onTouchMove"
                @touchend="onTouchEnd"
            >
                <!-- Main display -->
                <div
                    ref="trackRef"
                    class="relative w-full overflow-hidden rounded-2xl"
                    style="aspect-ratio: 16 / 7;"
                >
                    <div
                        v-for="(img, i) in galleryImages"
                        :key="img.src + i"
                        class="gallery-slide absolute inset-0 transition-none"
                        :class="{ 'z-20': i === activeIndex, 'z-10': i !== activeIndex }"
                        :style="{
                            opacity: carouselReady ? (i === activeIndex ? 1 : 0) : (i === 0 ? 1 : 0),
                            transform: carouselReady && i !== activeIndex ? 'scale(0.85)' : 'scale(1)',
                        }"
                    >
                        <img
                            :src="img.src"
                            :alt="img.alt"
                            class="w-full h-full object-cover"
                            :loading="i === 0 ? 'eager' : 'lazy'"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-espresso/60 via-espresso/10 to-transparent"
                            aria-hidden="true"
                        ></div>
                        <div
                            class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 flex items-end justify-between"
                        >
                            <div>
                                <span
                                    class="inline-block text-xs font-sans font-medium uppercase tracking-widest text-gold/90 mb-1"
                                >
                                    {{ String(i + 1).padStart(2, '0') }} / {{ String(totalSlides).padStart(2, '0') }}
                                </span>
                                <p class="font-display text-white text-lg sm:text-xl font-semibold">
                                    {{ img.caption }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation arrows -->
                <div class="flex items-center gap-3 mt-6">
                    <button
                        @click="prev"
                        class="gallery-nav-btn group relative w-11 h-11 rounded-full border border-neutral-300 bg-white flex items-center justify-center transition-all duration-300 hover:bg-espresso hover:border-espresso focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson"
                        :aria-label="content.navPrevAria"
                    >
                        <svg class="w-4 h-4 text-espresso group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        @click="next"
                        class="gallery-nav-btn group relative w-11 h-11 rounded-full border border-neutral-300 bg-white flex items-center justify-center transition-all duration-300 hover:bg-espresso hover:border-espresso focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson"
                        :aria-label="content.navNextAria"
                    >
                        <svg class="w-4 h-4 text-espresso group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Progress bar -->
                    <div class="flex-1 h-0.5 bg-neutral-300 rounded-full overflow-hidden ml-2">
                        <div
                            class="h-full bg-ember rounded-full transition-all duration-500 ease-out"
                            :style="{ width: progressWidth + '%' }"
                        ></div>
                    </div>
                </div>

                <!-- Thumbnail strip -->
                <div class="grid grid-cols-4 gap-3 mt-5" role="tablist" :aria-label="content.thumbTablistAria">
                    <button
                        v-for="(img, i) in galleryImages"
                        :key="'thumb-' + i"
                        @click="goTo(i)"
                        role="tab"
                        :aria-selected="i === activeIndex"
                        :aria-label="`View image: ${img.caption}`"
                        class="gallery-thumb relative rounded-lg overflow-hidden transition-all duration-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson"
                        :class="[
                            i === activeIndex
                                ? 'ring-2 ring-ember ring-offset-2 ring-offset-neutral-100 opacity-100'
                                : 'opacity-50 hover:opacity-75'
                        ]"
                    >
                        <img
                            :src="img.src"
                            :alt="''"
                            class="w-full h-16 sm:h-20 object-cover"
                            loading="lazy"
                        />
                        <div
                            v-if="i === activeIndex"
                            class="absolute inset-0 border-2 border-ember rounded-lg"
                            aria-hidden="true"
                        ></div>
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
