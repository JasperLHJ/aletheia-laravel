<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HeroSection from '@/Pages/Programmes/HeroSection.vue';
import ProgrammeOverviewSection from '@/Pages/Programmes/ProgrammeOverviewSection.vue';
import CurriculumDeepDive from '@/Pages/Programmes/CurriculumDeepDive.vue';
import WhyChooseSection from '@/Pages/Programmes/WhyChooseSection.vue';
import EnquiryCta from '@/Pages/Programmes/EnquiryCta.vue';
import { onMounted, onUnmounted, ref } from 'vue';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const prefersReducedMotion = ref(false);
let scrollTriggerInstances = [];

onMounted(() => {
    prefersReducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion.value) return;

    // Hero entrance
    const heroTl = gsap.timeline({ delay: 0.1 });
    heroTl
        .from('.programmes-hero-eyebrow', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' })
        .from('.programmes-hero-title', { y: 35, opacity: 0, duration: 0.7, ease: 'power2.out' }, '-=0.3')
        .from('.programmes-hero-subtitle', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' }, '-=0.4')
        .from('.programmes-hero-ctas', { y: 20, opacity: 0, duration: 0.5, ease: 'power2.out' }, '-=0.3')
        .from('.programmes-hero-pills', { y: 15, opacity: 0, duration: 0.5, ease: 'power2.out' }, '-=0.2')
        .from('.programmes-scroll-indicator', { opacity: 0, duration: 0.5 }, '-=0.1');

    // Overview cards stagger
    const st1 = ScrollTrigger.create({
        trigger: '#programme-overview',
        start: 'top 78%',
        onEnter: () => {
            gsap.from('.programme-overview-card', {
                y: 40,
                opacity: 0,
                duration: 0.7,
                stagger: 0.18,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st1);

    // Deep dive rows — alternating slide-in
    const deepDiveRows = document.querySelectorAll('.deepdive-row');
    deepDiveRows.forEach((row, index) => {
        const imageEl = row.querySelector('.deepdive-image');
        const contentEl = row.querySelector('.deepdive-content');
        const isEven = index % 2 === 0;

        if (imageEl) {
            const st = ScrollTrigger.create({
                trigger: row,
                start: 'top 80%',
                onEnter: () => {
                    gsap.from(imageEl, {
                        x: isEven ? -50 : 50,
                        opacity: 0,
                        duration: 0.8,
                        ease: 'power2.out',
                    });
                    if (contentEl) {
                        gsap.from(contentEl, {
                            x: isEven ? 50 : -50,
                            opacity: 0,
                            duration: 0.8,
                            ease: 'power2.out',
                            delay: 0.1,
                        });
                    }
                },
                once: true,
            });
            scrollTriggerInstances.push(st);
        }
    });

    // Why choose cards stagger
    const st2 = ScrollTrigger.create({
        trigger: '#why-aletheia',
        start: 'top 78%',
        onEnter: () => {
            gsap.from('.why-card', {
                y: 30,
                opacity: 0,
                duration: 0.6,
                stagger: 0.1,
                ease: 'power2.out',
            });
        },
        once: true,
    });
    scrollTriggerInstances.push(st2);

    // CTA section
    const st3 = ScrollTrigger.create({
        trigger: '#programmes-enquiry-cta',
        start: 'top 82%',
        onEnter: () => {
            gsap.from('.cta-content', {
                y: 25,
                opacity: 0,
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
    <Head title="Academic Programmes — Aletheia Resource Center" />

    <PublicLayout>
        <HeroSection />
        <ProgrammeOverviewSection />
        <CurriculumDeepDive />
        <WhyChooseSection />
        <EnquiryCta />
    </PublicLayout>
</template>
