<script setup>
import { ref, onMounted, onUnmounted, nextTick, shallowRef, markRaw } from 'vue';
import { gsap } from 'gsap';
import AcademicProgrammesTab from './AcademicProgrammesTab.vue';
import TeacherProfilesTab from './TeacherProfilesTab.vue';
import TestimonialsTab from './TestimonialsTab.vue';

const tabs = [
    { id: 'programmes', label: 'Academic Programmes', component: markRaw(AcademicProgrammesTab) },
    { id: 'teachers', label: 'Our Educators', component: markRaw(TeacherProfilesTab) },
    { id: 'testimonials', label: 'Testimonials', component: markRaw(TestimonialsTab) },
];

const activeIndex = ref(0);
const isAnimating = ref(false);
const prefersReducedMotion = ref(false);

const tabListRef = ref(null);
const tabButtonRefs = ref([]);
const indicatorRef = ref(null);
const contentWrapperRef = ref(null);

const activeComponent = shallowRef(tabs[0].component);

function setTabButtonRef(el, index) {
    if (el) tabButtonRefs.value[index] = el;
}

function updateIndicator(animate = true) {
    const btn = tabButtonRefs.value[activeIndex.value];
    const container = tabListRef.value;
    if (!btn || !container || !indicatorRef.value) return;

    const btnRect = btn.getBoundingClientRect();
    const containerRect = container.getBoundingClientRect();

    const targetX = btnRect.left - containerRect.left;
    const targetWidth = btnRect.width;

    if (!animate || prefersReducedMotion.value) {
        gsap.set(indicatorRef.value, { x: targetX, width: targetWidth });
        return;
    }

    gsap.to(indicatorRef.value, {
        x: targetX,
        width: targetWidth,
        duration: 0.35,
        ease: 'power2.inOut',
    });
}

function switchTab(index) {
    if (index === activeIndex.value || isAnimating.value) return;

    isAnimating.value = true;
    const direction = index > activeIndex.value ? 1 : -1;
    activeIndex.value = index;

    updateIndicator(true);
    animateTabButton(index);

    if (prefersReducedMotion.value) {
        activeComponent.value = tabs[index].component;
        isAnimating.value = false;
        return;
    }

    const wrapper = contentWrapperRef.value;
    if (!wrapper) {
        activeComponent.value = tabs[index].component;
        isAnimating.value = false;
        return;
    }

    gsap.to(wrapper, {
        opacity: 0,
        x: -30 * direction,
        duration: 0.2,
        ease: 'power2.in',
        onComplete() {
            activeComponent.value = tabs[index].component;

            nextTick(() => {
                gsap.set(wrapper, { opacity: 0, x: 30 * direction });
                gsap.to(wrapper, {
                    opacity: 1,
                    x: 0,
                    duration: 0.35,
                    ease: 'power2.out',
                    onComplete() {
                        animateCards();
                        isAnimating.value = false;
                    },
                });
            });
        },
    });
}

function animateTabButton(index) {
    const btn = tabButtonRefs.value[index];
    if (!btn || prefersReducedMotion.value) return;

    gsap.fromTo(btn,
        { scale: 0.95 },
        { scale: 1, duration: 0.2, ease: 'power2.out' },
    );
}

function animateCards() {
    if (prefersReducedMotion.value || !contentWrapperRef.value) return;

    const cards = contentWrapperRef.value.querySelectorAll(
        '.programme-card, .teacher-card, .testimonial-card',
    );
    if (!cards.length) return;

    gsap.fromTo(cards,
        { opacity: 0, y: 16 },
        {
            opacity: 1,
            y: 0,
            duration: 0.4,
            stagger: 0.08,
            ease: 'power2.out',
        },
    );
}

function handleKeydown(event) {
    const { key } = event;
    let newIndex = activeIndex.value;

    if (key === 'ArrowRight' || key === 'ArrowDown') {
        event.preventDefault();
        newIndex = (activeIndex.value + 1) % tabs.length;
    } else if (key === 'ArrowLeft' || key === 'ArrowUp') {
        event.preventDefault();
        newIndex = (activeIndex.value - 1 + tabs.length) % tabs.length;
    } else if (key === 'Home') {
        event.preventDefault();
        newIndex = 0;
    } else if (key === 'End') {
        event.preventDefault();
        newIndex = tabs.length - 1;
    }

    if (newIndex !== activeIndex.value) {
        switchTab(newIndex);
        nextTick(() => {
            tabButtonRefs.value[newIndex]?.focus();
        });
    }
}

let resizeObserver = null;

onMounted(() => {
    prefersReducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    nextTick(() => {
        updateIndicator(false);
        animateCards();
    });

    resizeObserver = new ResizeObserver(() => {
        updateIndicator(false);
    });
    if (tabListRef.value) {
        resizeObserver.observe(tabListRef.value);
    }
});

onUnmounted(() => {
    resizeObserver?.disconnect();
});
</script>

<template>
    <section
        id="about-tabs-section"
        class="bg-neutral-50 py-16 sm:py-24"
        aria-labelledby="about-tabs-heading"
    >
        <h2 id="about-tabs-heading" class="sr-only">About Aletheia Resource Center</h2>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Tab Navigation -->
            <div class="flex justify-center mb-12 sm:mb-16">
                <div
                    ref="tabListRef"
                    role="tablist"
                    aria-label="About sections"
                    class="relative inline-flex items-center bg-espresso/8 border border-espresso/20 rounded-full p-1.5 shadow-inner"
                    style="background-color: rgba(62,30,13,0.07);"
                    @keydown="handleKeydown"
                >
                    <!-- Sliding Indicator -->
                    <div
                        ref="indicatorRef"
                        class="absolute top-1.5 left-0 h-[calc(100%-12px)] bg-espresso rounded-full shadow-md pointer-events-none"
                        aria-hidden="true"
                    ></div>

                    <!-- Tab Buttons -->
                    <button
                        v-for="(tab, index) in tabs"
                        :key="tab.id"
                        :ref="(el) => setTabButtonRef(el, index)"
                        role="tab"
                        :id="`tab-${tab.id}`"
                        :aria-selected="activeIndex === index"
                        :aria-controls="`panel-${tab.id}`"
                        :tabindex="activeIndex === index ? 0 : -1"
                        :class="[
                            'relative z-10 px-5 sm:px-7 py-2.5 sm:py-3 text-sm sm:text-base font-sans font-semibold rounded-full transition-colors duration-200 whitespace-nowrap select-none',
                            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson focus-visible:ring-offset-2',
                            activeIndex === index
                                ? 'text-cream-50'
                                : 'text-espresso/70 hover:text-espresso',
                        ]"
                        @click="switchTab(index)"
                    >
                        {{ tab.label }}
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div
                :id="`panel-${tabs[activeIndex].id}`"
                role="tabpanel"
                :aria-labelledby="`tab-${tabs[activeIndex].id}`"
            >
                <div
                    ref="contentWrapperRef"
                    class="min-h-[50vh]"
                >
                    <component :is="activeComponent" />
                </div>
            </div>
        </div>
    </section>
</template>
