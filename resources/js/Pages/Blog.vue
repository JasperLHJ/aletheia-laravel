<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HeroSection from '@/Pages/Blog/HeroSection.vue';
import BlogListingSection from '@/Pages/Blog/BlogListingSection.vue';
import { onMounted, onUnmounted, ref } from 'vue';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const prefersReducedMotion = ref(false);
let scrollTriggerInstances = [];

onMounted(() => {
    prefersReducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion.value) return;

    const heroTl = gsap.timeline({ delay: 0.1 });
    heroTl
        .from('.blog-hero-eyebrow', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' })
        .from('.blog-hero-title', { y: 30, opacity: 0, duration: 0.7, ease: 'power2.out' }, '-=0.3')
        .from('.blog-hero-subtitle', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' }, '-=0.4')
        .from('.blog-hero-pills', { y: 15, opacity: 0, duration: 0.5, ease: 'power2.out' }, '-=0.3');

    const st1 = ScrollTrigger.create({
        trigger: '#blog-listing-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.from('.blog-featured-post', {
                y: 40,
                opacity: 0,
                duration: 0.8,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st1);

    const st2 = ScrollTrigger.create({
        trigger: '.blog-card',
        start: 'top 85%',
        onEnter: () => {
            gsap.from('.blog-card', {
                y: 40,
                opacity: 0,
                duration: 0.7,
                stagger: 0.12,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st2);
});

onUnmounted(() => {
    scrollTriggerInstances.forEach(st => st.kill());
    ScrollTrigger.getAll().forEach(st => st.kill());
});
</script>

<template>
    <Head title="Blog — Aletheia Resource Center" />

    <PublicLayout>
        <HeroSection />
        <BlogListingSection />
    </PublicLayout>
</template>
