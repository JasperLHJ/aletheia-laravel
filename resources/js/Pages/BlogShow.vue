<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import BlogPostSection from '@/Pages/Blog/BlogPostSection.vue';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    relatedPosts: {
        type: Array,
        default: () => [],
    },
});

const pageTitle = computed(() => `${props.post.title} — Aletheia Resource Center`);

const prefersReducedMotion = ref(false);
let scrollTriggerInstances = [];

onMounted(() => {
    prefersReducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion.value) return;

    const entryTl = gsap.timeline({ delay: 0.15 });
    entryTl
        .from('.blog-post-breadcrumb', { y: 10, opacity: 0, duration: 0.5, ease: 'power2.out' })
        .from('.blog-post-content', { y: 30, opacity: 0, duration: 0.7, ease: 'power2.out' }, '-=0.3')
        .from('.blog-post-sidebar', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' }, '-=0.4');

    const st1 = ScrollTrigger.create({
        trigger: '.blog-post-share',
        start: 'top 90%',
        onEnter: () => {
            gsap.from('.blog-post-share', {
                opacity: 0,
                y: 15,
                duration: 0.5,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st1);
});

onUnmounted(() => {
    scrollTriggerInstances.forEach(st => st.kill());
    ScrollTrigger.getAll().forEach(st => st.kill());
});
</script>

<template>
    <Head :title="pageTitle" />

    <PublicLayout>
        <BlogPostSection :post="post" :related-posts="relatedPosts" />
    </PublicLayout>
</template>
