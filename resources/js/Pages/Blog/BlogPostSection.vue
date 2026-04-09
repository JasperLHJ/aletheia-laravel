<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    slug: {
        type: String,
        default: '',
    },
});

const allPosts = [
    {
        slug: 'national-science-olympiad-2026',
        category: 'Achievements',
        title: 'Our Students Shine at the National Science Olympiad 2026',
        excerpt: 'Three of our Year 11 students brought home gold at this year\'s National Science Olympiad, competing against over 400 schools nationwide.',
        date: '2026-03-28',
        image: '/images/class-2.jpg',
        readingTime: 4,
        author: 'Aletheia Resource Center',
        body: [
            {
                type: 'paragraph',
                text: 'In a remarkable display of scientific acumen and teamwork, three of our Year 11 students — Aisha Rahman, Liang Wei, and Priya Nair — claimed the gold medal at the 2026 National Science Olympiad held in Kuala Lumpur last weekend. Competing against more than 400 schools from across the country, their performance has set a new benchmark for our school\'s growing reputation in STEM excellence.',
            },
            {
                type: 'paragraph',
                text: 'The competition, organised by the Ministry of Education, tested participants across four disciplines: Chemistry, Biology, Physics, and Environmental Science. Aletheia\'s team demonstrated particular strength in their combined Chemistry and Environmental Science project, which proposed a novel low-cost water filtration method using locally sourced agricultural waste.',
            },
            {
                type: 'quote',
                text: 'This win belongs to every student who stayed late in the lab, every teacher who believed in us, and every parent who drove us to competitions on weekends. We did this together.',
                author: 'Aisha Rahman, Year 11',
            },
            {
                type: 'paragraph',
                text: 'Head of Science, Mr. Rajesh Kumar, who has been mentoring the team for the past three years, spoke of the dedication that underpins this victory. "These three students represent what Aletheia is all about: curiosity, persistence, and the courage to tackle real-world problems. I couldn\'t be prouder."',
            },
            {
                type: 'paragraph',
                text: 'The gold medal qualifies the team to represent Malaysia at the International Junior Science Olympiad later this year — a first for Aletheia Resource Center. The school will provide full support for their preparation, including access to the university-level laboratory facilities of our partner institutions.',
            },
            {
                type: 'paragraph',
                text: 'We congratulate Aisha, Liang Wei, and Priya on this extraordinary achievement, and we look forward to seeing them represent Malaysia on the international stage. The entire Aletheia community is rooting for you.',
            },
        ],
    },
    {
        slug: 'open-day-april-2026',
        category: 'Events',
        title: 'Open Day: Come See Our Campus This April',
        excerpt: 'We\'re opening our doors to prospective families on 19 April 2026. Tour our facilities, meet our teachers, and discover what makes Aletheia Resource Center a place where every child can flourish.',
        date: '2026-03-20',
        image: '/images/class-3.jpg',
        readingTime: 3,
        author: 'Admissions Team',
        body: [
            {
                type: 'paragraph',
                text: 'We are delighted to invite prospective families to our Open Day on Saturday, 19 April 2026, from 9:00 AM to 1:00 PM. This is your chance to experience campus life first-hand, speak with our teachers and senior students, and discover the vibrant learning environment we have spent decades nurturing.',
            },
            {
                type: 'paragraph',
                text: 'Whether your child is preparing to join us in Year 1 or Year 7, our Open Day is designed to answer all your questions and help your family feel confident in your school choice. Our principal, Dr. Siti Mariam, will deliver a welcome address at 9:30 AM, followed by guided campus tours led by our student ambassadors.',
            },
            {
                type: 'quote',
                text: 'We believe that the best way to understand what makes Aletheia special is to walk through our doors and meet our community in person. Every family that visits leaves with a clear sense of who we are.',
                author: 'Dr. Siti Mariam, Principal',
            },
            {
                type: 'paragraph',
                text: 'During the Open Day, you will have the opportunity to visit our science laboratories, arts studios, library, and sports facilities. Our academic department heads will be available to discuss our curriculum, examination pathways, and co-curricular offerings in detail.',
            },
            {
                type: 'paragraph',
                text: 'Registration is required to help us manage capacity and ensure every family receives personalised attention. Please visit our Contact page or WhatsApp us to reserve your spot. Places are limited, so we encourage early registration.',
            },
        ],
    },
    {
        slug: 'robotics-club-regional-champions',
        category: 'Achievements',
        title: 'Robotics Club Crowned Regional Champions',
        excerpt: 'Our Robotics Club has done it again — taking first place at the Regional STEM Challenge for the second consecutive year.',
        date: '2026-03-14',
        image: '/images/student-1.jpg',
        readingTime: 5,
        author: 'Aletheia Resource Center',
        body: [
            {
                type: 'paragraph',
                text: 'For the second year running, Aletheia\'s Robotics Club has claimed the top prize at the Regional STEM Challenge, held at the Petaling Jaya Technology Hub. The team of six — all from Years 9 and 10 — spent over four months designing, building, and programming their autonomous robot, which outperformed 28 competing teams from Selangor and Kuala Lumpur.',
            },
            {
                type: 'paragraph',
                text: 'This year\'s challenge required robots to navigate an obstacle course, identify coloured objects, and sort them accurately within a strict time limit. Aletheia\'s robot completed the full task in an average of 47 seconds — nearly 30% faster than the second-place team.',
            },
            {
                type: 'quote',
                text: 'We failed so many times during testing that we actually started looking forward to the failures. Each one taught us something new. That\'s what engineering is.',
                author: 'Marcus Tan, Year 10, Team Captain',
            },
            {
                type: 'paragraph',
                text: 'The club is mentored by Ms. Farah Ideris, our ICT and Engineering teacher, who has built the Robotics Club from a small after-school group of four students to a nationally competitive programme of twenty-two. "My role is just to ask the right questions," she says. "The students do all the real thinking."',
            },
            {
                type: 'paragraph',
                text: 'The winning team will be awarded a RM 5,000 grant from the Regional STEM Foundation to invest in new club equipment, and they have been invited to demonstrate their robot at the upcoming Malaysia Technology Expo.',
            },
        ],
    },
    {
        slug: 'wellbeing-week-recap',
        category: 'Campus Life',
        title: 'Wellbeing Week: Building Resilience, One Day at a Time',
        excerpt: 'Last week\'s Wellbeing Week brought yoga sessions, mindfulness workshops, and peer mentoring circles to our campus.',
        date: '2026-03-08',
        image: '/images/class-1.jpg',
        readingTime: 3,
        author: 'School Counselling Team',
        body: [
            {
                type: 'paragraph',
                text: 'Aletheia\'s annual Wellbeing Week, held from 2–6 March 2026, was our most attended to date. The week-long programme — developed collaboratively by our School Counselling Team, PE Department, and Student Council — offered a rich menu of activities designed to equip students and staff with tools for emotional resilience and mental fitness.',
            },
            {
                type: 'paragraph',
                text: 'Highlights included morning yoga sessions on the school field, guided breathwork workshops, a "Digital Detox Challenge" for Year 7–9 students, and a Parent Panel Discussion on supporting teenagers through academic pressure. Our peer mentoring programme — where Year 11 and 12 students support younger year groups — continued to be a standout initiative.',
            },
            {
                type: 'quote',
                text: 'The peer mentoring sessions were the highlight for me. It felt really safe to talk to someone just a few years older who actually gets what you\'re going through.',
                author: 'Anonymous, Year 9 Student',
            },
            {
                type: 'paragraph',
                text: 'Our school counsellor, Ms. Josephine Lee, shared that this year\'s theme — "Connection is the antidote to anxiety" — was chosen in response to a survey of students who identified loneliness and academic pressure as their two primary stressors. "We want every student to know that they are not alone, and that there are always people here ready to listen," she said.',
            },
            {
                type: 'paragraph',
                text: 'Wellbeing initiatives are woven into our school culture year-round, but this dedicated week helps us renew our commitment as a whole community. Thank you to all the students, parents, and staff who participated and made it such a meaningful event.',
            },
        ],
    },
    {
        slug: 'new-ib-programme-launch',
        category: 'Academic',
        title: 'Aletheia Launches the International Baccalaureate Diploma Programme',
        excerpt: 'We are proud to announce our authorisation as an IB World School, offering the prestigious Diploma Programme from 2027.',
        date: '2026-02-25',
        image: '/images/class-2.jpg',
        readingTime: 6,
        author: 'Academic Leadership Team',
        body: [
            {
                type: 'paragraph',
                text: 'Aletheia Resource Center has been officially authorised as an IB World School by the International Baccalaureate Organisation, and we are proud to announce the launch of the IB Diploma Programme (IBDP) beginning September 2027. This milestone reflects years of institutional development, faculty training, and our unwavering commitment to providing students with world-class educational pathways.',
            },
            {
                type: 'paragraph',
                text: 'The IBDP is recognised by universities in over 90 countries and is widely regarded as one of the most rigorous pre-university qualifications available. Students who complete the programme develop critical thinking, research skills, and international-mindedness — qualities that prepare them not just for university, but for life.',
            },
            {
                type: 'quote',
                text: 'This is a transformative moment for our school and for every family that has chosen to be part of our community. The IB Diploma opens doors we have never been able to open before.',
                author: 'Dr. Siti Mariam, Principal',
            },
            {
                type: 'paragraph',
                text: 'The IBDP will be offered alongside our existing Cambridge IGCSE and A-Level pathways, giving families a genuine choice between two internationally respected routes to higher education. Students entering Year 10 in 2026 will be the first cohort eligible to transition into the IBDP in Year 12.',
            },
            {
                type: 'paragraph',
                text: 'Our teachers have undergone IB-certified professional development over the past 18 months, and we have invested significantly in our library resources, research tools, and collaborative learning spaces to support the programme\'s requirements. An information evening for interested families will be scheduled for May 2026.',
            },
        ],
    },
    {
        slug: 'parent-teacher-collaboration-2026',
        category: 'Community',
        title: 'Strengthening the School-Home Partnership',
        excerpt: 'Our annual Parent-Teacher Collaboration Forum brought together over 200 families and educators to co-create a vision for student success.',
        date: '2026-02-14',
        image: '/images/class-3.jpg',
        readingTime: 4,
        author: 'Parent Engagement Committee',
        body: [
            {
                type: 'paragraph',
                text: 'On Saturday 14 February, over 200 families joined our teaching staff for the annual Parent-Teacher Collaboration Forum — an event that has become one of the most valued traditions in our school calendar. This year\'s forum, themed "Partners in Progress", focused on how families and educators can align their approaches to support students through the increasingly complex demands of modern education.',
            },
            {
                type: 'paragraph',
                text: 'The morning began with a keynote from educational psychologist Dr. Alan Chong, who spoke on the science of motivation and how both home and school environments shape a child\'s intrinsic drive to learn. His address prompted a lively Q&A that ran well beyond its scheduled time.',
            },
            {
                type: 'quote',
                text: 'The single most powerful thing a parent can do is show genuine curiosity about what their child is learning — not just about grades, but about ideas. Ask what surprised them today.',
                author: 'Dr. Alan Chong, Educational Psychologist',
            },
            {
                type: 'paragraph',
                text: 'Breakout sessions by year group allowed parents and teachers to discuss specific academic and wellbeing priorities for each stage of schooling. Three key action points emerged from the forum: a new fortnightly home-school update newsletter, expanded parent volunteer opportunities in the library and careers programme, and a pilot "shadowing day" where parents can spend a morning attending classes with their child.',
            },
            {
                type: 'paragraph',
                text: 'We are grateful to every parent and educator who gave up their Saturday morning to invest in this conversation. The strength of our school lies in the quality of these partnerships, and events like this remind us of what is possible when a community comes together around a shared commitment to children\'s wellbeing.',
            },
        ],
    },
    {
        slug: 'chinese-new-year-celebrations',
        category: 'Events',
        title: 'Chinese New Year Celebrations: A Campus Full of Colour',
        excerpt: 'From the lion dance to the lantern-making workshop, our Chinese New Year celebrations brought together the entire school community in a joyful showcase of culture.',
        date: '2026-01-30',
        image: '/images/student-1.jpg',
        readingTime: 2,
        author: 'Cultural Committee',
        body: [
            {
                type: 'paragraph',
                text: 'Our Chinese New Year celebrations this year were truly a feast for the senses. The campus was adorned with red lanterns and gold decorations from the first week of January, building anticipation for the main celebration day on 30 January — a full school assembly that brought together students, teachers, and family members in a joyful showcase of Chinese culture and tradition.',
            },
            {
                type: 'paragraph',
                text: 'The highlight of the morning was undoubtedly the lion dance performance, brought to campus by a professional troupe from Kuala Lumpur, who delighted students with their acrobatic skill and vibrant costumes. The lions\'s visit to each classroom to "bless" the learning spaces had younger students absolutely thrilled.',
            },
            {
                type: 'quote',
                text: 'Seeing all the different cultures in our school come together to celebrate Chinese New Year — I felt so proud. This is what makes Aletheia special.',
                author: 'Ms. Tan Mei Ling, Year 4 Homeroom Teacher',
            },
            {
                type: 'paragraph',
                text: 'Throughout the week, students participated in a series of enrichment activities including calligraphy workshops, lantern-making, a traditional food tasting session featuring tang yuan and nian gao, and a short play performed by our Drama Club based on the legend of Nian. Every activity was designed to be educational and cross-cultural, inviting students from all backgrounds to engage with and appreciate Chinese heritage.',
            },
            {
                type: 'paragraph',
                text: 'Gong Xi Fa Cai from all of us at Aletheia Resource Center. May the Year of the Horse bring health, happiness, and great learning to all our families.',
            },
        ],
    },
];

