<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    featuredTestimonials: {
        type: Array,
        default: () => [],
    },
    pageContent: {
        type: Object,
        required: true,
    },
});
import HeroSection from '@/Pages/Welcome/HeroSection.vue';
import StatsBarSection from '@/Pages/Welcome/StatsBarSection.vue';
import HighlightsSection from '@/Pages/Welcome/HighlightsSection.vue';
import GallerySection from '@/Pages/Welcome/GallerySection.vue';
import TestimonialsSection from '@/Pages/Welcome/TestimonialsSection.vue';
import EnquiryCtaSection from '@/Pages/Welcome/EnquiryCtaSection.vue';
import SocialSection from '@/Pages/Welcome/SocialSection.vue';
import { onMounted, onUnmounted, ref } from 'vue';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const prefersReducedMotion = ref(false);
const statsBarRef = ref(null);

let scrollTriggerInstances = [];

onMounted(() => {
    prefersReducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    gsap.set('.social-icon-link', { opacity: 0, y: 16, willChange: 'opacity, transform' });

    if (prefersReducedMotion.value) {
        gsap.set('.social-icon-link', { opacity: 1, y: 0, willChange: 'auto' });
        return;
    }

    // Pre-hide scroll-revealed blocks so they are not fully visible until ScrollTrigger runs.
    gsap.set('#gallery-section', { opacity: 0, y: 30, willChange: 'opacity, transform' });
    gsap.set('.cta-content', { opacity: 0, y: 25, willChange: 'opacity, transform' });

    // Hero animations are handled inside HeroSection.vue

    const st1 = ScrollTrigger.create({
        trigger: '#stats-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.from('.stat-item', {
                y: 30,
                opacity: 0,
                duration: 0.7,
                stagger: 0.15,
                ease: 'power2.out',
            });

            // Animate numeric counters
            if (statsBarRef.value) {
                const { stats, display } = statsBarRef.value;
                stats.forEach((stat, i) => {
                    gsap.to(display[i], {
                        value: stat.numericValue,
                        duration: 1.4,
                        ease: 'power2.out',
                        delay: i * 0.15,
                    });
                });
            }
        },
        once: true,
    });
    scrollTriggerInstances.push(st1);

    const st2 = ScrollTrigger.create({
        trigger: '#highlights-section',
        start: 'top 75%',
        onEnter: () => {
            gsap.from('.highlight-card', {
                y: 40,
                opacity: 0,
                duration: 0.7,
                stagger: 0.2,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st2);

    const st3 = ScrollTrigger.create({
        trigger: '#gallery-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.to('#gallery-section', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power2.out',
                onComplete() {
                    gsap.set('#gallery-section', { clearProps: 'willChange' });
                },
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st3);

    const st4 = ScrollTrigger.create({
        trigger: '#testimonial-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.from('.testimonial-content', {
                y: 30,
                opacity: 0,
                duration: 0.7,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st4);

    const st5 = ScrollTrigger.create({
        trigger: '#cta-section',
        start: 'top 80%',
        onEnter: () => {
            gsap.to('.cta-content', {
                opacity: 1,
                y: 0,
                duration: 0.6,
                ease: 'power2.out',
                onComplete() {
                    gsap.set('.cta-content', { clearProps: 'willChange' });
                },
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st5);

    const st6 = ScrollTrigger.create({
        trigger: '#social-section',
        start: 'top 90%',
        onEnter: () => {
            gsap.to('.social-icon-link', {
                opacity: 1,
                y: 0,
                duration: 0.5,
                stagger: 0.1,
                ease: 'power2.out',
                onComplete() {
                    gsap.set('.social-icon-link', { clearProps: 'willChange' });
                },
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st6);
});

onUnmounted(() => {
    scrollTriggerInstances.forEach(st => st.kill());
    ScrollTrigger.getAll().forEach(st => st.kill());
});
</script>

<template>
    <Head :title="props.pageContent.meta.title" />

    <PublicLayout>
        <HeroSection :content="props.pageContent.hero" />
        <StatsBarSection ref="statsBarRef" :content="props.pageContent.stats" />
        <HighlightsSection :content="props.pageContent.highlights" />
        <GallerySection :content="props.pageContent.galleryTeaser" />
        <TestimonialsSection
            :testimonials="props.featuredTestimonials"
            :copy="props.pageContent.testimonials"
        />
        <EnquiryCtaSection :content="props.pageContent.enquiryCta" />
        <SocialSection :content="props.pageContent.social" />
    </PublicLayout>
</template>
