<script setup>
const principal = {
    name: 'Dr. Sarah Lim Wei Ling',
    title: 'Principal',
    image: '/images/student-1.jpg',
    bio: 'With over 25 years in education leadership, Dr. Lim has dedicated her career to building learning communities where every student is known, valued, and challenged. Under her stewardship, Aletheia Resource Center has grown into one of the region\'s most respected institutions.',
};

const teachers = [
    {
        name: 'Mr. James Okonkwo',
        title: 'Head of Sciences',
        image: '/images/class-1.jpg',
        bio: 'Cambridge-trained physicist with a passion for inquiry-based learning and student-led research.',
    },
    {
        name: 'Ms. Aisyah Rahman',
        title: 'Head of Languages',
        image: '/images/class-2.jpg',
        bio: 'Multilingual educator specialising in English literature and creative writing programmes.',
    },
    {
        name: 'Mr. David Chen',
        title: 'Head of Mathematics',
        image: '/images/class-3.jpg',
        bio: 'Award-winning mathematics educator focused on developing problem-solving and analytical skills.',
    },
    {
        name: 'Ms. Priya Nair',
        title: 'Head of Humanities',
        image: '/images/student-1.jpg',
        bio: 'History and geography specialist who brings global perspectives into the classroom.',
    },
    {
        name: 'Mr. Thomas Lee',
        title: 'Head of Co-Curricular',
        image: '/images/class-1.jpg',
        bio: 'Former national athlete driving holistic student development through sports and leadership.',
    },
    {
        name: 'Ms. Fatimah Zahra',
        title: 'Head of Student Wellbeing',
        image: '/images/class-2.jpg',
        bio: 'Certified counsellor and pastoral care leader ensuring every student thrives emotionally and socially.',
    },
];
</script>

<template>
    <div>
        <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-xs font-sans font-medium text-ember uppercase tracking-widest mb-3">
                Meet Our Educators
            </p>
            <h3
                class="font-display font-semibold text-espresso mb-4"
                style="font-size: clamp(1.6rem, 2.8vw, 2.1rem); line-height: 1.2;"
            >
                Principal &amp; Teacher Profiles
            </h3>
            <p class="text-neutral-600 leading-relaxed">
                Our dedicated educators bring expertise, compassion, and a shared commitment
                to helping every student reach their full potential.
            </p>
        </div>

        <!-- Principal Spotlight -->
        <article class="teacher-card bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden mb-8">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-2/5 lg:w-1/3 relative">
                    <img
                        :src="principal.image"
                        :alt="`Portrait of ${principal.name}`"
                        class="w-full h-64 md:h-full object-cover"
                        loading="lazy"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-espresso/40 to-transparent"
                        aria-hidden="true"
                    ></div>
                </div>
                <div class="flex-1 p-8 sm:p-10 border-t-4 md:border-t-0 md:border-l-4 border-gold flex flex-col justify-center">
                    <p class="text-xs font-sans font-semibold text-gold uppercase tracking-widest mb-2">
                        {{ principal.title }}
                    </p>
                    <h4
                        class="font-display font-bold text-espresso mb-4"
                        style="font-size: 1.5rem; line-height: 1.25;"
                    >
                        {{ principal.name }}
                    </h4>
                    <p class="text-base text-neutral-600 leading-relaxed">
                        {{ principal.bio }}
                    </p>
                </div>
            </div>
        </article>

        <!-- Teacher Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
            <article
                v-for="teacher in teachers"
                :key="teacher.name"
                class="teacher-card group bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col"
            >
                <div class="relative h-48 overflow-hidden shrink-0">
                    <img
                        :src="teacher.image"
                        :alt="`Portrait of ${teacher.name}`"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-espresso/50 to-transparent"
                        aria-hidden="true"
                    ></div>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <p class="text-xs font-sans font-semibold text-ember uppercase tracking-widest mb-1.5">
                        {{ teacher.title }}
                    </p>
                    <h4
                        class="font-display font-semibold text-espresso mb-3"
                        style="font-size: 1.15rem; line-height: 1.3;"
                    >
                        {{ teacher.name }}
                    </h4>
                    <p class="text-sm text-neutral-600 leading-relaxed flex-1">
                        {{ teacher.bio }}
                    </p>
                </div>
            </article>
        </div>
    </div>
</template>
