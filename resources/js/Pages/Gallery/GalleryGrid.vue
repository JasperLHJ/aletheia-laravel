<script setup>
import { onMounted, ref } from 'vue';
import { gsap } from 'gsap';

const props = defineProps({
    grid: {
        type: Object,
        required: true,
    },
});

const albums = props.grid.albums ?? [];

const gridRef = ref(null);

const prefersReducedMotion = typeof window !== 'undefined'
    ? window.matchMedia('(prefers-reduced-motion: reduce)').matches
    : false;

onMounted(() => {
    if (!prefersReducedMotion && gridRef.value) {
        const cards = gridRef.value.querySelectorAll('.album-card');
        gsap.fromTo(cards,
            { opacity: 0, y: 24 },
            { opacity: 1, y: 0, duration: 0.5, stagger: 0.07, ease: 'power2.out' },
        );
    }
});
</script>

<template>
    <section
        id="gallery-grid-section"
        class="bg-purple-gray-50 py-20 sm:py-24"
        aria-labelledby="gallery-grid-heading"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section header -->
            <div class="mb-12">
                <p class="section-eyebrow mb-2">{{ grid.eyebrow }}</p>
                <h2
                    id="gallery-grid-heading"
                    class="font-display font-semibold text-purple-gray-800"
                    style="font-size: clamp(1.6rem, 3vw, 2.2rem); line-height: 1.2;"
                >
                    {{ grid.heading }}
                </h2>
            </div>

            <!-- Album grid -->
            <div
                v-if="albums.length > 0"
                ref="gridRef"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
            >
                <a
                    v-for="(album, index) in albums"
                    :key="album.albumUrl + index"
                    :href="album.albumUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    :aria-label="`${album.title} — opens Google Photos album in a new tab`"
                    class="album-card group block rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 focus-visible:ring-offset-2"
                >
                    <!-- Cover image -->
                    <div class="relative aspect-[4/3] overflow-hidden bg-purple-gray-100">
                        <img
                            :src="album.coverUrl"
                            :alt="album.alt || album.title"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.04]"
                            :loading="index < 3 ? 'eager' : 'lazy'"
                        />

                        <!-- Hover overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-purple-gray-800/80 via-purple-gray-800/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                            aria-hidden="true"
                        />

                        <!-- "View full album" pill -->
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/95 text-purple-gray-800 text-xs font-semibold shadow-lg backdrop-blur-sm">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                {{ grid.viewAlbumText }}
                            </span>
                        </div>

                        <!-- Google Photos badge -->
                        <div class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 shadow flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300" aria-hidden="true">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                                <path d="M12 12m-10 0a10 10 0 1 0 20 0a10 10 0 1 0 -20 0" fill="#4285F4" fill-opacity="0.15"/>
                                <path d="M15.5 8H12a4 4 0 0 0 0 8h3.5A4 4 0 0 0 15.5 8z" fill="#EA4335"/>
                                <path d="M8.5 12a4 4 0 0 1 4-4H16a4 4 0 0 0-7.5 2H12v2H8.5z" fill="#FBBC05"/>
                                <path d="M8.5 12H12v2H8.5A4 4 0 0 1 8.5 12z" fill="#34A853"/>
                                <path d="M12 14h3.5a4 4 0 0 1-3.5 2z" fill="#4285F4"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Album title -->
                    <div class="bg-white px-5 py-4 border-t border-purple-gray-100">
                        <p class="font-display text-purple-gray-800 font-semibold text-base leading-snug group-hover:text-purple-gray-600 transition-colors duration-200 truncate">
                            {{ album.title }}
                        </p>
                    </div>
                </a>
            </div>

            <!-- Empty state -->
            <div
                v-else
                class="flex flex-col items-center justify-center py-24 text-center"
            >
                <div class="w-16 h-16 rounded-full bg-purple-gray-100 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-purple-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
                <p class="font-display text-purple-gray-800 text-lg font-semibold mb-1">{{ grid.emptyTitle }}</p>
                <p class="text-sm text-purple-gray-500">{{ grid.emptyBody }}</p>
            </div>

            <!-- CTA nudge -->
            <div class="mt-16 flex flex-col sm:flex-row items-center justify-center gap-4 text-center">
                <p class="text-purple-gray-600 text-sm">
                    {{ grid.ctaText }}
                </p>
                <a
                    :href="grid.ctaHref"
                    class="btn-cta text-sm px-5 py-2.5"
                    style="min-height: 40px;"
                >
                    {{ grid.ctaButton }}
                </a>
            </div>
        </div>
    </section>
</template>
