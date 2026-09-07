<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'slug' => 'bloom-and-vine',
                'featured' => true,
                'sort_order' => 1,
                'tech_stack' => ['PHP', 'MySQL', 'Tailwind CSS', 'Vanilla JavaScript'],
                'live_demo_url' => null,
                'github_url' => null,
                'is_public_github' => false,
                'title' => ['en' => 'Bloom & Vine'],
                'my_role' => ['en' => 'Solo full-stack developer — designed the database, built frontend and backend, authored full technical documentation'],
                'problem' => ['en' => 'Small Kurdish businesses lack e-commerce platforms that properly support both Kurdish (RTL) and English in one seamless store.'],
                'what_i_built' => ['en' => 'A full bilingual B2C e-commerce platform with RTL layout, role-based access control, PWA install support, and integrated FIB payment gateway.'],
                'key_features' => ['en' => [
                    'RTL/LTR layout switching',
                    'Role-based access control',
                    'Installable PWA',
                    'Secure payment integration (FIB)',
                ]],
                'outcome' => ['en' => 'Submitted and accepted as university graduation thesis; a fully functional bilingual store with live payment integration.'],
            ],
            [
                'slug' => 'trilingual-news-platform',
                'featured' => true,
                'sort_order' => 2,
                'tech_stack' => ['Laravel', 'Filament', 'MySQL'],
                'live_demo_url' => null,
                'github_url' => null,
                'is_public_github' => false,
                'title' => ['en' => 'Trilingual News Platform'],
                'my_role' => ['en' => 'Full-stack developer — built the public site and the entire admin panel'],
                'problem' => ['en' => 'Kurdish news outlets need a CMS that lets non-technical editors publish in three languages without friction.'],
                'what_i_built' => ['en' => 'A news website with a custom Filament-based admin panel supporting Kurdish, English, and Arabic content.'],
                'key_features' => ['en' => [
                    'Multi-language article publishing',
                    'Custom admin dashboard',
                    'Clean editorial workflow',
                ]],
                'outcome' => ['en' => 'Editors can publish and manage content across three languages from a single dashboard.'],
            ],
            [
                'slug' => 'offline-pos-cashier-system',
                'featured' => true,
                'sort_order' => 3,
                'tech_stack' => ['Python', 'SQLite', 'PyWebView'],
                'live_demo_url' => null,
                'github_url' => null,
                'is_public_github' => false,
                'title' => ['en' => 'Offline POS / Cashier System'],
                'my_role' => ['en' => 'Solo developer — full system design and implementation'],
                'problem' => ['en' => 'Small local markets need a reliable point-of-sale system that works fully offline, in Kurdish, with Iraqi Dinar pricing.'],
                'what_i_built' => ['en' => 'A single-PC offline cashier system with barcode scanning, batch-based stock tracking (FIFO / nearest-expiry), and role-based permissions.'],
                'key_features' => ['en' => [
                    'Barcode scanning',
                    'Expiry & batch management',
                    'Multi-tab sales',
                    'Customer returns with stock restoration',
                    'Kurdish UI',
                ]],
                'outcome' => ['en' => 'A complete offline retail solution tailored to real market operations, with no server or internet dependency.'],
            ],
        ];

        foreach ($projects as $data) {
            Project::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
