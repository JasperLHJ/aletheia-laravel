<?php

namespace Database\Seeders;

use App\Models\Educator;
use Illuminate\Database\Seeder;

class EducatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Educator::query()->update(['is_principal' => false]);

        $principal = [
            'name' => 'Dr. Sarah Lim Wei Ling',
            'title' => 'Principal',
            'image' => '/images/student-1.jpg',
            'bio' => 'With over 25 years in education leadership, Dr. Lim has dedicated her career to building learning communities where every student is known, valued, and challenged. Under her stewardship, Aletheia Resource Center has grown into one of the region\'s most respected institutions.',
            'detail' => 'She holds a doctorate in educational leadership and has spoken internationally on inclusive pedagogy and whole-school wellbeing. Dr. Lim mentors department heads directly, champions data-informed improvement cycles, and partners with families to ensure continuity between home and school. Her vision centres on graduates who are academically capable, ethically grounded, and prepared to serve their communities.',
            'is_principal' => true,
            'status' => 'published',
            'sort_order' => 0,
        ];

        $teachers = [
            [
                'name' => 'Mr. James Okonkwo',
                'title' => 'Head of Sciences',
                'image' => '/images/class-1.jpg',
                'bio' => 'Cambridge-trained physicist with a passion for inquiry-based learning and student-led research.',
                'detail' => 'Mr. Okonkwo leads the science faculty in designing lab-rich sequences that mirror real investigative practice. He coordinates regional science fairs, supports students pursuing Olympiad pathways, and works closely with mathematics colleagues to strengthen quantitative reasoning across the curriculum.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Ms. Aisyah Rahman',
                'title' => 'Head of Languages',
                'image' => '/images/class-2.jpg',
                'bio' => 'Multilingual educator specialising in English literature and creative writing programmes.',
                'detail' => 'Ms. Rahman curates a reading culture that spans classical and contemporary voices, with particular attention to Southeast Asian literature. She oversees debate and public-speaking electives, coaches students for international language assessments, and leads professional learning on formative feedback in writing.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Mr. David Chen',
                'title' => 'Head of Mathematics',
                'image' => '/images/class-3.jpg',
                'bio' => 'Award-winning mathematics educator focused on developing problem-solving and analytical skills.',
                'detail' => 'Mr. Chen structures the mathematics programme around reasoning, representation, and resilience. He has introduced cross-curricular modelling projects with the sciences and economics teams, and runs extension workshops for students preparing for advanced examinations and competitions.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Ms. Priya Nair',
                'title' => 'Head of Humanities',
                'image' => '/images/student-1.jpg',
                'bio' => 'History and geography specialist who brings global perspectives into the classroom.',
                'detail' => 'Ms. Nair integrates source-based inquiry and field learning so students connect local histories to wider global patterns. She facilitates Model United Nations and service-learning partnerships, and guides the faculty in embedding digital humanities tools without losing depth of disciplinary thought.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Mr. Thomas Lee',
                'title' => 'Head of Co-Curricular',
                'image' => '/images/class-1.jpg',
                'bio' => 'Former national athlete driving holistic student development through sports and leadership.',
                'detail' => 'Mr. Lee oversees teams, performing arts, and outdoor education, aligning each programme with leadership and character outcomes. He mentors student captains, coordinates inter-school fixtures safely and inclusively, and works with the wellbeing team when co-curricular load needs balancing with academics.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Ms. Fatimah Zahra',
                'title' => 'Head of Student Wellbeing',
                'image' => '/images/class-2.jpg',
                'bio' => 'Certified counsellor and pastoral care leader ensuring every student thrives emotionally and socially.',
                'detail' => 'Ms. Zahra leads the school\'s pastoral structure, early support protocols, and partnerships with external professionals. She trains staff in trauma-informed practice, facilitates peer-support initiatives, and maintains confidential pathways so families know how to seek help early and confidently.',
                'sort_order' => 6,
            ],
        ];

        Educator::query()->updateOrCreate(
            ['name' => $principal['name'], 'title' => $principal['title']],
            $principal
        );

        foreach ($teachers as $row) {
            Educator::query()->updateOrCreate(
                ['name' => $row['name'], 'title' => $row['title']],
                array_merge($row, [
                    'is_principal' => false,
                    'status' => 'published',
                ])
            );
        }
    }
}
