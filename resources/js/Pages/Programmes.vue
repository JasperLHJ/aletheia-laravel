<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HeroSection from '@/Pages/Programmes/HeroSection.vue';
import ProgrammeOverviewSection from '@/Pages/Programmes/ProgrammeOverviewSection.vue';
import CurriculumDeepDive from '@/Pages/Programmes/CurriculumDeepDive.vue';
import WhyChooseSection from '@/Pages/Programmes/WhyChooseSection.vue';
import EnquiryCta from '@/Pages/Programmes/EnquiryCta.vue';
import { onMounted, onUnmounted, ref, nextTick } from 'vue';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const props = defineProps({
    pageContent: {
        type: Object,
        required: true,
    },
});

const prefersReducedMotion = ref(false);
const showSubNav = ref(false);
const activeSection = ref('');
let scrollTriggerInstances = [];

const subNavItems = [
    { id: 'primary-programme', label: 'Primary', dotClass: 'bg-sage' },
    { id: 'secondary-programme', label: 'Secondary', dotClass: 'bg-ember' },
    { id: 'preuniversity-programme', label: 'Pre-University', dotClass: 'bg-gold' },
];

function onScroll() {
    // Show sub-nav once hero has scrolled off
    showSubNav.value = window.scrollY > window.innerHeight * 0.6;

    // Track which programme section is in view
    const sections = ['preuniversity-programme', 'secondary-programme', 'primary-programme'];
    for (const id of sections) {
        const el = document.getElementById(id);
        if (!el) continue;
        if (el.getBoundingClientRect().top <= 120) {
            activeSection.value = id;
            break;
        }
    }
    if (window.scrollY < window.innerHeight * 0.6) activeSection.value = '';
}

onMounted(() => {
    prefersReducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    window.addEventListener('scroll', onScroll, { passive: true });

    nextTick(() => {
        if (prefersReducedMotion.value) return;

        const heroTl = gsap.timeline({ delay: 0.1 });
        heroTl
            .from('.programmes-hero-eyebrow', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' })
            .from('.programmes-hero-title', { y: 35, opacity: 0, duration: 0.7, ease: 'power2.out' }, '-=0.3')
            .from('.programmes-hero-subtitle', { y: 20, opacity: 0, duration: 0.6, ease: 'power2.out' }, '-=0.4')
            .from('.programmes-hero-ctas', { y: 20, opacity: 0, duration: 0.5, ease: 'power2.out' }, '-=0.3')
            .from('.programmes-hero-pills', { y: 15, opacity: 0, duration: 0.5, ease: 'power2.out' }, '-=0.2')
            .from('.programmes-scroll-indicator', { opacity: 0, duration: 0.5 }, '-=0.1');

        gsap.set('.programme-overview-card', { y: 40, opacity: 0 });
        gsap.set('.why-card', { y: 30, opacity: 0 });
        gsap.set('.cta-content', { y: 25, opacity: 0 });

        const deepDiveRows = document.querySelectorAll('.deepdive-row');
        deepDiveRows.forEach((row, index) => {
            const imageEl = row.querySelector('.deepdive-image');
            const contentEl = row.querySelector('.deepdive-content');
            const isEven = index % 2 === 0;
            if (imageEl) gsap.set(imageEl, { x: isEven ? -50 : 50, opacity: 0 });
            if (contentEl) gsap.set(contentEl, { x: isEven ? 50 : -50, opacity: 0 });
        });

        const st1 = ScrollTrigger.create({
            trigger: '#programme-overview',
            start: 'top 85%',
            onEnter: () => {
                gsap.to('.programme-overview-card', {
                    y: 0, opacity: 1, duration: 0.7, stagger: 0.18,
                    ease: 'power2.out', clearProps: 'transform,opacity',
                });
            },
            once: true,
        });
        scrollTriggerInstances.push(st1);

        deepDiveRows.forEach((row) => {
            const imageEl = row.querySelector('.deepdive-image');
            const contentEl = row.querySelector('.deepdive-content');
            if (imageEl) {
                const st = ScrollTrigger.create({
                    trigger: row,
                    start: 'top 85%',
                    onEnter: () => {
                        gsap.to(imageEl, { x: 0, opacity: 1, duration: 0.8, ease: 'power2.out', clearProps: 'transform,opacity' });
                        if (contentEl) {
                            gsap.to(contentEl, { x: 0, opacity: 1, duration: 0.8, ease: 'power2.out', delay: 0.1, clearProps: 'transform,opacity' });
                        }
                    },
                    once: true,
                });
                scrollTriggerInstances.push(st);
            }
        });

        const st2 = ScrollTrigger.create({
            trigger: '#why-aletheia',
            start: 'top 85%',
            onEnter: () => {
                gsap.to('.why-card', { y: 0, opacity: 1, duration: 0.6, stagger: 0.1, ease: 'power2.out', clearProps: 'transform,opacity' });
            },
            once: true,
        });
        scrollTriggerInstances.push(st2);

        const st3 = ScrollTrigger.create({
            trigger: '#programmes-enquiry-cta',
            start: 'top 90%',
            onEnter: () => {
                gsap.to('.cta-content', { y: 0, opacity: 1, duration: 0.7, ease: 'power2.out', clearProps: 'transform,opacity' });
            },
            once: true,
        });
        scrollTriggerInstances.push(st3);
    });
});

onUnmounted(() => {
    window.removeEventListener('scroll', onScroll);
    scrollTriggerInstances.forEach(st => st.kill());
    ScrollTrigger.getAll().forEach(st => st.kill());
});
</script>

<template>
    <Head :title="pageContent.meta.title" />

    <PublicLayout>
        <!-- Sticky programme sub-nav — appears after hero scrolls off -->
        <Transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="-translate-y-full opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="-translate-y-full opacity-0"
        >
            <nav
                v-if="showSubNav"
                class="fixed top-[var(--nav-height,64px)] left-0 right-0 z-50 bg-espresso/95 backdrop-blur-sm border-b border-white/10 shadow-lg"
                aria-label="Jump to programme"
            >
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <ul class="flex items-center gap-1 overflow-x-auto scrollbar-none py-0" role="list">
                        <li
                            v-for="item in subNavItems"
                            :key="item.id"
                        >
                            <a
                                :href="`#${item.id}`"
                                class="inline-flex items-center gap-2 px-4 py-3 text-xs font-semibold font-sans uppercase tracking-wider transition-colors duration-150 whitespace-nowrap border-b-2"
                                :class="activeSection === item.id
                                    ? 'text-white border-gold'
                                    : 'text-white/50 border-transparent hover:text-white/80 hover:border-white/20'"
                            >
                                <span :class="['w-2 h-2 rounded-full shrink-0', item.dotClass]" aria-hidden="true"></span>
                                {{ item.label }}
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </Transition>

        <HeroSection :hero="pageContent.hero" />
        <ProgrammeOverviewSection :overview="pageContent.overview" />
        <CurriculumDeepDive :deep-dive="pageContent.deepDive" />
        <WhyChooseSection :why="pageContent.whyChoose" />
        <EnquiryCta :cta="pageContent.enquiryCta" />
    </PublicLayout>
</template>
