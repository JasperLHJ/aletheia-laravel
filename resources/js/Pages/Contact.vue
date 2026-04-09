<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HeroSection from '@/Pages/Contact/HeroSection.vue';
import CtaSection from '@/Pages/Contact/CtaSection.vue';
import VisitInfoSection from '@/Pages/Contact/VisitInfoSection.vue';
import MapSection from '@/Pages/Contact/MapSection.vue';
import ContactFormSection from '@/Pages/Contact/ContactFormSection.vue';
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
        .from('.contact-hero-eyebrow', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' })
        .from('.contact-hero-title', { y: 30, opacity: 0, duration: 0.7, ease: 'power2.out' }, '-=0.3')
        .from('.contact-hero-subtitle', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' }, '-=0.4');

    const st1 = ScrollTrigger.create({
        trigger: '#contact-cta-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.from('.cta-card', {
                y: 40,
                opacity: 0,
                duration: 0.7,
                stagger: 0.15,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st1);

    const st2 = ScrollTrigger.create({
        trigger: '#contact-visit-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.from('.visit-info-card', {
                y: 30,
                opacity: 0,
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
            gsap.from('#contact-map-section', {
                opacity: 0,
                y: 20,
                duration: 0.7,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st3);

    const st4 = ScrollTrigger.create({
        trigger: '#contact-form-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.from('#contact-form-section', {
                opacity: 0,
                y: 30,
                duration: 0.8,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st4);
});

onUnmounted(() => {
    scrollTriggerInstances.forEach(st => st.kill());
    ScrollTrigger.getAll().forEach(st => st.kill());
});
</script>

<template>
    <Head title="Contact — Aletheia Resource Center" />

    <PublicLayout>
        <HeroSection />
        <CtaSection />
        <VisitInfoSection />
        <MapSection />
        <ContactFormSection />
    </PublicLayout>
</template>
