<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HeroSection from '@/Pages/Contact/HeroSection.vue';
import CtaSection from '@/Pages/Contact/CtaSection.vue';
import VisitInfoSection from '@/Pages/Contact/VisitInfoSection.vue';
import MapSection from '@/Pages/Contact/MapSection.vue';
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

    if (prefersReducedMotion.value) {
        gsap.set('.cta-card', { opacity: 1, y: 0 });
        return;
    }

    // Pre-hide all scroll-animated elements so they don't flash before their trigger fires
    gsap.set('.contact-hero-eyebrow, .contact-hero-title, .contact-hero-subtitle', { opacity: 0, y: 20 });
    // .cta-card initial state is set via inline styles in CtaSection.vue to prevent flash
    gsap.set('.visit-info-card', { opacity: 0, y: 30 });
    gsap.set('#contact-map-section', { opacity: 0, y: 20 });

    const heroTl = gsap.timeline({ delay: 0.1 });
    heroTl
        .to('.contact-hero-eyebrow', { y: 0, opacity: 1, duration: 0.6, ease: 'power2.out' })
        .to('.contact-hero-title', { y: 0, opacity: 1, duration: 0.7, ease: 'power2.out' }, '-=0.3')
        .to('.contact-hero-subtitle', { y: 0, opacity: 1, duration: 0.6, ease: 'power2.out' }, '-=0.4');

    const st1 = ScrollTrigger.create({
        trigger: '#contact-cta-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.fromTo('.cta-card',
                { opacity: 0, y: 40 },
                { opacity: 1, y: 0, duration: 0.7, stagger: 0.15, ease: 'power2.out' }
            );
        },
        once: true,
    });
    scrollTriggerInstances.push(st1);

    const st2 = ScrollTrigger.create({
        trigger: '#contact-visit-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.to('.visit-info-card', {
                y: 0,
                opacity: 1,
                duration: 0.7,
                stagger: 0.15,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st2);

    const st3 = ScrollTrigger.create({
        trigger: '#contact-map-section',
        start: 'top 85%',
        onEnter: () => {
            gsap.to('#contact-map-section', {
                opacity: 1,
                y: 0,
                duration: 0.7,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st3);

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
        <CtaSection :cta-section="pageContent.ctaSection" />
        <VisitInfoSection :visit="pageContent.visit" />
        <MapSection :map="pageContent.map" />
    </PublicLayout>
</template>
