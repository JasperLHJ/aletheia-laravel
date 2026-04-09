<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const categories = ['All', 'Events', 'Achievements', 'Campus Life', 'Academic', 'Community'];
const selectedCategory = ref('All');

const posts = [
    {
        slug: 'national-science-olympiad-2026',
        category: 'Achievements',
        title: 'Our Students Shine at the National Science Olympiad 2026',
        excerpt: 'Three of our Year 11 students brought home gold at this year\'s National Science Olympiad, competing against over 400 schools nationwide. Their dedication and the mentorship of our Science faculty made all the difference.',
        date: '2026-03-28',
        image: '/images/class-2.jpg',
        readingTime: 4,
        featured: true,
    },
    {
        slug: 'open-day-april-2026',
        category: 'Events',
        title: 'Open Day: Come See Our Campus This April',
        excerpt: 'We\'re opening our doors to prospective families on 19 April 2026. Tour our facilities, meet our teachers, and discover what makes Aletheia Resource Center a place where every child can flourish.',
        date: '2026-03-20',
        image: '/images/class-3.jpg',
        readingTime: 3,
        featured: false,
    },
    {
        slug: 'robotics-club-regional-champions',
        category: 'Achievements',
        title: 'Robotics Club Crowned Regional Champions',
        excerpt: 'Our Robotics Club has done it again — taking first place at the Regional STEM Challenge for the second consecutive year. Read about the engineering journey that led them there.',
        date: '2026-03-14',
        image: '/images/student-1.jpg',
        readingTime: 5,
        featured: false,
    },
    {
        slug: 'wellbeing-week-recap',
        category: 'Campus Life',
        title: 'Wellbeing Week: Building Resilience, One Day at a Time',
        excerpt: 'Last week\'s Wellbeing Week brought yoga sessions, mindfulness workshops, and peer mentoring circles to our campus. Here\'s how students and staff are nurturing a culture of care.',
        date: '2026-03-08',
        image: '/images/class-1.jpg',
        readingTime: 3,
        featured: false,
    },
    {
        slug: 'new-ib-programme-launch',
        category: 'Academic',
        title: 'Aletheia Launches the International Baccalaureate Diploma Programme',
        excerpt: 'We are proud to announce our authorisation as an IB World School, offering the prestigious Diploma Programme from 2027. This milestone opens new global pathways for our students.',
        date: '2026-02-25',
        image: '/images/class-2.jpg',
        readingTime: 6,
        featured: false,
    },
    {
        slug: 'parent-teacher-collaboration-2026',
        category: 'Community',
        title: 'Strengthening the School-Home Partnership',
        excerpt: 'Our annual Parent-Teacher Collaboration Forum brought together over 200 families and educators to co-create a vision for student success. Key takeaways and action points inside.',
        date: '2026-02-14',
        image: '/images/class-3.jpg',
        readingTime: 4,
        featured: false,
    },
    {
        slug: 'chinese-new-year-celebrations',
        category: 'Events',
        title: 'Chinese New Year Celebrations: A Campus Full of Colour',
        excerpt: 'From the lion dance to the lantern-making workshop, our Chinese New Year celebrations brought together the entire school community in a joyful and vibrant showcase of culture.',
        date: '2026-01-30',
        image: '/images/student-1.jpg',
        readingTime: 2,
        featured: false,
    },
];

const featuredPost = computed(() => posts[0]);

const filteredPosts = computed(() => {
    const rest = posts.slice(1);
    if (selectedCategory.value === 'All') return rest;
    return rest.filter(p => p.category === selectedCategory.value);
});

function formatDate(dateStr) {
    const d = new Date(dateStr);
    return d.toLocaleDateString('en-MY', { year: 'numeric', month: 'long', day: 'numeric' });
}

const categoryAccentColors = {
    'Events': '#A74B1A',
    'Achievements': '#CE7815',
    'Campus Life': '#95B91F',
    'Academic': '#382016',
    'Community': '#D30C5F',
};

function accentForCategory(cat) {
    return categoryAccentColors[cat] || '#A74B1A';
}
</script>

