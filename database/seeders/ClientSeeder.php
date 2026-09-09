<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Placeholder entries — no logo files, so the section falls back to initials.
        $clients = [
            ['name' => 'Rayan Digital', 'website_url' => 'https://example.com'],
            ['name' => 'Halabja Retail', 'website_url' => null],
            ['name' => 'Kurdistan News Network', 'website_url' => 'https://example.com'],
            ['name' => 'Zagros Tech', 'website_url' => 'https://example.com'],
            ['name' => 'Sulaymaniyah Bazaar', 'website_url' => null],
            ['name' => 'Erbil Software House', 'website_url' => 'https://example.com'],
            ['name' => 'Tigris Labs', 'website_url' => null],
            ['name' => 'Nishtiman Group', 'website_url' => 'https://example.com'],
        ];

        foreach ($clients as $i => $data) {
            Client::updateOrCreate(
                ['name' => $data['name']],
                array_merge($data, ['is_active' => true, 'sort_order' => $i + 1]),
            );
        }
    }
}
