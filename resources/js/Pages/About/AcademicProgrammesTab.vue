<script setup>
import { ref } from 'vue';

const programmes = [
    {
        icon: `<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>`,
        eyebrow: 'Ages 5–11',
        title: 'Primary Programme',
        description: 'A strong foundation in literacy, numeracy, and critical thinking through an inquiry-based curriculum that nurtures curiosity and confidence in every child.',
        highlights: ['Cambridge Primary', 'STEM Integration', 'Character Education'],
        accentColor: 'bg-sage',
        accentText: 'text-sage',
        accentBorder: 'border-sage',
        hoverRing: 'hover:ring-sage',
        detail: {
            overview: 'Our Primary Programme is designed to instil a lifelong love of learning from the earliest years. Grounded in the Cambridge Primary framework, students explore the world through structured inquiry, collaborative projects, and discovery-based activities.',
            curriculum: [
                { subject: 'English & Literacy', desc: 'Phonics, comprehension, and creative writing with differentiated support.' },
                { subject: 'Mathematics', desc: 'Conceptual understanding through Singapore Math and manipulative-based learning.' },
                { subject: 'Sciences', desc: 'Hands-on experiments and STEM projects that build scientific curiosity.' },
                { subject: 'Humanities', desc: 'Age-appropriate history, geography, and cultural studies.' },
                { subject: 'Arts & Music', desc: 'Expressive arts fostering creativity and emotional intelligence.' },
                { subject: 'Physical Education', desc: 'Structured sports, movement, and wellness routines.' },
            ],
            assessment: 'Continuous portfolio-based assessment complemented by termly Cambridge-aligned examinations.',
            outcomes: ['Strong literacy and numeracy foundations', 'Inquisitive, self-directed learners', 'Collaborative social skills', 'Cambridge Primary Checkpoint qualification'],
        },
    },
    {
        icon: `<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>`,
        eyebrow: 'Ages 12–16',
        title: 'Secondary Programme',
        description: 'Rigorous academic preparation aligned with Cambridge IGCSE, developing analytical skills and subject mastery to prepare students for advanced study.',
        highlights: ['Cambridge IGCSE', 'Sciences & Humanities', 'Co-Curricular Excellence'],
        accentColor: 'bg-ember',
        accentText: 'text-ember',
        accentBorder: 'border-ember',
        hoverRing: 'hover:ring-ember',
        detail: {
            overview: 'The Secondary Programme prepares students for Cambridge IGCSE examinations while cultivating deep analytical thinking, independent research, and a breadth of academic interests.',
            curriculum: [
                { subject: 'Core Sciences', desc: 'Biology, Chemistry, and Physics with dedicated laboratory sessions.' },
                { subject: 'Mathematics & Additional Mathematics', desc: 'Rigorous problem-solving and algebraic reasoning.' },
                { subject: 'English Language & Literature', desc: 'Critical textual analysis and academic writing.' },
                { subject: 'Humanities', desc: 'History, Geography, and Economics with global case studies.' },
                { subject: 'Modern Languages', desc: 'Mandarin, Malay, and French language programmes.' },
                { subject: 'Co-Curricular Activities', desc: 'Structured CCA portfolio supporting holistic development.' },
            ],
            assessment: 'Cambridge IGCSE examinations at the end of Year 10/11, supplemented by internal termly assessments and project-based evaluations.',
            outcomes: ['Cambridge IGCSE qualifications (up to 10 subjects)', 'Strong university preparation', 'Leadership and communication skills', 'Breadth of academic and co-curricular achievements'],
        },
    },
    {
        icon: `<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" /></svg>`,
        eyebrow: 'Ages 17–18',
        title: 'Pre-University',
        description: 'Advanced pathways including Cambridge A-Levels, preparing students for admission to leading universities with personalised guidance and mentorship.',
        highlights: ['Cambridge A-Levels', 'University Counselling', 'Leadership Programmes'],
        accentColor: 'bg-gold',
        accentText: 'text-gold',
        accentBorder: 'border-gold',
        hoverRing: 'hover:ring-gold',
        detail: {
            overview: 'Our Pre-University Programme is a focused two-year track designed to maximise Cambridge A-Level results and secure admission to top universities worldwide. Students receive individualised mentorship, subject specialisation, and expert university counselling.',
            curriculum: [
                { subject: 'Sciences Track', desc: 'Mathematics, Physics, Chemistry, and Biology combinations.' },
                { subject: 'Humanities & Social Sciences Track', desc: 'Economics, Literature, History, and Psychology.' },
                { subject: 'Business & Commerce Track', desc: 'Business Studies, Economics, and Accounting.' },
                { subject: 'General Paper', desc: 'Critical thinking, essay writing, and current affairs analysis.' },
                { subject: 'Project Work', desc: 'Collaborative research and presentation skills.' },
                { subject: 'University Counselling', desc: 'Dedicated guidance for local and international university applications.' },
            ],
            assessment: 'Cambridge A-Level examinations (AS and A2), with internal mock examinations each semester and a dedicated university application portfolio.',
            outcomes: ['Cambridge A-Level qualifications', 'University admission to local and overseas institutions', 'Scholarship application support', 'Leadership and independent research credentials'],
        },
    },
];

