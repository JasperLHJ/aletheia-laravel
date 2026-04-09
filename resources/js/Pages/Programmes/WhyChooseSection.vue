<template>
    <section
        id="why-aletheia"
        class="bg-espresso py-20 sm:py-28 relative overflow-hidden"
        aria-labelledby="why-heading"
    >
        <!-- Decorative background elements -->
        <div
            class="absolute top-0 left-0 w-[600px] h-[600px] rounded-full pointer-events-none"
            style="background: radial-gradient(circle, rgba(206,120,21,0.08) 0%, transparent 65%); transform: translate(-30%, -30%);"
            aria-hidden="true"
        ></div>
        <div
            class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full pointer-events-none"
            style="background: radial-gradient(circle, rgba(149,185,31,0.07) 0%, transparent 65%); transform: translate(25%, 30%);"
            aria-hidden="true"
        ></div>
        <!-- Subtle grid texture -->
        <div
            class="absolute inset-0 pointer-events-none opacity-[0.03]"
            style="background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 48px 48px;"
            aria-hidden="true"
        ></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="text-xs font-sans font-medium text-gold uppercase tracking-widest mb-3">
                    Why Aletheia Resource Center
                </p>
                <h2
                    id="why-heading"
                    class="font-display font-bold text-neutral-50 mb-4"
                    style="font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;"
                >
                    The Aletheia Difference
                </h2>
                <p class="text-white/60 leading-relaxed">
                    We don't just teach — we shape the whole child. Here is what sets our
                    programmes apart from the rest.
                </p>
            </div>

            <!-- Feature Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
                <div
                    v-for="feature in features"
                    :key="feature.title"
                    class="why-card group relative bg-white/5 border border-white/10 rounded-2xl p-6 sm:p-7 hover:bg-white/10 hover:border-white/20 transition-all duration-300"
                >
                    <!-- Icon -->
                    <div
                        :class="['w-12 h-12 rounded-xl flex items-center justify-center mb-5 transition-transform duration-300 group-hover:scale-110', feature.iconBg]"
                    >
                        <span class="text-white" v-html="feature.icon"></span>
                    </div>

                    <h3
                        class="font-display font-semibold text-neutral-50 mb-2"
                        style="font-size: 1.1rem; line-height: 1.3;"
                    >
                        {{ feature.title }}
                    </h3>

                    <p class="text-sm text-white/55 leading-relaxed">
                        {{ feature.body }}
                    </p>

                    <!-- Bottom accent line on hover -->
                    <div
                        :class="['absolute bottom-0 left-6 right-6 h-px transition-opacity duration-300 opacity-0 group-hover:opacity-100', feature.accentLine]"
                        aria-hidden="true"
                    ></div>
                </div>
            </div>

            <!-- Stats row -->
            <div class="mt-14 pt-10 border-t border-white/10 grid grid-cols-2 md:grid-cols-4 gap-6">
                <div
                    v-for="stat in stats"
                    :key="stat.label"
                    class="text-center"
                >
                    <p class="font-display font-bold text-gold" style="font-size: clamp(1.8rem, 3vw, 2.5rem);">
                        {{ stat.value }}
                    </p>
                    <p class="text-xs text-white/50 uppercase tracking-wider mt-1">{{ stat.label }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const features = [
    {
        title: 'Cambridge-Aligned Curriculum',
        body: 'All three programmes are built on the globally recognised Cambridge framework, ensuring our qualifications are accepted and respected by universities worldwide.',
        iconBg: 'bg-sage',
        accentLine: 'bg-sage',
        icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>`,
    },
    {
        title: 'Small Class Sizes',
        body: 'With intentionally small class sizes, every student receives focused attention and personalised guidance — never just a face in the crowd.',
        iconBg: 'bg-ember',
        accentLine: 'bg-ember',
        icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" /></svg>`,
    },
    {
        title: 'Experienced Educators',
        body: 'Our faculty comprises qualified, passionate teachers with deep subject expertise and a genuine commitment to each student\'s growth and wellbeing.',
        iconBg: 'bg-gold',
        accentLine: 'bg-gold',
        icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>`,
    },
    {
        title: 'Holistic Co-Curricular',
        body: 'From orchestra and debate to robotics and competitive sports, our rich CCA programme ensures every child discovers and develops their unique talents.',
        iconBg: 'bg-crimson',
        accentLine: 'bg-crimson',
        icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>`,
    },
    {
        title: 'University Counselling',
        body: 'Our dedicated university counsellors guide every pre-university student through applications to local and international universities, including scholarship opportunities.',
        iconBg: 'bg-espresso-light',
        accentLine: 'bg-espresso-light',
        icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" /></svg>`,
    },
    {
        title: 'Pastoral Care & Character',
        body: 'Every student is known by name. Our pastoral system ensures emotional wellbeing, character formation, and a strong sense of belonging throughout their school journey.',
        iconBg: 'bg-gold-dark',
        accentLine: 'bg-gold-dark',
        icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>`,
    },
];

const stats = [
    { value: '75+', label: 'Years of Excellence' },
    { value: '98%', label: 'University Placement' },
    { value: '12:1', label: 'Student-Teacher Ratio' },
    { value: '30+', label: 'CCA Programmes' },
];
</script>
