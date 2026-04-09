<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick, watch } from 'vue';
import { gsap } from 'gsap';

const allImages = [
    {
        src: '/images/class-1.jpg',
        category: 'Classrooms',
        caption: 'Interactive Learning',
        alt: 'Students engaged in interactive learning in a modern classroom',
    },
    {
        src: '/images/class-2.jpg',
        category: 'Classrooms',
        caption: 'Collaborative Spaces',
        alt: 'Students collaborating in a well-designed classroom environment',
    },
    {
        src: '/images/class-4.jpg',
        category: 'Facilities',
        caption: 'Modern Facilities',
        alt: 'State-of-the-art facilities at Aletheia Resource Center',
    },
    {
        src: '/images/sports-1.jpg',
        category: 'Sports',
        caption: 'Sports & Athletics',
        alt: 'Students participating in sports and athletic activities',
    },
    {
        src: '/images/student-1.jpg',
        category: 'Events',
        caption: 'Student Life',
        alt: 'Students enjoying school life and community events',
    },
    {
        src: '/images/class-2.jpg',
        category: 'Events',
        caption: 'School Celebrations',
        alt: 'Students and staff celebrating at a school event',
    },
    {
        src: '/images/sports-1.jpg',
        category: 'Facilities',
        caption: 'Sports Complex',
        alt: 'The school sports complex and outdoor facilities',
    },
    {
        src: '/images/student-1.jpg',
        category: 'Classrooms',
        caption: 'Focused Study',
        alt: 'A student deeply focused during a study session',
    },
    {
        src: '/images/class-1.jpg',
        category: 'Sports',
        caption: 'Team Spirit',
        alt: 'Students demonstrating teamwork and sportsmanship',
    },
    {
        src: '/images/class-4.jpg',
        category: 'Events',
        caption: 'Annual Showcase',
        alt: 'Students presenting their work at the annual school showcase',
    },
    {
        src: '/images/student-1.jpg',
        category: 'Facilities',
        caption: 'Learning Commons',
        alt: 'The school learning commons and library area',
    },
    {
        src: '/images/class-2.jpg',
        category: 'Sports',
        caption: 'Active Lifestyle',
        alt: 'Students enjoying an active and healthy school lifestyle',
    },
];

const categories = ['All', 'Events', 'Facilities', 'Classrooms', 'Sports'];
const activeCategory = ref('All');
const gridRef = ref(null);
const isFiltering = ref(false);

const prefersReducedMotion = typeof window !== 'undefined'
    ? window.matchMedia('(prefers-reduced-motion: reduce)').matches
    : false;

const categoryCounts = computed(() => {
    const counts = {};
    categories.forEach(cat => {
        counts[cat] = cat === 'All'
            ? allImages.length
            : allImages.filter(img => img.category === cat).length;
    });
    return counts;
});

const filteredImages = computed(() => {
    if (activeCategory.value === 'All') return allImages;
    return allImages.filter(img => img.category === activeCategory.value);
});

async function setCategory(cat) {
    if (cat === activeCategory.value || isFiltering.value) return;
    isFiltering.value = true;

    if (!prefersReducedMotion && gridRef.value) {
        const cards = gridRef.value.querySelectorAll('.gallery-card');
        await gsap.to(cards, {
            opacity: 0,
            y: 12,
            duration: 0.22,
            stagger: 0.03,
            ease: 'power2.in',
        });
    }

    activeCategory.value = cat;
    await nextTick();

    if (!prefersReducedMotion && gridRef.value) {
        const newCards = gridRef.value.querySelectorAll('.gallery-card');
        gsap.fromTo(newCards,
            { opacity: 0, y: 16 },
            {
                opacity: 1,
                y: 0,
                duration: 0.35,
                stagger: 0.05,
                ease: 'power2.out',
                onComplete: () => { isFiltering.value = false; },
            },
        );
    } else {
        isFiltering.value = false;
    }
}

// Lightbox state
const lightboxOpen = ref(false);
const lightboxIndex = ref(0);

const lightboxImage = computed(() => filteredImages.value[lightboxIndex.value]);

function openLightbox(index) {
    lightboxIndex.value = index;
    lightboxOpen.value = true;
    document.body.style.overflow = 'hidden';
    nextTick(() => {
        document.getElementById('lightbox-close')?.focus();
    });
}

function closeLightbox() {
    lightboxOpen.value = false;
    document.body.style.overflow = '';
}

