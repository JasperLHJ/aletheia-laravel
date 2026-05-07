<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { gsap } from 'gsap';

const props = defineProps({
    content: {
        type: Object,
        required: true,
    },
    albums: {
        type: Array,
        default: () => [],
    },
});

const activeIndex = ref(0);
const isTransitioning = ref(false);
const trackRef = ref(null);
const carouselReady = ref(false);
let autoplayTimer = null;
let touchStartX = 0;
let touchDelta = 0;

const totalSlides = computed(() => props.albums.length);

function goTo(index, direction = null) {
    if (isTransitioning.value || index === activeIndex.value || totalSlides.value < 2) return;
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
    if (totalSlides.value < 2) return;
    goTo((activeIndex.value + 1) % totalSlides.value, 1);
}

function prev() {
    if (totalSlides.value < 2) return;
    goTo((activeIndex.value - 1 + totalSlides.value) % totalSlides.value, -1);
}

function resetAutoplay() {
    clearInterval(autoplayTimer);
    if (totalSlides.value > 1) {
        autoplayTimer = setInterval(next, 4500);
    }
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
    if (totalSlides.value === 0) return 0;
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
        class="bg-purple-gray-100 py-20 sm:py-24 overflow-hidden"
        aria-labelledby="gallery-heading"
    >
        <div id="gallery-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-12 gap-4">
                <div>
                    <p class="section-eyebrow mb-2">{{ content.eyebrow }}</p>
                    <h2
                        id="gallery-heading"
                        class="font-display font-semibold text-purple-gray-800"
                        style="font-size: clamp(1.6rem, 3vw, 2.2rem); line-height: 1.2;"
                    >
                        {{ content.heading }}
                    </h2>
                </div>
                <a
                    :href="content.galleryHref"
                    class="text-sm font-medium text-purple-gray-500 hover:text-purple-gray-600 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 rounded-sm shrink-0"
                    :aria-label="content.viewFullAriaLabel"
                >
                    {{ content.viewFullLabel }}
                </a>
            </div>

            <!-- Empty state -->
            <div
                v-if="albums.length === 0"
                class="flex flex-col items-center justify-center py-24 text-center rounded-2xl border border-purple-gray-200 bg-white/50"
            >
                <p class="text-purple-gray-500 text-sm">Gallery albums will appear here soon.</p>
            </div>

            <!-- Carousel -->
            <div
                v-else
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
                    <a
                        v-for="(album, i) in albums"
                        :key="album.albumUrl + i"
                        :href="album.albumUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="gallery-slide absolute inset-0 transition-none block"
                        :class="{ 'z-20': i === activeIndex, 'z-10': i !== activeIndex }"
                        :style="{
                            opacity: carouselReady ? (i === activeIndex ? 1 : 0) : (i === 0 ? 1 : 0),
                            transform: carouselReady && i !== activeIndex ? 'scale(0.85)' : 'scale(1)',
                        }"
                        :tabindex="i === activeIndex ? 0 : -1"
                        :aria-label="`${album.title} — opens Google Photos album in a new tab`"
                    >
                        <img
                            :src="album.coverUrl"
                            :alt="album.alt || album.title"
                            class="w-full h-full object-cover"
                            :loading="i === 0 ? 'eager' : 'lazy'"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-purple-gray-800/60 via-purple-gray-800/10 to-transparent"
                            aria-hidden="true"
                        />
                        <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 flex items-end justify-between">
                            <div>
                                <span class="inline-block text-xs font-sans font-medium uppercase tracking-widest text-purple-gray-400/90 mb-1">
                                    {{ String(i + 1).padStart(2, '0') }} / {{ String(totalSlides).padStart(2, '0') }}
                                </span>
                                <p class="font-display text-white text-lg sm:text-xl font-semibold">
                                    {{ album.title }}
                                </p>
                            </div>
                            <!-- "Open album" chip -->
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-sm text-white text-xs font-medium border border-white/25 opacity-0 group-hover:opacity-100 pointer-events-none" aria-hidden="true">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                View album
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Navigation arrows -->
                <div v-if="totalSlides > 1" class="flex items-center gap-3 mt-6">
                    <button
                        @click="prev"
                        class="gallery-nav-btn group relative w-11 h-11 rounded-full border border-purple-gray-300 bg-white flex items-center justify-center transition-all duration-300 hover:bg-purple-gray-800 hover:border-purple-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500"
                        :aria-label="content.navPrevAria"
                    >
                        <svg class="w-4 h-4 text-purple-gray-800 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        @click="next"
                        class="gallery-nav-btn group relative w-11 h-11 rounded-full border border-purple-gray-300 bg-white flex items-center justify-center transition-all duration-300 hover:bg-purple-gray-800 hover:border-purple-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500"
                        :aria-label="content.navNextAria"
                    >
                        <svg class="w-4 h-4 text-purple-gray-800 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Progress bar -->
                    <div class="flex-1 h-0.5 bg-purple-gray-300 rounded-full overflow-hidden ml-2">
                        <div
                            class="h-full bg-purple-gray-500 rounded-full transition-all duration-500 ease-out"
                            :style="{ width: progressWidth + '%' }"
                        />
                    </div>
                </div>

                <!-- Thumbnail strip -->
                <div
                    class="grid gap-3 mt-5"
                    :style="{ gridTemplateColumns: `repeat(${Math.min(albums.length, 4)}, minmax(0, 1fr))` }"
                    role="tablist"
                    :aria-label="content.thumbTablistAria"
                >
                    <button
                        v-for="(album, i) in albums"
                        :key="'thumb-' + i"
                        @click="goTo(i)"
                        role="tab"
                        :aria-selected="i === activeIndex"
                        :aria-label="`View album: ${album.title}`"
                        class="gallery-thumb relative rounded-lg overflow-hidden transition-all duration-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500"
                        :class="[
                            i === activeIndex
                                ? 'ring-2 ring-purple-gray-500 ring-offset-2 ring-offset-purple-gray-100 opacity-100'
                                : 'opacity-50 hover:opacity-75'
                        ]"
                    >
                        <img
                            :src="album.coverUrl"
                            :alt="''"
                            class="w-full h-16 sm:h-20 object-cover"
                            loading="lazy"
                        />
                        <div
                            v-if="i === activeIndex"
                            class="absolute inset-0 border-2 border-purple-gray-500 rounded-lg"
                            aria-hidden="true"
                        />
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
