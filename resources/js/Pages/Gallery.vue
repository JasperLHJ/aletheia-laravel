<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HeroSection from '@/Pages/Gallery/HeroSection.vue';
import GalleryGrid from '@/Pages/Gallery/GalleryGrid.vue';
import { onMounted, onUnmounted, ref } from 'vue';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

defineProps({
    pageContent: {
        type: Object,
        required: true,
    },
});

const prefersReducedMotion = ref(false);
let scrollTriggerInstances = [];

onMounted(() => {
    prefersReducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion.value) return;

    const heroTl = gsap.timeline({ delay: 0.1 });
    heroTl
        .from('.gallery-hero-eyebrow', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' })
        .from('.gallery-hero-title', { y: 30, opacity: 0, duration: 0.7, ease: 'power2.out' }, '-=0.3')
        .from('.gallery-hero-subtitle', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' }, '-=0.4');

    const st1 = ScrollTrigger.create({
        trigger: '#gallery-grid-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.from('#gallery-grid-section', {
                opacity: 0,
                y: 30,
                duration: 0.7,
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
    <Head :title="pageContent.meta.title" />

    <PublicLayout>
        <HeroSection :hero="pageContent.hero" />
        <GalleryGrid :grid="pageContent.grid" />
    </PublicLayout>
</template>
