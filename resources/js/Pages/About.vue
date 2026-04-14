<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    testimonials: {
        type: Array,
        default: () => [],
    },
    principal: {
        type: Object,
        default: null,
    },
    teachers: {
        type: Array,
        default: () => [],
    },
    pageContent: {
        type: Object,
        required: true,
    },
});
import HeroSection from '@/Pages/About/HeroSection.vue';
import AboutTabs from '@/Pages/About/AboutTabs.vue';
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
        .from('.about-hero-eyebrow', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' })
        .from('.about-hero-title', { y: 30, opacity: 0, duration: 0.7, ease: 'power2.out' }, '-=0.3')
        .from('.about-hero-subtitle', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' }, '-=0.4');

    const st1 = ScrollTrigger.create({
        trigger: '#about-tabs-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.from('#about-tabs-section', {
                opacity: 0,
                y: 30,
                duration: 1.1,
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
    <Head :title="props.pageContent.meta.title" />

    <PublicLayout>
        <HeroSection :hero="props.pageContent.hero" />
        <AboutTabs
            :page-content="props.pageContent"
            :testimonials="props.testimonials"
            :principal="props.principal"
            :teachers="props.teachers"
        />
    </PublicLayout>
</template>