const post = computed(() => {
    return allPosts.find(p => p.slug === props.slug) || allPosts[0];
});

const relatedPosts = computed(() => {
    return allPosts
        .filter(p => p.slug !== post.value.slug)
        .slice(0, 3);
});

function formatDate(dateStr) {
    const d = new Date(dateStr);
    return d.toLocaleDateString('en-MY', { year: 'numeric', month: 'long', day: 'numeric' });
}

const categoryAccentColors = {
    'Events': '#A74B1A',
    'Achievements': '#CE7815',
    'Campus Life': '#95B91F',
    'Academic': '#382016',
    'Community': '#D30C5F',
};

function accentForCategory(cat) {
    return categoryAccentColors[cat] || '#A74B1A';
}

async function copyLink() {
    try {
        await navigator.clipboard.writeText(window.location.href);
    } catch {
        // Clipboard API unavailable — silent fail
    }
}
</script>

<template>
    <section
        id="blog-post-section"
        class="bg-neutral-50 py-16 sm:py-20"
        aria-label="Blog post content"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="blog-post-breadcrumb flex items-center gap-2 text-xs text-neutral-400 mb-8" aria-label="Breadcrumb">
                <Link href="/" class="hover:text-ember transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-crimson rounded-sm">Home</Link>
                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <Link href="/blog" class="hover:text-ember transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-crimson rounded-sm">Blog</Link>
                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-neutral-500 truncate max-w-xs">{{ post.title }}</span>
            </nav>

            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">

                <!-- Main Content -->
                <article class="blog-post-content flex-1 min-w-0">

                    <!-- Back link -->
                    <Link
                        href="/blog"
                        class="inline-flex items-center gap-2 text-sm text-ember hover:text-ember-dark font-medium mb-8 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson rounded-sm"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                        </svg>
                        Back to Blog
                    </Link>

                    <!-- Category pill -->
                    
                    <span
                        class="inline-block ml-2 px-3 py-1 rounded-full text-xs font-medium text-white uppercase tracking-widest mb-5"
                        :style="`background-color: ${accentForCategory(post.category)};`"
                    >
                        {{ post.category }}
                    </span>

                    <!-- Title -->
                    <h1
                        class="font-display font-bold text-espresso leading-tight mb-6"
                        style="font-size: clamp(1.75rem, 4vw, 2.75rem); line-height: 1.15;"
                    >
                        {{ post.title }}
                    </h1>

                    <!-- Meta bar -->
                    <div class="flex flex-wrap items-center gap-4 mb-8 pb-8 border-b border-neutral-200">
                        <div class="flex items-center gap-2 text-sm text-neutral-500">
                            <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                            </svg>
                            <time :datetime="post.date">{{ formatDate(post.date) }}</time>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-neutral-500">
                            <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ post.readingTime }} min read</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-neutral-500">
                            <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span>{{ post.author }}</span>
                        </div>
                    </div>

                    <!-- Hero image -->
                    <div class="rounded-xl overflow-hidden mb-10 shadow-md">
                        <img
                            :src="post.image"
                            :alt="post.title"
                            class="w-full h-64 sm:h-80 object-cover"
                            loading="lazy"
                        />
                    </div>

                    <!-- Post body -->
                    <div class="blog-prose space-y-6">
                        <template v-for="(block, i) in post.body" :key="i">
                            <p
                                v-if="block.type === 'paragraph'"
                                class="text-neutral-700 leading-relaxed"
                                style="font-size: 1.0625rem; line-height: 1.8;"
                            >
                                {{ block.text }}
                            </p>
                            <blockquote
                                v-else-if="block.type === 'quote'"
                                class="relative pl-6 py-2 my-8"
                            >
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-1 rounded-full"
                                    :style="`background-color: ${accentForCategory(post.category)};`"
                                    aria-hidden="true"
                                ></div>
                                <p
                                    class="font-display italic text-espresso mb-3"
                                    style="font-size: clamp(1.05rem, 2vw, 1.25rem); line-height: 1.6;"
                                >
                                    "{{ block.text }}"
                                </p>
                                <cite class="not-italic text-sm font-medium text-neutral-500">— {{ block.author }}</cite>
                            </blockquote>
                        </template>
                    </div>

                    <!-- Share row -->
                    <div class="blog-post-share mt-12 pt-8 border-t border-neutral-200 flex flex-wrap items-center gap-4">
                        <span class="text-sm font-medium text-neutral-500">Share this post:</span>
                        <a
                            :href="`https://wa.me/?text=${encodeURIComponent(post.title + ' — ' + (typeof window !== 'undefined' ? window.location.href : ''))}`"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium text-white transition-all duration-200 hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#25D366]"
                            style="background-color: #25D366;"
                            aria-label="Share on WhatsApp"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            WhatsApp
                        </a>
                        <button
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium text-neutral-600 bg-neutral-100 hover:bg-neutral-200 transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson focus-visible:ring-offset-2"
                            @click="copyLink"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                            </svg>
                            Copy link
                        </button>
                    </div>
                </article>

                <!-- Sidebar -->
                <aside class="blog-post-sidebar w-full lg:w-80 shrink-0" aria-label="Related posts and enquiry">
                    <div class="sticky top-24 space-y-8">

                        <!-- Related Posts -->
                        <div class="bg-white rounded-xl border border-neutral-200 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-neutral-100 flex items-center gap-2">
                                <div
                                    class="w-1 h-4 rounded-full"
                                    :style="`background-color: ${accentForCategory(post.category)};`"
                                    aria-hidden="true"
                                ></div>
                                <h2 class="text-sm font-sans font-semibold text-espresso uppercase tracking-widest">Related Posts</h2>
                            </div>
                            <ul class="divide-y divide-neutral-100">
                                <li v-for="related in relatedPosts" :key="related.slug">
                                    <Link
                                        :href="`/blog/${related.slug}`"
                                        class="flex items-start gap-3 p-4 group hover:bg-neutral-50 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-crimson"
                                    >
                                        <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0">
                                            <img
                                                :src="related.image"
                                                :alt="related.title"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                                loading="lazy"
                                            />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p
                                                class="text-xs font-medium uppercase tracking-wider mb-1"
                                                :style="`color: ${accentForCategory(related.category)};`"
                                            >
                                                {{ related.category }}
                                            </p>
                                            <p class="text-sm font-sans font-medium text-espresso group-hover:text-ember transition-colors duration-200 leading-snug line-clamp-2">
                                                {{ related.title }}
                                            </p>
                                            <p class="text-xs text-neutral-400 mt-1">
                                                <time :datetime="related.date">{{ formatDate(related.date) }}</time>
                                            </p>
                                        </div>
                                    </Link>
                                </li>
                            </ul>
                            <div class="px-6 py-4 border-t border-neutral-100">
                                <Link
                                    href="/blog"
                                    class="flex items-center justify-center gap-2 text-sm font-medium text-ember hover:text-ember-dark transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-crimson rounded-sm"
                                >
                                    View all posts
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </Link>
                            </div>
                        </div>

                        <!-- Enquiry CTA -->
                        <div class="bg-espresso rounded-xl overflow-hidden relative p-6 text-center">
                            <div
                                class="absolute inset-0 opacity-5"
                                style="background-image: repeating-linear-gradient(45deg, #CE7815 0, #CE7815 1px, transparent 0, transparent 50%); background-size: 20px 20px;"
                                aria-hidden="true"
                            ></div>
                            <div class="relative z-10">
                                <p class="section-eyebrow text-gold mb-2">Admissions Open</p>
                                <h3 class="font-display font-semibold text-neutral-50 mb-3" style="font-size: 1.1rem; line-height: 1.3;">
                                    Ready to Join Our Community?
                                </h3>
                                <p class="text-white/60 text-xs leading-relaxed mb-5">
                                    Speak with our admissions team and book your campus visit today.
                                </p>
                                <a
                                    href="https://wa.me/60312345678?text=Hello%2C%20I%27d%20like%20to%20enquire%20about%20Aletheia%20Resource%20Center."
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-cta w-full text-sm"
                                    aria-label="Enquire via WhatsApp"
                                >
                                    Enquire Now
                                </a>
                            </div>
                        </div>

                    </div>
                </aside>

            </div>
        </div>
    </section>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
