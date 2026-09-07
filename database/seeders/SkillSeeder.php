<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            'Backend' => ['PHP', 'Laravel', 'Filament', 'MySQL', 'REST APIs', 'Python'],
            'Frontend' => ['Tailwind CSS', 'JavaScript', 'Alpine.js', 'Blade', 'PWA development'],
            'Tools' => ['Git / GitHub', 'SQLite', 'Composer', 'Vite'],
        ];

        $proficiency = [
            'PHP' => 92, 'Laravel' => 90, 'Filament' => 85, 'MySQL' => 85, 'REST APIs' => 82, 'Python' => 75,
            'Tailwind CSS' => 88, 'JavaScript' => 80, 'Alpine.js' => 80, 'Blade' => 90, 'PWA development' => 75,
            'Git / GitHub' => 85, 'SQLite' => 80, 'Composer' => 82, 'Vite' => 72,
        ];

        foreach ($skills as $category => $names) {
            foreach ($names as $i => $name) {
                Skill::updateOrCreate(
                    ['name' => $name],
                    [
                        'category' => $category,
                        'proficiency' => $proficiency[$name] ?? null,
                        'sort_order' => $i,
                    ],
                );
            }
        }
    }
}