const activeDialogIndex = ref(null);

function openDialog(index) {
    activeDialogIndex.value = index;
    document.body.style.overflow = 'hidden';
}

function closeDialog() {
    activeDialogIndex.value = null;
    document.body.style.overflow = '';
}

function handleBackdropClick(event) {
    if (event.target === event.currentTarget) closeDialog();
}

function handleDialogKeydown(event) {
    if (event.key === 'Escape') closeDialog();
}
</script>

<template>
    <div>
        <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
            <p class="text-xs font-sans font-medium text-ember uppercase tracking-widest mb-3">
                Our Curriculum
            </p>
            <h3
                class="font-display font-semibold text-espresso mb-4"
                style="font-size: clamp(1.6rem, 2.8vw, 2.1rem); line-height: 1.2;"
            >
                Academic Programmes
            </h3>
            <p class="text-neutral-600 leading-relaxed">
                From primary through pre-university, our Cambridge-aligned programmes
                develop critical thinkers prepared for a changing world.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-7">
            <article
                v-for="(programme, index) in programmes"
                :key="programme.title"
                tabindex="0"
                role="button"
                class="programme-card group relative bg-white rounded-2xl overflow-hidden border border-neutral-200/90 shadow-sm flex flex-col cursor-pointer outline-none transition-[transform,box-shadow,border-color,ring-color] duration-300 ease-out hover:-translate-y-1 hover:shadow-xl hover:border-transparent hover:ring-2 hover:ring-offset-2 hover:ring-offset-white focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-espresso focus-visible:ring-offset-white"
                :class="programme.hoverRing"
                @click="openDialog(index)"
                @keydown.enter.prevent="openDialog(index)"
                @keydown.space.prevent="openDialog(index)"
                :aria-label="`View full details for ${programme.title}`"
            >
                <!-- Accent bar -->
                <div :class="[programme.accentColor, 'h-1 w-full shrink-0']" aria-hidden="true"></div>

                <div class="p-6 sm:p-7 flex flex-col flex-1">
                    <!-- Icon + eyebrow -->
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            :class="[programme.accentColor, 'w-11 h-11 rounded-xl flex items-center justify-center text-white shrink-0 transition-transform duration-300 group-hover:scale-105']"
                            v-html="programme.icon"
                        ></div>
                        <p class="text-xs font-sans font-semibold text-neutral-500 uppercase tracking-widest">
                            {{ programme.eyebrow }}
                        </p>
                    </div>

                    <h4
                        class="font-display font-bold text-espresso mb-2.5"
                        style="font-size: 1.25rem; line-height: 1.3;"
                    >
                        {{ programme.title }}
                    </h4>

                    <p class="text-sm text-neutral-600 leading-relaxed flex-1 mb-4">
                        {{ programme.description }}
                    </p>

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2 mb-5">
                        <span
                            v-for="tag in programme.highlights"
                            :key="tag"
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-neutral-100 text-neutral-700"
                        >
                            {{ tag }}
                        </span>
                    </div>

                    <!-- Bottom CTA label -->
                    <div
                        class="mt-auto pt-4 border-t border-neutral-100 flex items-center justify-between gap-3 transition-colors duration-300 group-hover:border-neutral-200/80"
                    >
                        <span
                            :class="['text-sm font-semibold font-sans tracking-tight', programme.accentText]"
                        >
                            View programme details
                        </span>
                        <span
                            class="inline-flex items-center justify-center rounded-full p-1.5 text-neutral-400 transition-all duration-300 group-hover:text-current"
                            :class="programme.accentText"
                            aria-hidden="true"
                        >
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </div>
            </article>
        </div>

        <!-- View Full Programmes Page link -->
        <div class="mt-10 text-center">
            <a
                href="/programmes"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-espresso/20 text-sm font-semibold font-sans text-espresso hover:bg-espresso hover:text-cream-50 hover:border-espresso transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson focus-visible:ring-offset-2 min-h-[44px]"
            >
                View Full Programmes Page
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- Dialogs -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition-opacity duration-200 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-150 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="activeDialogIndex !== null"
                    class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center p-3 sm:p-6 pb-[max(0.75rem,env(safe-area-inset-bottom))]"
                    style="background-color: rgba(0,0,0,0.55); backdrop-filter: blur(2px);"
                    @click="handleBackdropClick"
                    @keydown="handleDialogKeydown"
                    tabindex="-1"
                    role="dialog"
                    aria-modal="true"
                    :aria-labelledby="`dialog-title-${activeDialogIndex}`"
                >
                    <Transition
                        enter-active-class="transition-all duration-250 ease-out"
                        enter-from-class="opacity-0 translate-y-4 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="transition-all duration-150 ease-in"
                        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-4 sm:scale-95"
                        appear
                    >
                        <div
                            v-if="activeDialogIndex !== null"
                            class="bg-white w-full sm:max-w-2xl rounded-2xl sm:rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[min(90dvh,calc(100vh-1.5rem))] sm:max-h-[min(85vh,calc(100vh-3rem))]"
                        >
                            <!-- Dialog Header -->
                            <div :class="[programmes[activeDialogIndex].accentColor, 'px-6 sm:px-8 pt-6 sm:pt-7 pb-4 sm:pb-5 shrink-0']">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-11 h-11 rounded-xl bg-white/20 flex items-center justify-center text-white shrink-0"
                                            v-html="programmes[activeDialogIndex].icon"
                                        ></div>
                                        <div>
                                            <p class="text-xs font-sans font-semibold text-white/75 uppercase tracking-widest mb-0.5">
                                                {{ programmes[activeDialogIndex].eyebrow }}
                                            </p>
                                            <h4
                                                :id="`dialog-title-${activeDialogIndex}`"
                                                class="font-display font-bold text-white"
                                                style="font-size: 1.35rem; line-height: 1.25;"
                                            >
                                                {{ programmes[activeDialogIndex].title }}
                                            </h4>
                                        </div>
                                    </div>
                                    <button
                                        class="shrink-0 w-9 h-9 rounded-full bg-white/15 hover:bg-white/25 flex items-center justify-center text-white transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white"
                                        @click="closeDialog"
                                        aria-label="Close dialogue"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Dialog Body (scrollable) -->
                            <div class="overflow-y-auto flex-1 min-h-0 overscroll-contain px-6 sm:px-8 py-5 sm:py-6 space-y-5 sm:space-y-6">
                                <!-- Overview -->
                                <div class="space-y-0">
                                    <p class="text-neutral-700 leading-relaxed text-[0.9375rem] sm:text-base">
                                        {{ programmes[activeDialogIndex].detail.overview }}
                                    </p>
                                </div>

                                <!-- Subjects -->
                                <div class="space-y-3 sm:space-y-4">
                                    <h5 class="font-display font-semibold text-espresso" style="font-size: 1.05rem;">
                                        Curriculum Areas
                                    </h5>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-3.5">
                                        <div
                                            v-for="item in programmes[activeDialogIndex].detail.curriculum"
                                            :key="item.subject"
                                            class="flex gap-3 p-3.5 sm:p-4 bg-neutral-50 rounded-xl border border-neutral-100"
                                        >
                                            <div :class="[programmes[activeDialogIndex].accentColor, 'w-1.5 rounded-full shrink-0 mt-0.5']" aria-hidden="true"></div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold font-sans text-espresso mb-0.5">{{ item.subject }}</p>
                                                <p class="text-xs text-neutral-600 leading-relaxed">{{ item.desc }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Assessment -->
                                <div class="bg-neutral-50 rounded-xl border border-neutral-100 p-4 sm:p-5 space-y-2">
                                    <h5 class="font-display font-semibold text-espresso" style="font-size: 1rem;">
                                        Assessment
                                    </h5>
                                    <p class="text-sm text-neutral-600 leading-relaxed">
                                        {{ programmes[activeDialogIndex].detail.assessment }}
                                    </p>
                                </div>

                                <!-- Outcomes -->
                                <div class="space-y-3 sm:space-y-4 pb-1">
                                    <h5 class="font-display font-semibold text-espresso" style="font-size: 1.05rem;">
                                        Student Outcomes
                                    </h5>
                                    <ul class="space-y-2 sm:space-y-2.5" role="list">
                                        <li
                                            v-for="outcome in programmes[activeDialogIndex].detail.outcomes"
                                            :key="outcome"
                                            class="flex items-start gap-3 text-sm text-neutral-700"
                                        >
                                            <span :class="[programmes[activeDialogIndex].accentColor, 'w-5 h-5 rounded-full flex items-center justify-center text-white shrink-0 mt-0.5']" aria-hidden="true">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                            {{ outcome }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Dialog Footer -->
                            <div class="px-6 sm:px-8 py-4 sm:py-5 border-t border-neutral-100 bg-neutral-50 flex flex-col sm:flex-row sm:items-center sm:justify-center gap-2.5 sm:gap-3 shrink-0">
                                <a
                                    href="#enquiry"
                                    class="btn-cta w-full sm:w-auto text-center"
                                    @click="closeDialog"
                                >
                                    Enquire About This Programme
                                </a>
                                <button
                                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-neutral-300 text-sm font-semibold font-sans text-neutral-700 hover:bg-neutral-100 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-espresso focus-visible:ring-offset-2"
                                    @click="closeDialog"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </Transition>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
