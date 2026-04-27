<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    posts: {
        type: Array,
        default: () => [],
    },
    listing: {
        type: Object,
        required: true,
    },
});

const selectedCategory = ref('All');

const categoryTabs = computed(() => {
    const labels = new Set();
    for (const p of props.posts) {
        if (p.category) labels.add(p.category);
    }
    const sorted = [...labels].sort((a, b) => a.localeCompare(b));
    return ['All', ...sorted];
});

const featuredPost = computed(() => {
    if (!props.posts.length) return null;
    return props.posts.find(p => p.featured) || props.posts[0];
});

const gridSource = computed(() => {
    const fp = featuredPost.value;
    if (!fp) return [];
    return props.posts.filter(p => p.slug !== fp.slug);
});

const filteredPosts = computed(() => {
    const rest = gridSource.value;
    if (selectedCategory.value === 'All') return rest;
    return rest.filter(p => p.category === selectedCategory.value);
});

function formatDate(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return d.toLocaleDateString('en-MY', { year: 'numeric', month: 'long', day: 'numeric' });
}

function accentForCategory(cat) {
    return props.listing.categoryAccentColors[cat] || '#63616e';
}
</script>

<template>
    <section
        id="blog-listing-section"
        class="bg-purple-gray-50 py-20 sm:py-28"
        aria-labelledby="blog-listing-heading"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section intro -->
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="section-eyebrow mb-3">{{ listing.eyebrow }}</p>
                <h2
                    id="blog-listing-heading"
                    class="font-display font-semibold text-purple-gray-800 mb-4"
                    style="font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;"
                >
                    {{ listing.heading }}
                </h2>
                <p class="text-purple-gray-600 leading-relaxed">
                    {{ listing.intro }}
                </p>
            </div>

            <!-- No published posts -->
            <div
                v-if="!posts.length"
                class="text-center py-16"
            >
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-gray-100 mb-4">
                    <svg class="w-8 h-8 text-purple-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <p class="font-display text-purple-gray-800 text-lg mb-2">{{ listing.emptyTitle }}</p>
                <p class="text-purple-gray-500 text-sm">{{ listing.emptyBody }}</p>
            </div>

            <template v-else>
                <!-- Featured Post -->
                    <article
                        v-if="featuredPost"
                        class="blog-featured-post group mb-16 bg-white rounded-2xl overflow-hidden border border-purple-gray-200 shadow-sm hover:shadow-xl transition-shadow duration-300"
                        :aria-label="listing.featuredAria"
                    >
                        <Link :href="`/blog/${featuredPost.slug}`" class="block md:grid md:grid-cols-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 rounded-2xl">
                            <div class="relative h-64 md:h-auto overflow-hidden">
                                <img
                                    :src="featuredPost.image"
                                    :alt="featuredPost.title"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                    loading="lazy"
                                    @error="(e) => e.target.src = '/images/class-2.jpg'"
                                />
                                <div
                                    v-if="featuredPost.mediaType === 'video'"
                                    class="absolute inset-0 flex items-center justify-center"
                                    aria-hidden="true"
                                >
                                    <div class="flex items-center justify-center w-14 h-14 rounded-full bg-black/50 backdrop-blur-sm">
                                        <svg class="w-6 h-6 text-white translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            <div
                                class="absolute inset-0"
                                style="background: linear-gradient(to top, rgba(39, 38, 43,0.5) 0%, transparent 60%);"
                                aria-hidden="true"
                            ></div>
                            <span
                                class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white uppercase tracking-widest"
                                :style="`background-color: ${accentForCategory(featuredPost.category)};`"
                            >
                                {{ listing.featuredBadge }}
                            </span>
                        </div>

                        <div class="p-8 sm:p-10 flex flex-col justify-center">
                            <p
                                v-if="featuredPost.category"
                                class="text-xs font-sans font-medium uppercase tracking-widest mb-3"
                                :style="`color: ${accentForCategory(featuredPost.category)};`"
                            >
                                {{ featuredPost.category }}
                            </p>
                            <h3
                                class="font-display font-semibold text-purple-gray-800 mb-4 group-hover:text-purple-gray-500 transition-colors duration-200"
                                style="font-size: clamp(1.3rem, 2.5vw, 1.75rem); line-height: 1.25;"
                            >
                                {{ featuredPost.title }}
                            </h3>
                            <p class="text-purple-gray-600 leading-relaxed mb-6 text-sm sm:text-base">
                                {{ featuredPost.excerpt }}
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3 text-xs text-purple-gray-400">
                                    <time :datetime="featuredPost.date">{{ formatDate(featuredPost.date) }}</time>
                                    <span aria-hidden="true">·</span>
                                    <span>{{ featuredPost.readingTime }} {{ listing.readTimeSuffix }}</span>
                                </div>
                                <span
                                    class="inline-flex items-center gap-1.5 text-sm font-medium text-purple-gray-500 group-hover:gap-3 transition-all duration-200"
                                >
                                    {{ listing.readMore }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </Link>
                </article>

                <!-- Category Filter -->
                <div
                    v-if="categoryTabs.length > 1"
                    class="flex flex-wrap items-center justify-center gap-2 mb-12"
                    role="group"
                    :aria-label="listing.filterAria"
                >
                    <button
                        v-for="cat in categoryTabs"
                        :key="cat"
                        class="px-4 py-2 rounded-full text-sm font-sans font-medium transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 focus-visible:ring-offset-2"
                        :class="selectedCategory === cat
                            ? 'bg-purple-gray-800 text-purple-gray-50 shadow-md'
                            : 'bg-white text-purple-gray-600 border border-purple-gray-200 hover:border-purple-gray-800 hover:text-purple-gray-800'"
                        :aria-pressed="selectedCategory === cat"
                        @click="selectedCategory = cat"
                    >
                        {{ cat }}
                    </button>
                </div>

                <!-- Posts Grid -->
                <div
                    v-if="filteredPosts.length"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8"
                >
                    <article
                        v-for="post in filteredPosts"
                        :key="post.slug"
                        class="blog-card group bg-white rounded-xl overflow-hidden border border-purple-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 flex flex-col"
                    >
                        <Link :href="`/blog/${post.slug}`" class="flex flex-col flex-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 rounded-xl">
                            <div class="relative h-48 overflow-hidden">
                                <video
                                    v-if="post.mediaType === 'video' && post.videoUrl"
                                    :src="post.videoUrl"
                                    muted
                                    preload="metadata"
                                    playsinline
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                />
                                <img
                                    v-else
                                    :src="post.image"
                                    :alt="post.title"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    loading="lazy"
                                    @error="(e) => e.target.src = '/images/class-2.jpg'"
                                />
                                <div
                                    class="absolute inset-0"
                                    :style="`background: linear-gradient(to top, ${accentForCategory(post.category)}cc 0%, transparent 60%);`"
                                    aria-hidden="true"
                                ></div>
                                <div
                                    v-if="post.mediaType === 'video'"
                                    class="absolute inset-0 flex items-center justify-center"
                                    aria-hidden="true"
                                >
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-black/50 backdrop-blur-sm">
                                        <svg class="w-5 h-5 text-white translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 flex flex-col flex-1">
                                <p
                                    v-if="post.category"
                                    class="text-xs font-sans font-medium uppercase tracking-widest mb-2"
                                    :style="`color: ${accentForCategory(post.category)};`"
                                >
                                    {{ post.category }}
                                </p>
                                <h3
                                    class="font-display font-semibold text-purple-gray-800 group-hover:text-purple-gray-500 transition-colors duration-200 mb-3"
                                    style="font-size: 1.1rem; line-height: 1.35;"
                                >
                                    {{ post.title }}
                                </h3>
                                <p class="text-sm text-purple-gray-600 leading-relaxed flex-1 line-clamp-3">
                                    {{ post.excerpt }}
                                </p>
                            </div>

                            <div class="px-6 pb-5 border-t border-purple-gray-100 pt-4 flex items-center justify-between">
                                <div class="flex items-center gap-2 text-xs text-purple-gray-400">
                                    <time :datetime="post.date">{{ formatDate(post.date) }}</time>
                                    <span aria-hidden="true">·</span>
                                    <span>{{ post.readingTime }} {{ listing.readTimeShort }}</span>
                                </div>
                                <span
                                    class="text-sm font-medium text-purple-gray-500 group-hover:gap-2 inline-flex items-center gap-1 transition-all duration-200"
                                >
                                    {{ listing.readArrow }}
                                </span>
                            </div>
                        </Link>
                    </article>

                    <article
                        v-if="listing.instagramCard?.href"
                        class="blog-card blog-instagram-card group bg-white rounded-xl overflow-hidden border border-purple-gray-200 shadow-sm flex flex-col transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-xl hover:border-transparent"
                    >
                        <a
                            :href="listing.instagramCard.href"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex flex-col flex-1 min-h-0 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 rounded-xl"
                            :aria-label="listing.instagramCard.ariaLabel"
                        >
                            <div class="relative h-48 overflow-hidden blog-instagram-card__banner">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-[#833AB4] via-[#FD1D1D] to-[#FCB045] opacity-95 transition-transform duration-500 ease-out group-hover:scale-110"
                                    aria-hidden="true"
                                ></div>
                                <div
                                    class="absolute inset-0 opacity-30 mix-blend-overlay bg-[radial-gradient(circle_at_30%_20%,white,transparent_55%)]"
                                    aria-hidden="true"
                                ></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm text-white shadow-lg ring-1 ring-white/25 transition-transform duration-300 ease-out group-hover:scale-110 group-hover:rotate-[-6deg]">
                                        <svg class="h-9 w-9" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="p-6 flex flex-col flex-1">
                                <p
                                    v-if="listing.instagramCard.eyebrow"
                                    class="text-xs font-sans font-medium uppercase tracking-widest mb-2 text-purple-gray-500"
                                >
                                    {{ listing.instagramCard.eyebrow }}
                                </p>
                                <h3
                                    class="font-display font-semibold text-purple-gray-800 mb-3 transition-colors duration-200 group-hover:text-[#833AB4]"
                                    style="font-size: 1.1rem; line-height: 1.35;"
                                >
                                    {{ listing.instagramCard.title }}
                                </h3>
                                <p class="text-sm text-purple-gray-600 leading-relaxed flex-1 line-clamp-3">
                                    {{ listing.instagramCard.subtitle }}
                                </p>
                            </div>

                            <div class="px-6 pb-5 border-t border-purple-gray-100 pt-4 flex items-center justify-between gap-3">
                                <span
                                    v-if="listing.instagramCard.handle"
                                    class="text-xs font-medium text-purple-gray-500 truncate"
                                >
                                    {{ listing.instagramCard.handle }}
                                </span>
                                <span
                                    class="text-sm font-medium text-purple-gray-500 group-hover:text-[#E1306C] inline-flex items-center gap-1.5 transition-all duration-200 group-hover:gap-2.5"
                                >
                                    {{ listing.instagramCard.cta }}
                                    <svg class="w-4 h-4 shrink-0 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </article>
                </div>

                <!-- Empty state (filtered / no other posts) -->
                <div
                    v-else
                    class="text-center py-16"
                >
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-gray-100 mb-4">
                        <svg class="w-8 h-8 text-purple-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <p class="font-display text-purple-gray-800 text-lg mb-2">{{ listing.filteredEmptyTitle }}</p>
                    <p class="text-purple-gray-500 text-sm">{{ listing.filteredEmptyBody }}</p>
                    <button
                        v-if="categoryTabs.length > 1"
                        class="mt-4 px-5 py-2 rounded-full text-sm font-medium bg-purple-gray-800 text-purple-gray-50 hover:bg-purple-gray-950 transition-colors"
                        @click="selectedCategory = 'All'"
                    >
                        {{ listing.viewAll }}
                    </button>
                </div>
            </template>

        </div>
    </section>
</template>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
