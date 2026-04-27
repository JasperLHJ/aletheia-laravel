<script setup>
import { computed, ref, onMounted, onUnmounted, nextTick, markRaw } from 'vue';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

/** ScrollTriggers for teacher grid cards (principal card animates without scroll). */
let teacherCardScrollTriggers = [];
import AcademicProgrammesTab from './AcademicProgrammesTab.vue';
import TeacherProfilesTab from './TeacherProfilesTab.vue';
import TestimonialsTab from './TestimonialsTab.vue';

const componentById = {
    programmes: markRaw(AcademicProgrammesTab),
    teachers: markRaw(TeacherProfilesTab),
    testimonials: markRaw(TestimonialsTab),
};

const props = defineProps({
    pageContent: {
        type: Object,
        required: true,
    },
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
});

const tabs = computed(() =>
    props.pageContent.tabs.map((t) => ({
        id: t.id,
        label: t.label,
        component: componentById[t.id],
    })),
);

const activeIndex = ref(0);
const isAnimating = ref(false);
const prefersReducedMotion = ref(false);

const tabListRef = ref(null);
const tabButtonRefs = ref([]);
const indicatorRef = ref(null);
const contentWrapperRef = ref(null);

const activeComponent = computed(() => tabs.value[activeIndex.value]?.component ?? componentById.programmes);

const activeTabProps = computed(() => {
    const id = tabs.value[activeIndex.value]?.id;
    if (id === 'testimonials') {
        return { testimonials: props.testimonials, copy: props.pageContent.testimonialsTab };
    }
    if (id === 'teachers') {
        return {
            principal: props.principal,
            teachers: props.teachers,
            copy: props.pageContent.educators,
        };
    }
    if (id === 'programmes') {
        return { content: props.pageContent.academicProgrammes };
    }
    return {};
});

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
        isAnimating.value = false;
        return;
    }

    const wrapper = contentWrapperRef.value;
    if (!wrapper) {
        isAnimating.value = false;
        return;
    }

    gsap.to(wrapper, {
        opacity: 0,
        x: -30 * direction,
        duration: 0.2,
        ease: 'power2.in',
        onComplete() {
            nextTick(() => {
                // Pre-hide cards so they don't flash before their stagger animation
                const cards = wrapper.querySelectorAll('.programme-card, .testimonial-card, .teacher-card');
                gsap.set(cards, { opacity: 0, y: 16 });

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

function killTeacherCardScrollTriggers() {
    teacherCardScrollTriggers.forEach((st) => st.kill());
    teacherCardScrollTriggers = [];
}

/** Principal spotlight: smooth intro; other teacher cards reveal on scroll. */
function animateTeacherProfileCards(wrapper) {
    killTeacherCardScrollTriggers();

    const teacherCards = wrapper.querySelectorAll('.teacher-card');
    if (!teacherCards.length) return;

    const [firstCard, ...restCards] = teacherCards;

    gsap.fromTo(
        firstCard,
        { opacity: 0, y: 28 },
        {
            opacity: 1,
            y: 0,
            duration: 0.7,
            ease: 'power2.out',
        },
    );

    restCards.forEach((card) => {
        gsap.set(card, { opacity: 0, y: 22 });
        const st = ScrollTrigger.create({
            trigger: card,
            start: 'top 88%',
            once: true,
            onEnter: () => {
                gsap.to(card, {
                    opacity: 1,
                    y: 0,
                    duration: 0.55,
                    ease: 'power2.out',
                });
            },
        });
        teacherCardScrollTriggers.push(st);
    });

    nextTick(() => ScrollTrigger.refresh());
}

function animateCards() {
    if (prefersReducedMotion.value || !contentWrapperRef.value) return;

    const wrapper = contentWrapperRef.value;
    const teacherCards = wrapper.querySelectorAll('.teacher-card');

    if (teacherCards.length) {
        animateTeacherProfileCards(wrapper);
        return;
    }

    killTeacherCardScrollTriggers();

    const cards = wrapper.querySelectorAll('.programme-card, .testimonial-card');
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
        newIndex = (activeIndex.value + 1) % tabs.value.length;
    } else if (key === 'ArrowLeft' || key === 'ArrowUp') {
        event.preventDefault();
        newIndex = (activeIndex.value - 1 + tabs.value.length) % tabs.value.length;
    } else if (key === 'Home') {
        event.preventDefault();
        newIndex = 0;
    } else if (key === 'End') {
        event.preventDefault();
        newIndex = tabs.value.length - 1;
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

        // Pre-hide cards before the entrance animation so they don't flash
        if (contentWrapperRef.value) {
            const cards = contentWrapperRef.value.querySelectorAll('.programme-card, .testimonial-card, .teacher-card');
            gsap.set(cards, { opacity: 0, y: 16 });
        }

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
    killTeacherCardScrollTriggers();
    resizeObserver?.disconnect();
});
</script>

<template>
    <section
        id="about-tabs-section"
        class="bg-purple-gray-50 py-16 sm:py-24"
        aria-labelledby="about-tabs-heading"
    >
        <h2 id="about-tabs-heading" class="sr-only">About Aletheia Resource Center</h2>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Tab Navigation: scroll horizontally on narrow viewports so labels do not overflow -->
            <div class="mb-12 sm:mb-16 w-full min-w-0 -mx-4 px-4 sm:mx-0 sm:px-0">
                <div
                    class="w-full max-w-full overflow-x-auto overflow-y-visible overscroll-x-contain touch-pan-x [scrollbar-width:thin] [&::-webkit-scrollbar]:h-1.5"
                >
                    <div class="flex justify-center min-w-full w-max mx-auto pb-1">
                        <div
                            ref="tabListRef"
                            role="tablist"
                            aria-label="About sections"
                            class="relative inline-flex shrink-0 items-center bg-purple-gray-800/8 border border-purple-gray-800/20 rounded-full p-1.5 shadow-inner"
                            style="background-color: rgba(62,30,13,0.07);"
                            @keydown="handleKeydown"
                        >
                            <!-- Sliding Indicator -->
                            <div
                                ref="indicatorRef"
                                class="absolute top-1.5 left-0 h-[calc(100%-12px)] bg-purple-gray-800 rounded-full shadow-md pointer-events-none"
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
                                    'relative z-10 px-3.5 sm:px-5 md:px-7 py-2 sm:py-2.5 md:py-3 text-xs sm:text-sm md:text-base font-sans font-semibold rounded-full transition-colors duration-200 whitespace-nowrap select-none',
                                    'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-gray-500 focus-visible:ring-offset-2',
                                    activeIndex === index
                                        ? 'text-purple-gray-50'
                                        : 'text-purple-gray-800/70 hover:text-purple-gray-800',
                                ]"
                                @click="switchTab(index)"
                            >
                                {{ tab.label }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div
                :id="`panel-${tabs[activeIndex]?.id}`"
                role="tabpanel"
                :aria-labelledby="`tab-${tabs[activeIndex]?.id}`"
            >
                <div
                    ref="contentWrapperRef"
                    class="min-h-[50vh]"
                >
                    <component :is="activeComponent" v-bind="activeTabProps" />
                </div>
            </div>
        </div>
    </section>
</template>
