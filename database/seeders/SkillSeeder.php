<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            'Backend' => [
                'PHP' => 'php',
                'Laravel' => 'laravel',
                'Filament' => 'filament',
                'MySQL' => 'mysql',
                'REST APIs' => null,
                'Python' => 'python',
            ],
            'Frontend' => [
                'Tailwind CSS' => 'tailwindcss',
                'JavaScript' => 'javascript',
                'Alpine.js' => 'alpinedotjs',
                'Blade' => 'laravel',
                'PWA development' => 'pwa',
            ],
            'Tools' => [
                'Git / GitHub' => 'github',
                'SQLite' => 'sqlite',
                'Composer' => 'composer',
                'Vite' => 'vite',
            ],
        ];

        foreach ($skills as $category => $names) {
            $i = 0;
            foreach ($names as $name => $icon) {
                Skill::updateOrCreate(
                    ['name' => $name],
                    [
                        'category' => $category,
                        'icon' => $icon,
                        'sort_order' => $i++,
                    ],
                );
            }
        }
    }
}
