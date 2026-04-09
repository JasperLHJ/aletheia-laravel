<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeds published blog posts matching the former static mock data on the public blog.
 */
class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->firstOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Aletheia Resource Center',
                'password' => Hash::make('password'),
            ]
        );

        foreach ($this->posts() as $post) {
            Post::query()->updateOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, [
                    'user_id' => $user->id,
                    'status' => 'published',
                ])
            );
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function posts(): array
    {
        return [
            [
                'slug' => 'national-science-olympiad-2026',
                'category' => 'Achievements',
                'title' => 'Our Students Shine at the National Science Olympiad 2026',
                'excerpt' => 'Three of our Year 11 students brought home gold at this year\'s National Science Olympiad, competing against over 400 schools nationwide. Their dedication and the mentorship of our Science faculty made all the difference.',
                'featured_image' => '/images/class-2.jpg',
                'reading_time_minutes' => 4,
                'is_featured' => true,
                'published_at' => '2026-03-28 10:00:00',
                'body' => <<<'HTML'
<p>In a remarkable display of scientific acumen and teamwork, three of our Year 11 students — Aisha Rahman, Liang Wei, and Priya Nair — claimed the gold medal at the 2026 National Science Olympiad held in Kuala Lumpur last weekend. Competing against more than 400 schools from across the country, their performance has set a new benchmark for our school's growing reputation in STEM excellence.</p>
<p>The competition, organised by the Ministry of Education, tested participants across four disciplines: Chemistry, Biology, Physics, and Environmental Science. Aletheia's team demonstrated particular strength in their combined Chemistry and Environmental Science project, which proposed a novel low-cost water filtration method using locally sourced agricultural waste.</p>
<blockquote><p>This win belongs to every student who stayed late in the lab, every teacher who believed in us, and every parent who drove us to competitions on weekends. We did this together.</p><cite>— Aisha Rahman, Year 11</cite></blockquote>
<p>Head of Science, Mr. Rajesh Kumar, who has been mentoring the team for the past three years, spoke of the dedication that underpins this victory. "These three students represent what Aletheia is all about: curiosity, persistence, and the courage to tackle real-world problems. I couldn't be prouder."</p>
<p>The gold medal qualifies the team to represent Malaysia at the International Junior Science Olympiad later this year — a first for Aletheia Resource Center. The school will provide full support for their preparation, including access to the university-level laboratory facilities of our partner institutions.</p>
<p>We congratulate Aisha, Liang Wei, and Priya on this extraordinary achievement, and we look forward to seeing them represent Malaysia on the international stage. The entire Aletheia community is rooting for you.</p>
HTML,
            ],
            [
                'slug' => 'open-day-april-2026',
                'category' => 'Events',
                'title' => 'Open Day: Come See Our Campus This April',
                'excerpt' => 'We\'re opening our doors to prospective families on 19 April 2026. Tour our facilities, meet our teachers, and discover what makes Aletheia Resource Center a place where every child can flourish.',
                'featured_image' => '/images/class-3.jpg',
                'reading_time_minutes' => 3,
                'is_featured' => false,
                'published_at' => '2026-03-20 09:00:00',
                'body' => <<<'HTML'
<p>We are delighted to invite prospective families to our Open Day on Saturday, 19 April 2026, from 9:00 AM to 1:00 PM. This is your chance to experience campus life first-hand, speak with our teachers and senior students, and discover the vibrant learning environment we have spent decades nurturing.</p>
<p>Whether your child is preparing to join us in Year 1 or Year 7, our Open Day is designed to answer all your questions and help your family feel confident in your school choice. Our principal, Dr. Siti Mariam, will deliver a welcome address at 9:30 AM, followed by guided campus tours led by our student ambassadors.</p>
<blockquote><p>We believe that the best way to understand what makes Aletheia special is to walk through our doors and meet our community in person. Every family that visits leaves with a clear sense of who we are.</p><cite>— Dr. Siti Mariam, Principal</cite></blockquote>
<p>During the Open Day, you will have the opportunity to visit our science laboratories, arts studios, library, and sports facilities. Our academic department heads will be available to discuss our curriculum, examination pathways, and co-curricular offerings in detail.</p>
<p>Registration is required to help us manage capacity and ensure every family receives personalised attention. Please visit our Contact page or WhatsApp us to reserve your spot. Places are limited, so we encourage early registration.</p>
HTML,
            ],
            [
                'slug' => 'robotics-club-regional-champions',
                'category' => 'Achievements',
                'title' => 'Robotics Club Crowned Regional Champions',
                'excerpt' => 'Our Robotics Club has done it again — taking first place at the Regional STEM Challenge for the second consecutive year. Read about the engineering journey that led them there.',
                'featured_image' => '/images/student-1.jpg',
                'reading_time_minutes' => 5,
                'is_featured' => false,
                'published_at' => '2026-03-14 11:00:00',
                'body' => <<<'HTML'
<p>For the second year running, Aletheia's Robotics Club has claimed the top prize at the Regional STEM Challenge, held at the Petaling Jaya Technology Hub. The team of six — all from Years 9 and 10 — spent over four months designing, building, and programming their autonomous robot, which outperformed 28 competing teams from Selangor and Kuala Lumpur.</p>
<p>This year's challenge required robots to navigate an obstacle course, identify coloured objects, and sort them accurately within a strict time limit. Aletheia's robot completed the full task in an average of 47 seconds — nearly 30% faster than the second-place team.</p>
<blockquote><p>We failed so many times during testing that we actually started looking forward to the failures. Each one taught us something new. That's what engineering is.</p><cite>— Marcus Tan, Year 10, Team Captain</cite></blockquote>
<p>The club is mentored by Ms. Farah Ideris, our ICT and Engineering teacher, who has built the Robotics Club from a small after-school group of four students to a nationally competitive programme of twenty-two. "My role is just to ask the right questions," she says. "The students do all the real thinking."</p>
<p>The winning team will be awarded a RM 5,000 grant from the Regional STEM Foundation to invest in new club equipment, and they have been invited to demonstrate their robot at the upcoming Malaysia Technology Expo.</p>
HTML,
            ],
            [
                'slug' => 'wellbeing-week-recap',
                'category' => 'Campus Life',
                'title' => 'Wellbeing Week: Building Resilience, One Day at a Time',
                'excerpt' => 'Last week\'s Wellbeing Week brought yoga sessions, mindfulness workshops, and peer mentoring circles to our campus. Here\'s how students and staff are nurturing a culture of care.',
                'featured_image' => '/images/class-1.jpg',
                'reading_time_minutes' => 3,
                'is_featured' => false,
                'published_at' => '2026-03-08 08:00:00',
                'body' => <<<'HTML'
<p>Aletheia's annual Wellbeing Week, held from 2–6 March 2026, was our most attended to date. The week-long programme — developed collaboratively by our School Counselling Team, PE Department, and Student Council — offered a rich menu of activities designed to equip students and staff with tools for emotional resilience and mental fitness.</p>
<p>Highlights included morning yoga sessions on the school field, guided breathwork workshops, a "Digital Detox Challenge" for Year 7–9 students, and a Parent Panel Discussion on supporting teenagers through academic pressure. Our peer mentoring programme — where Year 11 and 12 students support younger year groups — continued to be a standout initiative.</p>
<blockquote><p>The peer mentoring sessions were the highlight for me. It felt really safe to talk to someone just a few years older who actually gets what you're going through.</p><cite>— Anonymous, Year 9 Student</cite></blockquote>
<p>Our school counsellor, Ms. Josephine Lee, shared that this year's theme — "Connection is the antidote to anxiety" — was chosen in response to a survey of students who identified loneliness and academic pressure as their two primary stressors. "We want every student to know that they are not alone, and that there are always people here ready to listen," she said.</p>
<p>Wellbeing initiatives are woven into our school culture year-round, but this dedicated week helps us renew our commitment as a whole community. Thank you to all the students, parents, and staff who participated and made it such a meaningful event.</p>
HTML,
            ],
            [
                'slug' => 'new-ib-programme-launch',
                'category' => 'Academic',
                'title' => 'Aletheia Launches the International Baccalaureate Diploma Programme',
                'excerpt' => 'We are proud to announce our authorisation as an IB World School, offering the prestigious Diploma Programme from 2027. This milestone opens new global pathways for our students.',
                'featured_image' => '/images/class-2.jpg',
                'reading_time_minutes' => 6,
                'is_featured' => false,
                'published_at' => '2026-02-25 14:00:00',
                'body' => <<<'HTML'
<p>Aletheia Resource Center has been officially authorised as an IB World School by the International Baccalaureate Organisation, and we are proud to announce the launch of the IB Diploma Programme (IBDP) beginning September 2027. This milestone reflects years of institutional development, faculty training, and our unwavering commitment to providing students with world-class educational pathways.</p>
<p>The IBDP is recognised by universities in over 90 countries and is widely regarded as one of the most rigorous pre-university qualifications available. Students who complete the programme develop critical thinking, research skills, and international-mindedness — qualities that prepare them not just for university, but for life.</p>
<blockquote><p>This is a transformative moment for our school and for every family that has chosen to be part of our community. The IB Diploma opens doors we have never been able to open before.</p><cite>— Dr. Siti Mariam, Principal</cite></blockquote>
<p>The IBDP will be offered alongside our existing Cambridge IGCSE and A-Level pathways, giving families a genuine choice between two internationally respected routes to higher education. Students entering Year 10 in 2026 will be the first cohort eligible to transition into the IBDP in Year 12.</p>
<p>Our teachers have undergone IB-certified professional development over the past 18 months, and we have invested significantly in our library resources, research tools, and collaborative learning spaces to support the programme's requirements. An information evening for interested families will be scheduled for May 2026.</p>
HTML,
            ],
            [
                'slug' => 'parent-teacher-collaboration-2026',
                'category' => 'Community',
                'title' => 'Strengthening the School-Home Partnership',
                'excerpt' => 'Our annual Parent-Teacher Collaboration Forum brought together over 200 families and educators to co-create a vision for student success. Key takeaways and action points inside.',
                'featured_image' => '/images/class-3.jpg',
                'reading_time_minutes' => 4,
                'is_featured' => false,
                'published_at' => '2026-02-14 10:30:00',
                'body' => <<<'HTML'
<p>On Saturday 14 February, over 200 families joined our teaching staff for the annual Parent-Teacher Collaboration Forum — an event that has become one of the most valued traditions in our school calendar. This year's forum, themed "Partners in Progress", focused on how families and educators can align their approaches to support students through the increasingly complex demands of modern education.</p>
<p>The morning began with a keynote from educational psychologist Dr. Alan Chong, who spoke on the science of motivation and how both home and school environments shape a child's intrinsic drive to learn. His address prompted a lively Q&A that ran well beyond its scheduled time.</p>
<blockquote><p>The single most powerful thing a parent can do is show genuine curiosity about what their child is learning — not just about grades, but about ideas. Ask what surprised them today.</p><cite>— Dr. Alan Chong, Educational Psychologist</cite></blockquote>
<p>Breakout sessions by year group allowed parents and teachers to discuss specific academic and wellbeing priorities for each stage of schooling. Three key action points emerged from the forum: a new fortnightly home-school update newsletter, expanded parent volunteer opportunities in the library and careers programme, and a pilot "shadowing day" where parents can spend a morning attending classes with their child.</p>
<p>We are grateful to every parent and educator who gave up their Saturday morning to invest in this conversation. The strength of our school lies in the quality of these partnerships, and events like this remind us of what is possible when a community comes together around a shared commitment to children's wellbeing.</p>
HTML,
            ],
            [
                'slug' => 'chinese-new-year-celebrations',
                'category' => 'Events',
                'title' => 'Chinese New Year Celebrations: A Campus Full of Colour',
                'excerpt' => 'From the lion dance to the lantern-making workshop, our Chinese New Year celebrations brought together the entire school community in a joyful and vibrant showcase of culture.',
                'featured_image' => '/images/student-1.jpg',
                'reading_time_minutes' => 2,
                'is_featured' => false,
                'published_at' => '2026-01-30 15:00:00',
                'body' => <<<'HTML'
<p>Our Chinese New Year celebrations this year were truly a feast for the senses. The campus was adorned with red lanterns and gold decorations from the first week of January, building anticipation for the main celebration day on 30 January — a full school assembly that brought together students, teachers, and family members in a joyful showcase of Chinese culture and tradition.</p>
<p>The highlight of the morning was undoubtedly the lion dance performance, brought to campus by a professional troupe from Kuala Lumpur, who delighted students with their acrobatic skill and vibrant costumes. The lions' visit to each classroom to "bless" the learning spaces had younger students absolutely thrilled.</p>
<blockquote><p>Seeing all the different cultures in our school come together to celebrate Chinese New Year — I felt so proud. This is what makes Aletheia special.</p><cite>— Ms. Tan Mei Ling, Year 4 Homeroom Teacher</cite></blockquote>
<p>Throughout the week, students participated in a series of enrichment activities including calligraphy workshops, lantern-making, a traditional food tasting session featuring tang yuan and nian gao, and a short play performed by our Drama Club based on the legend of Nian. Every activity was designed to be educational and cross-cultural, inviting students from all backgrounds to engage with and appreciate Chinese heritage.</p>
<p>Gong Xi Fa Cai from all of us at Aletheia Resource Center. May the Year of the Horse bring health, happiness, and great learning to all our families.</p>
HTML,
            ],
        ];
    }
}
