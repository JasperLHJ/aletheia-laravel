<template>
    <section
        id="curriculum-deep-dive"
        class="bg-white py-20 sm:py-28"
        aria-labelledby="deepdive-heading"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16 sm:mb-20">
                <p class="text-xs font-sans font-medium text-ember uppercase tracking-widest mb-3">
                    Inside the Classroom
                </p>
                <h2
                    id="deepdive-heading"
                    class="font-display font-semibold text-espresso mb-4"
                    style="font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;"
                >
                    What Each Programme Offers
                </h2>
                <p class="text-neutral-600 leading-relaxed">
                    Each stage of learning is carefully designed to build on the last,
                    ensuring every student arrives at their next chapter prepared and confident.
                </p>
            </div>

            <!-- Programme Rows -->
            <div class="space-y-20 sm:space-y-28">
                <div
                    v-for="(programme, index) in programmes"
                    :key="programme.id"
                    :id="programme.id"
                    class="deepdive-row scroll-mt-24"
                >
                    <div
                        class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center"
                        :class="index % 2 === 0 ? '' : 'lg:[&>*:first-child]:order-2'"
                    >
                        <!-- Image Column -->
                        <div
                            :class="['deepdive-image relative rounded-2xl overflow-hidden shadow-lg', index % 2 === 0 ? 'deepdive-image-left' : 'deepdive-image-right']"
                            style="aspect-ratio: 4/3;"
                        >
                            <img
                                :src="programme.image"
                                :alt="programme.imageAlt"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            />
                            <!-- Colour overlay gradient -->
                            <div
                                class="absolute inset-0"
                                :style="`background: linear-gradient(135deg, ${programme.overlayColor}33 0%, transparent 60%);`"
                                aria-hidden="true"
                            ></div>

                            <!-- Floating stat badge -->
                            <div
                                class="absolute bottom-5 left-5 bg-white/95 backdrop-blur-sm rounded-xl px-4 py-3 shadow-lg"
                            >
                                <p class="text-xs text-neutral-500 font-sans mb-0.5">Qualification</p>
                                <p :class="['font-display font-bold text-sm', programme.accentText]">{{ programme.qualification }}</p>
                            </div>

                            <!-- Accent corner decoration -->
                            <div
                                :class="['absolute top-0 right-0 w-20 h-20 rounded-bl-[3rem]', programme.accentBg]"
                                style="opacity: 0.15;"
                                aria-hidden="true"
                            ></div>
                        </div>

                        <!-- Content Column -->
                        <div :class="['deepdive-content', index % 2 === 0 ? 'deepdive-content-right' : 'deepdive-content-left']">
                            <!-- Eyebrow pill -->
                            <div class="flex items-center gap-3 mb-5">
                                <span
                                    :class="['inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold text-white', programme.accentBg]"
                                >
                                    <span v-html="programme.icon" class="w-3.5 h-3.5"></span>
                                    {{ programme.eyebrow }}
                                </span>
                            </div>

                            <!-- Heading -->
                            <h3
                                class="font-display font-bold text-espresso mb-3"
                                style="font-size: clamp(1.5rem, 2.5vw, 2rem); line-height: 1.2;"
                            >
                                {{ programme.title }}
                            </h3>

                            <p class="text-neutral-600 leading-relaxed mb-7 text-base">
                                {{ programme.overview }}
                            </p>

                            <!-- Curriculum Subjects -->
                            <div class="mb-7">
                                <h4 class="text-xs font-sans font-semibold text-neutral-500 uppercase tracking-widest mb-3">
                                    Curriculum Areas
                                </h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    <div
                                        v-for="subject in programme.subjects"
                                        :key="subject.name"
                                        class="flex items-start gap-2.5 p-3 bg-neutral-50 rounded-xl border border-neutral-100 group hover:border-neutral-200 transition-colors duration-150"
                                    >
                                        <div
                                            :class="['w-1.5 rounded-full shrink-0 mt-1.5', programme.accentBg]"
                                            style="height: 1rem;"
                                            aria-hidden="true"
                                        ></div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-semibold font-sans text-espresso">{{ subject.name }}</p>
                                            <p class="text-xs text-neutral-500 leading-relaxed mt-0.5">{{ subject.desc }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Key Outcomes -->
                            <div class="mb-8">
                                <h4 class="text-xs font-sans font-semibold text-neutral-500 uppercase tracking-widest mb-3">
                                    Student Outcomes
                                </h4>
                                <ul class="space-y-2" role="list">
                                    <li
                                        v-for="outcome in programme.outcomes"
                                        :key="outcome"
                                        class="flex items-center gap-2.5 text-sm text-neutral-700"
                                    >
                                        <span
                                            :class="['w-5 h-5 rounded-full flex items-center justify-center text-white shrink-0', programme.accentBg]"
                                            aria-hidden="true"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        {{ outcome }}
                                    </li>
                                </ul>
                            </div>

                            <!-- CTA -->
                            <a
                                href="/contact"
                                :class="['inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:opacity-90 hover:-translate-y-0.5 shadow-md min-h-[44px]', programme.accentBg]"
                            >
                                Enquire About This Programme
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const programmes = [
    {
        id: 'primary-programme',
        eyebrow: 'Primary · Ages 5–11',
        title: 'Primary Programme',
        qualification: 'Cambridge Primary Checkpoint',
        overview: 'Our Primary Programme is designed to instil a lifelong love of learning from the earliest years. Grounded in the Cambridge Primary framework, students explore the world through structured inquiry, collaborative projects, and discovery-based activities that build strong academic and social foundations.',
        image: '/images/class-3.jpg',
        imageAlt: 'Young students engaged in hands-on learning activities in a bright classroom',
        overlayColor: '#95B91F',
        accentBg: 'bg-sage',
        accentText: 'text-sage-dark',
        subjects: [
            { name: 'English & Literacy', desc: 'Phonics, comprehension, and creative writing with differentiated support.' },
            { name: 'Mathematics', desc: 'Conceptual understanding through Singapore Math and manipulative-based learning.' },
            { name: 'Sciences', desc: 'Hands-on experiments and STEM projects that build scientific curiosity.' },
            { name: 'Humanities', desc: 'Age-appropriate history, geography, and cultural studies.' },
            { name: 'Arts & Music', desc: 'Expressive arts fostering creativity and emotional intelligence.' },
            { name: 'Physical Education', desc: 'Structured sports, movement, and wellness routines.' },
        ],
        outcomes: [
            'Strong literacy and numeracy foundations',
            'Inquisitive, self-directed learners',
            'Collaborative social and emotional skills',
            'Cambridge Primary Checkpoint qualification',
        ],
        icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>`,
    },
    {
        id: 'secondary-programme',
        eyebrow: 'Secondary · Ages 12–16',
        title: 'Secondary Programme',
        qualification: 'Cambridge IGCSE (up to 10 subjects)',
        overview: 'The Secondary Programme prepares students for Cambridge IGCSE examinations while cultivating deep analytical thinking, independent research, and a breadth of academic interests. Students are challenged to think critically, communicate effectively, and engage with global issues across disciplines.',
        image: '/images/class-1.jpg',
        imageAlt: 'Secondary students working in a well-equipped science laboratory',
        overlayColor: '#A74B1A',
        accentBg: 'bg-ember',
        accentText: 'text-ember-dark',
        subjects: [
            { name: 'Core Sciences', desc: 'Biology, Chemistry, and Physics with dedicated laboratory sessions.' },
            { name: 'Mathematics', desc: 'Rigorous problem-solving and algebraic reasoning through Additional Mathematics.' },
            { name: 'English Language & Literature', desc: 'Critical textual analysis and academic writing skills.' },
            { name: 'Humanities', desc: 'History, Geography, and Economics with global case studies.' },
            { name: 'Modern Languages', desc: 'Mandarin, Malay, and French language programmes.' },
            { name: 'Co-Curricular Activities', desc: 'Structured CCA portfolio supporting holistic development.' },
        ],
        outcomes: [
            'Cambridge IGCSE qualifications across up to 10 subjects',
            'Strong analytical and independent research skills',
            'Leadership and communication capabilities',
            'A breadth of academic and co-curricular achievements',
        ],
        icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>`,
    },
    {
        id: 'preuniversity-programme',
        eyebrow: 'Pre-University · Ages 17–18',
        title: 'Pre-University Programme',
        qualification: 'Cambridge A-Levels (AS & A2)',
        overview: 'Our Pre-University Programme is a focused two-year track designed to maximise Cambridge A-Level results and secure admission to top universities worldwide. Students receive individualised mentorship, subject specialisation across three structured tracks, and expert university counselling throughout their final school years.',
        image: '/images/class-2.jpg',
        imageAlt: 'Pre-university students engaged in a seminar discussion',
        overlayColor: '#CE7815',
        accentBg: 'bg-gold',
        accentText: 'text-gold-dark',
        subjects: [
            { name: 'Sciences Track', desc: 'Mathematics, Physics, Chemistry, and Biology combinations.' },
            { name: 'Humanities & Social Sciences', desc: 'Economics, Literature, History, and Psychology.' },
            { name: 'Business & Commerce Track', desc: 'Business Studies, Economics, and Accounting.' },
            { name: 'General Paper', desc: 'Critical thinking, essay writing, and current affairs analysis.' },
            { name: 'Project Work', desc: 'Collaborative research and presentation skills across disciplines.' },
            { name: 'University Counselling', desc: 'Dedicated guidance for local and international university applications.' },
        ],
        outcomes: [
            'Cambridge A-Level qualifications (AS and A2)',
            'University admission to local and overseas institutions',
            'Scholarship application support and portfolio preparation',
            'Leadership credentials and independent research experience',
        ],
        icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" /></svg>`,
    },
];
</script>