<template>
    <section
        id="blog-listing-section"
        class="bg-neutral-50 py-20 sm:py-28"
        aria-labelledby="blog-listing-heading"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section intro -->
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="section-eyebrow mb-3">Latest from our community</p>
                <h2
                    id="blog-listing-heading"
                    class="font-display font-semibold text-espresso mb-4"
                    style="font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;"
                >
                    What's Happening at Aletheia
                </h2>
                <p class="text-neutral-600 leading-relaxed">
                    Stories of growth, achievement, and community — straight from our campus.
                </p>
            </div>

            <!-- Featured Post -->
            <article
                class="blog-featured-post group mb-16 bg-white rounded-2xl overflow-hidden border border-neutral-200 shadow-sm hover:shadow-xl transition-shadow duration-300"
                aria-label="Featured post"
            >
                <Link :href="`/blog/${featuredPost.slug}`" class="block md:grid md:grid-cols-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson rounded-2xl">
                    <div class="relative h-64 md:h-auto overflow-hidden">
                        <img
                            :src="featuredPost.image"
                            :alt="featuredPost.title"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            loading="lazy"
                        />
                        <div
                            class="absolute inset-0"
                            style="background: linear-gradient(to top, rgba(56,32,22,0.5) 0%, transparent 60%);"
                            aria-hidden="true"
                        ></div>
                        <span
                            class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white uppercase tracking-widest"
                            :style="`background-color: ${accentForCategory(featuredPost.category)};`"
                        >
                            ★ Featured
                        </span>
                    </div>

                    <div class="p-8 sm:p-10 flex flex-col justify-center">
                        <p
                            class="text-xs font-sans font-medium uppercase tracking-widest mb-3"
                            :style="`color: ${accentForCategory(featuredPost.category)};`"
                        >
                            {{ featuredPost.category }}
                        </p>
                        <h3
                            class="font-display font-semibold text-espresso mb-4 group-hover:text-ember transition-colors duration-200"
                            style="font-size: clamp(1.3rem, 2.5vw, 1.75rem); line-height: 1.25;"
                        >
                            {{ featuredPost.title }}
                        </h3>
                        <p class="text-neutral-600 leading-relaxed mb-6 text-sm sm:text-base">
                            {{ featuredPost.excerpt }}
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-xs text-neutral-400">
                                <time :datetime="featuredPost.date">{{ formatDate(featuredPost.date) }}</time>
                                <span aria-hidden="true">·</span>
                                <span>{{ featuredPost.readingTime }} min read</span>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 text-sm font-medium text-ember group-hover:gap-3 transition-all duration-200"
                            >
                                Read more
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
                class="flex flex-wrap items-center justify-center gap-2 mb-12"
                role="group"
                aria-label="Filter posts by category"
            >
                <button
                    v-for="cat in categories"
                    :key="cat"
                    class="px-4 py-2 rounded-full text-sm font-sans font-medium transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson focus-visible:ring-offset-2"
                    :class="selectedCategory === cat
                        ? 'bg-espresso text-cream-50 shadow-md'
                        : 'bg-white text-neutral-600 border border-neutral-200 hover:border-espresso hover:text-espresso'"
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
                    class="blog-card group bg-white rounded-xl overflow-hidden border border-neutral-200 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 flex flex-col"
                >
                    <Link :href="`/blog/${post.slug}`" class="flex flex-col flex-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson rounded-xl">
                        <div class="relative h-48 overflow-hidden">
                            <img
                                :src="post.image"
                                :alt="post.title"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy"
                            />
                            <div
                                class="absolute inset-0"
                                :style="`background: linear-gradient(to top, ${accentForCategory(post.category)}cc 0%, transparent 60%);`"
                                aria-hidden="true"
                            ></div>
                        </div>

                        <div class="p-6 flex flex-col flex-1">
                            <p
                                class="text-xs font-sans font-medium uppercase tracking-widest mb-2"
                                :style="`color: ${accentForCategory(post.category)};`"
                            >
                                {{ post.category }}
                            </p>
                            <h3
                                class="font-display font-semibold text-espresso group-hover:text-ember transition-colors duration-200 mb-3"
                                style="font-size: 1.1rem; line-height: 1.35;"
                            >
                                {{ post.title }}
                            </h3>
                            <p class="text-sm text-neutral-600 leading-relaxed flex-1 line-clamp-3">
                                {{ post.excerpt }}
                            </p>
                        </div>

                        <div class="px-6 pb-5 border-t border-neutral-100 pt-4 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-xs text-neutral-400">
                                <time :datetime="post.date">{{ formatDate(post.date) }}</time>
                                <span aria-hidden="true">·</span>
                                <span>{{ post.readingTime }} min</span>
                            </div>
                            <span
                                class="text-sm font-medium text-ember group-hover:gap-2 inline-flex items-center gap-1 transition-all duration-200"
                            >
                                Read →
                            </span>
                        </div>
                    </Link>
                </article>
            </div>

            <!-- Empty state -->
            <div
                v-else
                class="text-center py-16"
            >
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-neutral-100 mb-4">
                    <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <p class="font-display text-espresso text-lg mb-2">No posts in this category yet</p>
                <p class="text-neutral-500 text-sm">Check back soon, or browse all posts.</p>
                <button
                    class="mt-4 px-5 py-2 rounded-full text-sm font-medium bg-espresso text-cream-50 hover:bg-espresso-dark transition-colors"
                    @click="selectedCategory = 'All'"
                >
                    View all posts
                </button>
            </div>

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