function lightboxNext() {
    lightboxIndex.value = (lightboxIndex.value + 1) % filteredImages.value.length;
}

function lightboxPrev() {
    lightboxIndex.value = (lightboxIndex.value - 1 + filteredImages.value.length) % filteredImages.value.length;
}

// Touch support for lightbox
let lbTouchStartX = 0;
let lbTouchDelta = 0;

function onLbTouchStart(e) {
    lbTouchStartX = e.touches[0].clientX;
    lbTouchDelta = 0;
}
function onLbTouchMove(e) {
    lbTouchDelta = e.touches[0].clientX - lbTouchStartX;
}
function onLbTouchEnd() {
    if (Math.abs(lbTouchDelta) > 50) {
        if (lbTouchDelta < 0) lightboxNext();
        else lightboxPrev();
    }
    lbTouchDelta = 0;
}

function handleKeydown(e) {
    if (!lightboxOpen.value) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') lightboxNext();
    if (e.key === 'ArrowLeft') lightboxPrev();
}

function getCardSpan(index) {
    return index % 3 === 0 ? 'row-span-2' : 'row-span-1';
}

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);

    if (!prefersReducedMotion && gridRef.value) {
        const cards = gridRef.value.querySelectorAll('.gallery-card');
        gsap.fromTo(cards,
            { opacity: 0, y: 24 },
            { opacity: 1, y: 0, duration: 0.5, stagger: 0.06, ease: 'power2.out' },
        );
    }
});

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown);
    document.body.style.overflow = '';
});
</script>

