<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    post: {
        type: Object,
        required: true,
    },
    relatedPosts: {
        type: Array,
        default: () => [],
    },
});

function formatDate(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return d.toLocaleDateString('en-MY', { year: 'numeric', month: 'long', day: 'numeric' });
}

const categoryAccentColors = {
    Events: '#63616e',
    Achievements: '#a09ead',
    'Campus Life': '#95B91F',
    Academic: '#27262b',
    Community: '#D30C5F',
};

function accentForCategory(cat) {
    return categoryAccentColors[cat] || '#63616e';
}

async function copyLink() {
    try {
        await navigator.clipboard.writeText(window.location.href);
    } catch {
        // Clipboard API unavailable — silent fail
    }
}
</script>

<template>
    <section
        id="blog-post-section"
        class="bg-purple-gray-50 py-16 sm:py-20"
        aria-label="Blog post content"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="blog-post-breadcrumb flex items-center gap-2 text-xs text-purple-gray-400 mb-8" aria-label="Breadcrumb">
                <Link href="/" class="hover:text-purple-gray-500 transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-purple-gray-500 rounded-sm">Home</Link>
                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <Link href="/blog" class="hover:text-purple-gray-500 transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-purple-gray-500 rounded-sm">Blog</Link>
                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-purple-gray-500 truncate max-w-xs">{{ post.title }}</span>
            </nav>

            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">

                <!-- Main Content -->
                <article class="blog-post-content flex-1 min-w-0">

                    <!-- Back link -->
                    <Link
                        href="/blog"
                        class="inline-flex items-center gap-2 text-sm text-purple-gray-500 hover:text-purple-gray-600 font-medium mb-8 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 rounded-sm"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                        </svg>
                        Back to Blog
                    </Link>

                    <!-- Category pill -->
                    <span
                        v-if="post.category"
                        class="inline-block ml-2 px-3 py-1 rounded-full text-xs font-medium text-white uppercase tracking-widest mb-5"
                        :style="`background-color: ${accentForCategory(post.category)};`"
                    >
                        {{ post.category }}
                    </span>

                    <!-- Title -->
                    <h1
                        class="font-display font-bold text-purple-gray-800 leading-tight mb-6"
                        style="font-size: clamp(1.75rem, 4vw, 2.75rem); line-height: 1.15;"
                    >
                        {{ post.title }}
                    </h1>

                    <!-- Meta bar -->
                    <div class="flex flex-wrap items-center gap-4 mb-8 pb-8 border-b border-purple-gray-200">
                        <div class="flex items-center gap-2 text-sm text-purple-gray-500">
                            <svg class="w-4 h-4 text-purple-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                            </svg>
                            <time :datetime="post.date">{{ formatDate(post.date) }}</time>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-purple-gray-500">
                            <svg class="w-4 h-4 text-purple-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ post.readingTime }} min read</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-purple-gray-500">
                            <svg class="w-4 h-4 text-purple-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span>{{ post.author }}</span>
                        </div>
                    </div>

                    <!-- Hero media -->
                    <div class="rounded-xl overflow-hidden mb-10 shadow-md">
                        <video
                            v-if="post.mediaType === 'video' && post.videoUrl"
                            :src="post.videoUrl"
                            :poster="post.image"
                            autoplay
                            muted
                            controls
                            playsinline
                            class="w-full max-h-[32rem] bg-black"
                            :aria-label="post.title"
                        />
                        <img
                            v-else
                            :src="post.image"
                            :alt="post.title"
                            class="w-full h-64 sm:h-80 object-cover"
                            loading="lazy"
                            @error="(e) => e.target.src = '/images/class-2.jpg'"
                        />
                    </div>

                    <!-- Post body (HTML from CMS) -->
                    <div
                        class="blog-prose blog-prose-html space-y-6"
                        v-html="post.body"
                    />

                    <!-- Share row -->
                    <div class="blog-post-share mt-12 pt-8 border-t border-purple-gray-200 flex flex-wrap items-center gap-4">
                        <span class="text-sm font-medium text-purple-gray-500">Share this post:</span>
                        <a
                            :href="`https://wa.me/?text=${encodeURIComponent(post.title + ' — ' + (typeof window !== 'undefined' ? window.location.href : ''))}`"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium text-white transition-all duration-200 hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#25D366]"
                            style="background-color: #25D366;"
                            aria-label="Share on WhatsApp"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            WhatsApp
                        </a>
                        <button
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium text-purple-gray-600 bg-purple-gray-100 hover:bg-purple-gray-200 transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 focus-visible:ring-offset-2"
                            @click="copyLink"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                            </svg>
                            Copy link
                        </button>
                    </div>
                </article>

                <!-- Sidebar -->
                <aside class="blog-post-sidebar w-full lg:w-80 shrink-0" aria-label="Related posts and enquiry">
                    <div class="sticky top-24 space-y-8">

                        <!-- Related Posts -->
                        <div
                            v-if="relatedPosts.length"
                            class="bg-white rounded-xl border border-purple-gray-200 shadow-sm overflow-hidden"
                        >
                            <div class="px-6 py-4 border-b border-purple-gray-100 flex items-center gap-2">
                                <div
                                    class="w-1 h-4 rounded-full"
                                    :style="`background-color: ${accentForCategory(post.category || '')};`"
                                    aria-hidden="true"
                                ></div>
                                <h2 class="text-sm font-sans font-semibold text-purple-gray-800 uppercase tracking-widest">Related Posts</h2>
                            </div>
                            <ul class="divide-y divide-purple-gray-100">
                                <li v-for="related in relatedPosts" :key="related.slug">
                                    <Link
                                        :href="`/blog/${related.slug}`"
                                        class="flex items-start gap-3 p-4 group hover:bg-purple-gray-50 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-purple-gray-500"
                                    >
                                        <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0">
                                            <img
                                                :src="related.image"
                                                :alt="related.title"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                                loading="lazy"
                                                @error="(e) => e.target.src = '/images/class-2.jpg'"
                                            />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p
                                                v-if="related.category"
                                                class="text-xs font-medium uppercase tracking-wider mb-1"
                                                :style="`color: ${accentForCategory(related.category)};`"
                                            >
                                                {{ related.category }}
                                            </p>
                                            <p class="text-sm font-sans font-medium text-purple-gray-800 group-hover:text-purple-gray-500 transition-colors duration-200 leading-snug line-clamp-2">
                                                {{ related.title }}
                                            </p>
                                            <p class="text-xs text-purple-gray-400 mt-1">
                                                <time :datetime="related.date">{{ formatDate(related.date) }}</time>
                                            </p>
                                        </div>
                                    </Link>
                                </li>
                            </ul>
                            <div class="px-6 py-4 border-t border-purple-gray-100">
                                <Link
                                    href="/blog"
                                    class="flex items-center justify-center gap-2 text-sm font-medium text-purple-gray-500 hover:text-purple-gray-600 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 rounded-sm"
                                >
                                    View all posts
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </Link>
                            </div>
                        </div>

                        <!-- Enquiry CTA -->
                        <div class="bg-purple-gray-800 rounded-xl overflow-hidden relative p-6 text-center">
                            <div
                                class="absolute inset-0 opacity-5"
                                style="background-image: repeating-linear-gradient(45deg, #a09ead 0, #a09ead 1px, transparent 0, transparent 50%); background-size: 20px 20px;"
                                aria-hidden="true"
                            ></div>
                            <div class="relative z-10">
                                <p class="section-eyebrow text-purple-gray-400 mb-2">Admissions Open</p>
                                <h3 class="font-display font-semibold text-purple-gray-50 mb-3" style="font-size: 1.1rem; line-height: 1.3;">
                                    Ready to Join Our Community?
                                </h3>
                                <p class="text-white/60 text-xs leading-relaxed mb-5">
                                    Speak with our admissions team and book your campus visit today.
                                </p>
                                <a
                                    href="https://wa.me/60123450702?text=Hello%2C%20I%27d%20like%20to%20enquire%20about%20Aletheia%20Resource%20Center."
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-cta w-full text-sm"
                                    aria-label="Enquire via WhatsApp"
                                >
                                    Enquire Now
                                </a>
                            </div>
                        </div>

                    </div>
                </aside>

            </div>
        </div>
    </section>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.blog-prose-html :deep(p) {
    font-size: 1.0625rem;
    line-height: 1.8;
    color: rgb(64 64 64);
    margin-bottom: 1.25rem;
}

.blog-prose-html :deep(p:last-child) {
    margin-bottom: 0;
}

.blog-prose-html :deep(blockquote) {
    position: relative;
    padding-left: 1.5rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    margin: 2rem 0;
    border-left: 4px solid #a09ead;
    border-radius: 0.25rem;
}

.blog-prose-html :deep(blockquote p) {
    font-family: var(--font-display, ui-serif, Georgia, serif);
    font-style: italic;
    color: #27262b;
    margin-bottom: 0.75rem;
}

.blog-prose-html :deep(blockquote cite),
.blog-prose-html :deep(blockquote footer) {
    font-style: normal;
    font-size: 0.875rem;
    font-weight: 500;
    color: rgb(115 115 115);
}
</style>
