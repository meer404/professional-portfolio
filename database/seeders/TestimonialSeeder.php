<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Sarah Ahmed',
                'role' => 'Product Manager',
                'company' => 'Rayan Digital',
                'rating' => 5,
                'body' => 'Mir shipped our bilingual store ahead of schedule and handled the tricky RTL details without being asked. Communication was clear the whole way through.',
            ],
            [
                'name' => 'David Karim',
                'role' => 'Founder',
                'company' => 'Halabja Retail',
                'rating' => 5,
                'body' => 'The offline POS system just works. Our cashiers picked it up in a day, and we have had zero downtime since it went live.',
            ],
            [
                'name' => 'Lana Hassan',
                'role' => 'Editor-in-Chief',
                'company' => 'Kurdistan News Network',
                'rating' => 4,
                'body' => 'Our editors now publish across three languages from one dashboard. The admin panel Mir built is genuinely a pleasure to use.',
            ],
        ];

        foreach ($testimonials as $i => $data) {
            Testimonial::updateOrCreate(
                ['name' => $data['name']],
                array_merge($data, ['is_active' => true, 'sort_order' => $i + 1]),
            );
        }
    }
}