<template>
    <section
        id="gallery-grid-section"
        class="bg-neutral-50 py-20 sm:py-24"
        aria-labelledby="gallery-grid-heading"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section header -->
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-10 gap-4">
                <div>
                    <p class="section-eyebrow mb-2">Browse & Explore</p>
                    <h2
                        id="gallery-grid-heading"
                        class="font-display font-semibold text-espresso"
                        style="font-size: clamp(1.6rem, 3vw, 2.2rem); line-height: 1.2;"
                    >
                        Our School in Pictures
                    </h2>
                </div>
                <p class="text-sm text-neutral-500 shrink-0">
                    {{ filteredImages.length }} {{ filteredImages.length === 1 ? 'photo' : 'photos' }}
                </p>
            </div>

            <!-- Category filter tabs -->
            <div
                class="flex flex-wrap gap-2 mb-10"
                role="tablist"
                aria-label="Filter gallery by category"
            >
                <button
                    v-for="cat in categories"
                    :key="cat"
                    role="tab"
                    :aria-selected="activeCategory === cat"
                    :aria-label="`Show ${cat} photos (${categoryCounts[cat]})`"
                    @click="setCategory(cat)"
                    :class="[
                        'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson focus-visible:ring-offset-2 min-h-[40px]',
                        activeCategory === cat
                            ? 'bg-espresso text-neutral-50 shadow-sm'
                            : 'bg-white text-espresso border border-neutral-200 hover:border-espresso/40 hover:bg-neutral-100'
                    ]"
                >
                    {{ cat }}
                    <span
                        :class="[
                            'text-xs px-1.5 py-0.5 rounded-full font-sans tabular-nums transition-colors',
                            activeCategory === cat
                                ? 'bg-white/20 text-white'
                                : 'bg-neutral-100 text-neutral-500'
                        ]"
                    >
                        {{ categoryCounts[cat] }}
                    </span>
                </button>
            </div>

            <!-- Masonry grid -->
            <div
                ref="gridRef"
                class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4"
                style="grid-auto-rows: 160px;"
                aria-live="polite"
                aria-label="Gallery photos"
            >
                <div
                    v-for="(img, index) in filteredImages"
                    :key="img.src + img.caption + index"
                    :class="[
                        'gallery-card group relative overflow-hidden cursor-pointer',
                        'rounded-2xl shadow-md hover:shadow-xl',
                        'transition-all duration-300',
                        getCardSpan(index)
                    ]"
                    @click="openLightbox(index)"
                    tabindex="0"
                    role="button"
                    :aria-label="`View photo: ${img.caption}`"
                    @keydown.enter="openLightbox(index)"
                    @keydown.space.prevent="openLightbox(index)"
                >
                    <img
                        :src="img.src"
                        :alt="img.alt"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.04]"
                        :loading="index < 4 ? 'eager' : 'lazy'"
                    />

                    <!-- Hover overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-espresso/75 via-espresso/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        aria-hidden="true"
                    ></div>

                    <!-- Category badge -->
                    <div class="absolute top-3 left-3 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-1 group-hover:translate-y-0">
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-gold/90 text-espresso-dark backdrop-blur-sm">
                            {{ img.category }}
                        </span>
                    </div>

                    <!-- Expand icon -->
                    <div
                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-1 group-hover:translate-y-0"
                        aria-hidden="true"
                    >
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                    </div>

                    <!-- Caption -->
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                        <p class="font-display text-white text-base font-semibold leading-snug">
                            {{ img.caption }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Empty state -->
            <div
                v-if="filteredImages.length === 0"
                class="flex flex-col items-center justify-center py-24 text-center"
                aria-live="polite"
            >
                <div class="w-16 h-16 rounded-full bg-neutral-100 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
                <p class="font-display text-espresso text-lg font-semibold mb-1">No photos yet</p>
                <p class="text-sm text-neutral-500">Photos in this category will appear here soon.</p>
            </div>

            <!-- CTA nudge -->
            <div class="mt-16 flex flex-col sm:flex-row items-center justify-center gap-4 text-center">
                <p class="text-neutral-600 text-sm">
                    Want to experience Aletheia in person?
                </p>
                <a
                    href="/contact"
                    class="btn-cta text-sm px-5 py-2.5"
                    style="min-height: 40px;"
                >
                    Book a School Tour
                </a>
            </div>
        </div>

        <!-- Lightbox -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition-opacity duration-200 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-150 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="lightboxOpen"
                    class="fixed inset-0 z-[70] flex items-center justify-center p-4 sm:p-8"
                    style="background: rgba(30, 13, 8, 0.92); backdrop-filter: blur(12px);"
                    role="dialog"
                    aria-modal="true"
                    :aria-label="`Lightbox: ${lightboxImage?.caption}`"
                    @touchstart.passive="onLbTouchStart"
                    @touchmove.passive="onLbTouchMove"
                    @touchend="onLbTouchEnd"
                    @click.self="closeLightbox"
                >
                    <!-- Close button -->
                    <button
                        id="lightbox-close"
                        @click="closeLightbox"
                        class="absolute top-4 right-4 z-10 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white"
                        aria-label="Close lightbox"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Image counter -->
                    <div class="absolute top-4 left-4 z-10">
                        <span class="text-xs font-sans font-medium uppercase tracking-widest text-gold/80">
                            {{ String(lightboxIndex + 1).padStart(2, '0') }} / {{ String(filteredImages.length).padStart(2, '0') }}
                        </span>
                    </div>

                    <!-- Prev arrow -->
                    <button
                        v-if="filteredImages.length > 1"
                        @click="lightboxPrev"
                        class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full border border-white/20 bg-white/10 hover:bg-espresso hover:border-espresso flex items-center justify-center text-white transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white"
                        aria-label="Previous photo"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <!-- Image -->
                    <div class="relative max-w-5xl w-full mx-auto flex flex-col items-center">
                        <Transition
                            enter-active-class="transition-all duration-200 ease-out"
                            enter-from-class="opacity-0 scale-[0.97]"
                            enter-to-class="opacity-100 scale-100"
                            leave-active-class="transition-all duration-150 ease-in"
                            leave-from-class="opacity-100 scale-100"
                            leave-to-class="opacity-0 scale-[0.97]"
                            mode="out-in"
                        >
                            <img
                                v-if="lightboxImage"
                                :key="lightboxImage.src + lightboxIndex"
                                :src="lightboxImage.src"
                                :alt="lightboxImage.alt"
                                class="max-h-[75vh] w-auto max-w-full rounded-xl shadow-2xl object-contain"
                                loading="eager"
                            />
                        </Transition>

                        <!-- Caption & category -->
                        <div v-if="lightboxImage" class="mt-5 flex flex-col items-center gap-1.5 text-center">
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-gold/20 text-gold border border-gold/30">
                                {{ lightboxImage.category }}
                            </span>
                            <p class="font-display text-white text-xl font-semibold">
                                {{ lightboxImage.caption }}
                            </p>
                        </div>
                    </div>

                    <!-- Next arrow -->
                    <button
                        v-if="filteredImages.length > 1"
                        @click="lightboxNext"
                        class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full border border-white/20 bg-white/10 hover:bg-espresso hover:border-espresso flex items-center justify-center text-white transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white"
                        aria-label="Next photo"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </Transition>
        </Teleport>
    </section>
</template>
